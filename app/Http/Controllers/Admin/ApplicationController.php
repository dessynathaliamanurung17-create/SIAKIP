<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('mahasiswa.user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15)->withQueryString();

        return view('admin.pelamar', compact('applications'));
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

    public function verifikasi()
    {
        $documents = Document::with('application.mahasiswa.user')
            ->where('status_verifikasi', 'menunggu')
            ->latest()
            ->paginate(20);

        return view('admin.verifikasi', compact('documents'));
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