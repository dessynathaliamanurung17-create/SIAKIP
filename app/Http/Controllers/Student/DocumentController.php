<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentEncryptor;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class DocumentController extends Controller
{
    public function index()
    {
        $application = Auth::user()->mahasiswa?->application;
        $documents = $application ? $application->documents->keyBy('jenis') : collect();

        return view('student.dokumen', compact('application', 'documents'));
    }

    public function store(Request $request, DocumentEncryptor $encryptor)
    {
        $request->validate([
            'jenis'  => ['required', 'in:kk,ktm,penghasilan,lainnya'],
            'berkas' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'], // maks 2 MB
        ]);

        $application = Auth::user()->mahasiswa?->application;
        if (! $application) {
            return back()->withErrors(['berkas' => 'Isi form pendaftaran Beasiswa terlebih dahulu.']);
        }

        // hanya pemilik, dan hanya selama status masih draft
        Gate::authorize('update', $application);

        $meta = $encryptor->store($request->file('berkas'));

        $doc = $application->documents()->where('jenis', $request->jenis)->first() ?? new Document();
        $oldPath = $doc->path;

        $doc->fill([
            'application_id' => $application->id,
            'jenis'          => $request->jenis,
            'path'           => $meta['path'],
            'nama_asli'      => preg_replace('/[^A-Za-z0-9._-]/', '_', $request->file('berkas')->getClientOriginalName()),
            'mime'           => $meta['mime'],
            'ukuran'         => $meta['ukuran'],
            'sha256'         => $meta['sha256'],
        ]);
        $doc->status_verifikasi = 'menunggu';   // upload ulang = harus diverifikasi ulang
        $doc->catatan = null;
        $doc->save();

        if ($oldPath) {
            $encryptor->delete($oldPath);
        }

        return back()->with('status', 'Dokumen berhasil diunggah dan dienkripsi.');
    }

    public function download(Document $document, DocumentEncryptor $encryptor)
    {
        Gate::authorize('view', $document);   // pemilik atau admin, selain itu 403

        try {
            $plain = $encryptor->read($document->path);
        } catch (DecryptException $e) {
            abort(500, 'Berkas tidak dapat didekripsi (rusak atau diubah).');
        }

        // cek integritas: hash sekarang harus sama dengan hash saat upload
        if (! hash_equals($document->sha256, hash('sha256', $plain))) {
            abort(500, 'Integritas berkas gagal: isi berkas telah berubah.');
        }

        return response()->streamDownload(
            fn () => print($plain),
            $document->nama_asli,
            [
                'Content-Type'           => $document->mime ?? 'application/octet-stream',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }
}