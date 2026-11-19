<?php

namespace App\Http\Controllers;

use App\Services\AuditLogger;
use Illuminate\Http\Request;

class FaceController extends Controller
{
    private const THRESHOLD = 0.35;   // makin kecil makin ketat (rentang wajar 0.45 - 0.6)

    public function enrollForm()
    {
        $mhs = auth()->user()->mahasiswa;

        // sudah punya wajah: harus lolos verifikasi dulu sebelum boleh mengganti
        if ($mhs->face_descriptor && ! session('face_verified')) {
            return redirect()->route('face.verify');
        }

        return view('face.index', ['mode' => 'enroll', 'url' => route('face.enroll.store')]);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'descriptor'   => ['required', 'array', 'size:128'],
            'descriptor.*' => ['required', 'numeric'],
        ]);

        $mhs = auth()->user()->mahasiswa;

        if ($mhs->face_descriptor && ! session('face_verified')) {
            abort(403, 'Verifikasi wajah dulu sebelum mengganti data wajah.');
        }

        $mhs->face_descriptor = json_encode(array_map('floatval', $request->descriptor));
        $mhs->save();   // observer mencatat [diubah], bukan isinya

        session(['face_verified' => true]);
        AuditLogger::record('face_daftar', $mhs);

        return response()->json(['ok' => true, 'redirect' => route('mahasiswa.dashboard')]);
    }

    public function verifyForm()
    {
        $mhs = auth()->user()->mahasiswa;

        if (! $mhs->face_descriptor) {
            return redirect()->route('face.enroll');
        }

        return view('face.index', ['mode' => 'verify', 'url' => route('face.verify.store')]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'descriptor'   => ['required', 'array', 'size:128'],
            'descriptor.*' => ['required', 'numeric'],
        ]);

        $mhs = auth()->user()->mahasiswa;
        $stored = json_decode($mhs->face_descriptor ?? '[]', true);

        if (count($stored) !== 128) {
            return response()->json(['ok' => false, 'message' => 'Wajah belum terdaftar.'], 422);
        }

        // jarak Euclidean antara descriptor tersimpan dan yang baru
        $sum = 0.0;
        foreach ($stored as $i => $v) {
            $sum += ($v - (float) $request->descriptor[$i]) ** 2;
        }
        $jarak = sqrt($sum);

        if ($jarak < self::THRESHOLD) {
            session(['face_verified' => true]);
            AuditLogger::record('face_berhasil', $mhs, null, ['jarak' => round($jarak, 3)]);

            return response()->json(['ok' => true, 'redirect' => route('mahasiswa.dashboard')]);
        }

        AuditLogger::record('face_gagal', $mhs, null, ['jarak' => round($jarak, 3)]);

        return response()->json(['ok' => false, 'message' => 'Wajah tidak cocok.'], 422);
    }
}