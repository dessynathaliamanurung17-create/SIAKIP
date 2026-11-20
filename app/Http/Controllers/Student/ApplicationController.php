<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function dashboard()
    {
        $mhs = auth()->user()->mahasiswa;
        $application = $mhs?->application;
        $jumlahDokumen = $application ? $application->documents()->count() : 0;

        return view('student.dashboard', compact('mhs', 'application', 'jumlahDokumen'));
    }

    public function form()
    {
        $mhs = auth()->user()->mahasiswa;
        $application = $mhs->application;

        return view('student.pendaftaran', compact('mhs', 'application'));
    }

    public function store(Request $request)
    {
        $mhs = auth()->user()->mahasiswa;
        $application = $mhs->application;

        // hanya pemilik, dan hanya selama status draft
        if ($application) {
            Gate::authorize('update', $application);
        }

        $data = $request->validate([
            'ipk'               => ['required', 'numeric', 'between:0,4'],
            'semester'          => ['required', 'integer', 'between:1,14'],
            'riwayat_prestasi'  => ['nullable', 'string', 'max:1000'],
            'riwayat_beasiswa'  => ['nullable', 'string', 'max:1000'],
            'penghasilan_ortu'  => ['required', 'numeric', 'min:0'],
            'pekerjaan_ortu'    => ['required', 'string', 'max:100'],
            'jumlah_tanggungan' => ['required', 'integer', 'between:1,20'],
            'kondisi_ekonomi'   => ['required', 'string', 'max:500'],
        ]);

        $application ??= new Application(['mahasiswa_nim' => $mhs->nim]);
        $application->fill($data);
        $application->save();   // status, skor, hasil_akhir tidak fillable: tidak bisa diubah dari form

        if ($request->input('aksi') === 'ajukan') {
            $jenis = $application->documents()->pluck('jenis')->all();
            $kurang = array_diff(['kk', 'ktm', 'penghasilan'], $jenis);

            if ($kurang) {
                return back()->withErrors([
                    'aksi' => 'Data tersimpan sebagai draft. Unggah dulu dokumen wajib: ' . implode(', ', $kurang) . '.',
                ]);
            }

            $application->status = 'diajukan';
            $application->save();

            return redirect()->route('mahasiswa.status')->with('status', 'Pendaftaran berhasil diajukan.');
        }

        return back()->with('status', 'Draft tersimpan.');
    }

    public function status()
    {
        $application = auth()->user()->mahasiswa?->application;

        return view('student.status', compact('application'));
    }
}