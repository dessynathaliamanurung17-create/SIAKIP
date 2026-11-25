<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Models\Mahasiswa;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function dashboard(Request $request)
    {
        // 1. Statistik utama
        $totalPendaftar      = Application::count();
        $berkasTerverifikasi = Application::where('status', 'diverifikasi')->count();
        $menungguVerifikasi  = Application::where('status', 'diajukan')->count();
        $totalDiterima       = Application::where('hasil_akhir', 'diterima')->count();
        $totalDitolak        = Application::where('status', 'ditolak')->orWhere('hasil_akhir', 'ditolak')->count();
        $totalDraft          = Application::where('status', 'draft')->count();
        $dokumenMenunggu     = Document::where('status_verifikasi', 'menunggu')->count();
        $totalMahasiswa      = Mahasiswa::count();
        $kuotaBeasiswa       = 200;
        $persenKuota         = $kuotaBeasiswa > 0 ? min(100, round(($totalDiterima / $kuotaBeasiswa) * 100, 1)) : 0;

        // 2. Distribusi pendaftar per jurusan (mendukung filter status)
        $distStatus = $request->input('dist_status');
        $distQuery = Application::query()
            ->join('mahasiswa', 'applications.mahasiswa_nim', '=', 'mahasiswa.nim')
            ->select('mahasiswa.jurusan', DB::raw('COUNT(applications.id) as total'))
            ->groupBy('mahasiswa.jurusan')
            ->orderByDesc('total');

        if (in_array($distStatus, ['diajukan', 'diverifikasi', 'draft', 'ditolak'], true)) {
            $distQuery->where('applications.status', $distStatus);
        } elseif ($distStatus === 'diterima') {
            $distQuery->where('applications.hasil_akhir', 'diterima');
        } else {
            $distStatus = null;
        }

        $distribusiJurusan = $distQuery->get();
        $totalDistribusi   = $distribusiJurusan->sum('total');
        $jumlahJurusan     = Mahasiswa::whereNotNull('jurusan')->where('jurusan', '!=', '')->distinct('jurusan')->count('jurusan');

        // 3. Daftar jurusan unik untuk dropdown filter tabel
        $daftarJurusan = Mahasiswa::query()
            ->whereNotNull('jurusan')
            ->where('jurusan', '!=', '')
            ->distinct()
            ->orderBy('jurusan')
            ->pluck('jurusan');

        // 4. Tabel antrean / pendaftar terbaru dengan pencarian & filter
        $query = Application::with(['mahasiswa.user', 'documents'])->latest();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('mahasiswa_nim', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('program_studi', 'like', "%{$search}%")
                            ->orWhere('jurusan', 'like', "%{$search}%")
                            ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
                    });
            });
        }

        if ($request->filled('jurusan')) {
            $jurusan = $request->input('jurusan');
            $query->whereHas('mahasiswa', fn ($mq) => $mq->where('jurusan', $jurusan));
        }

        if ($request->filled('status') && in_array($request->input('status'), ['draft', 'diajukan', 'diverifikasi', 'ditolak'], true)) {
            $query->where('status', $request->input('status'));
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'totalPendaftar',
            'berkasTerverifikasi',
            'menungguVerifikasi',
            'totalDiterima',
            'totalDitolak',
            'totalDraft',
            'dokumenMenunggu',
            'totalMahasiswa',
            'kuotaBeasiswa',
            'persenKuota',
            'distribusiJurusan',
            'totalDistribusi',
            'distStatus',
            'jumlahJurusan',
            'daftarJurusan',
            'applications'
        ));
    }

    private function buildPelamarQuery(Request $request)
    {
        $query = Application::with(['mahasiswa.user', 'documents'])->latest();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('mahasiswa_nim', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('program_studi', 'like', "%{$search}%")
                            ->orWhere('jurusan', 'like', "%{$search}%")
                            ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
                    });
            });
        }

        if ($request->filled('status') && in_array($request->input('status'), ['draft', 'diajukan', 'diverifikasi', 'ditolak'], true)) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('hasil_akhir')) {
            if ($request->input('hasil_akhir') === 'belum') {
                $query->whereNull('hasil_akhir');
            } elseif (in_array($request->input('hasil_akhir'), ['diterima', 'ditolak'], true)) {
                $query->where('hasil_akhir', $request->input('hasil_akhir'));
            }
        }

        return $query;
    }

    public function index(Request $request)
    {
        $applications = $this->buildPelamarQuery($request)->paginate(15)->withQueryString();

        return view('admin.pelamar', compact('applications'));
    }

    public function export(Request $request)
    {
        $applications = $this->buildPelamarQuery($request)->get();

        AuditLogger::record('export_pelamar');

        $filename = 'rekap-pelamar-sibeka-' . now()->format('Ymd-His') . '.csv';

        $safe = static function ($value): string {
            $str = (string) ($value ?? '');
            if ($str !== '' && in_array($str[0], ['=', '+', '-', '@'], true)) {
                return "'" . $str;
            }
            return $str;
        };

        return response()->streamDownload(function () use ($applications, $safe) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM agar Microsoft Excel membaca karakter dengan benar
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'NIM',
                'Nama Mahasiswa',
                'Email',
                'Jurusan',
                'Program Studi',
                'Semester',
                'IPK',
                'Status',
                'Skor',
                'Hasil Akhir',
                'Dokumen Valid',
                'Total Dokumen',
                'Tanggal Daftar',
            ]);

            foreach ($applications as $a) {
                $docs = $a->documents;
                fputcsv($out, [
                    $safe($a->mahasiswa_nim),
                    $safe($a->mahasiswa?->user?->name ?? '-'),
                    $safe($a->mahasiswa?->user?->email ?? '-'),
                    $safe($a->mahasiswa?->jurusan ?? '-'),
                    $safe($a->mahasiswa?->program_studi ?? '-'),
                    $a->semester,
                    number_format((float) $a->ipk, 2),
                    $a->status,
                    $a->skor !== null ? number_format((float) $a->skor, 2) : '-',
                    $a->hasil_akhir ?? 'belum ditetapkan',
                    $docs->where('status_verifikasi', 'valid')->count(),
                    $docs->count(),
                    optional($a->created_at)->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type'           => 'text/csv; charset=UTF-8',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function show(Application $application)
    {
        Gate::authorize('view', $application);

        $application->load('mahasiswa.user', 'documents');

        // membuka data sensitif juga dicatat
        AuditLogger::record('lihat_detail', $application);

        return view('admin.pelamar-show', compact('application'));
    }

    public function updateSeleksi(Request $request, Application $application)
    {
        $data = $request->validate([
            'status'           => ['required', 'in:draft,diajukan,diverifikasi,ditolak'],
            'hasil_verifikasi' => ['nullable', 'string', 'max:1000'],
            'skor'             => ['nullable', 'numeric', 'between:0,100'],
            'hasil_akhir'      => ['nullable', 'in:diterima,ditolak'],
        ]);

        // aturan integritas: hasil akhir hanya boleh ditetapkan jika semua dokumen valid
        if (! empty($data['hasil_akhir'])) {
            $docs = $application->documents;
            if ($docs->isEmpty() || $docs->where('status_verifikasi', '!=', 'valid')->isNotEmpty()) {
                return back()->withErrors([
                    'hasil_akhir' => 'Hasil akhir hanya bisa ditetapkan setelah semua dokumen berstatus valid.',
                ])->withInput();
            }
        }

        // kolom ini tidak fillable, sengaja di-set langsung oleh admin
        $application->status           = $data['status'];
        $application->hasil_verifikasi = $data['hasil_verifikasi'] ?? null;
        $application->skor             = $data['skor'] ?? null;
        $application->hasil_akhir      = $data['hasil_akhir'] ?? null;
        $application->save(); // observer mencatat siapa, kapan, apa yang berubah

        return back()->with('status', 'Data seleksi berhasil disimpan.');
    }

    public function verifikasi(Request $request)
    {
        $totalBerkas     = Document::count();
        $menungguCount   = Document::where('status_verifikasi', 'menunggu')->count();
        $validCount      = Document::where('status_verifikasi', 'valid')->count();
        $tidakValidCount = Document::where('status_verifikasi', 'tidak_valid')->count();

        $query = Document::with('application.mahasiswa.user');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('nama_asli', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhereHas('application', function ($aq) use ($search) {
                        $aq->where('mahasiswa_nim', 'like', "%{$search}%")
                            ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                                $mq->where('program_studi', 'like', "%{$search}%")
                                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
                            });
                    });
            });
        }

        if ($request->filled('status') && in_array($request->input('status'), ['menunggu', 'valid', 'tidak_valid'], true)) {
            $query->where('status_verifikasi', $request->input('status'));
        }

        // Prioritaskan dokumen yang masih menunggu di urutan teratas, lalu terbaru
        $documents = $query
            ->orderByRaw("CASE status_verifikasi WHEN 'menunggu' THEN 0 WHEN 'tidak_valid' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $firstPendingAppId = Document::where('status_verifikasi', 'menunggu')
            ->latest()
            ->value('application_id');

        return view('admin.verifikasi', compact(
            'documents',
            'totalBerkas',
            'menungguCount',
            'validCount',
            'tidakValidCount',
            'firstPendingAppId'
        ));
    }

    public function verifikasiDokumen(Request $request, Document $document)
    {
        $data = $request->validate([
            'status_verifikasi' => ['required', 'in:valid,tidak_valid'],
            'catatan'           => ['nullable', 'string', 'max:500'],
        ]);

        $document->status_verifikasi = $data['status_verifikasi'];
        $document->catatan           = $data['catatan'] ?? null;
        $document->save();

        return back()->with('status', 'Verifikasi dokumen disimpan.');
    }
}