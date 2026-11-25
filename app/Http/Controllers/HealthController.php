<?php

namespace App\Http\Controllers;

use App\Services\AuditLogger;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    private function cek(): array
    {
        $hasil = [];

        try {
            $t = microtime(true);
            DB::select('select 1');
            $hasil['database'] = ['ok' => true, 'info' => round((microtime(true) - $t) * 1000, 1) . ' ms'];
        } catch (\Throwable $e) {
            $hasil['database'] = ['ok' => false, 'info' => 'tidak dapat terhubung'];
        }

        $hasil['storage'] = [
            'ok'   => is_writable(storage_path('app/private')),
            'info' => is_writable(storage_path('app/private')) ? 'dapat ditulis' : 'tidak dapat ditulis',
        ];

        $bebas = @disk_free_space(storage_path());
        $hasil['disk'] = [
            'ok'   => $bebas !== false && $bebas > 200 * 1024 * 1024,
            'info' => $bebas !== false ? round($bebas / 1024 / 1024 / 1024, 2) . ' GB tersisa' : 'tidak diketahui',
        ];

        $backups = glob(storage_path('app/private/backups/backup_*.sql.enc')) ?: [];
        sort($backups);
        $terakhir = $backups ? filemtime(end($backups)) : null;
        $hasil['backup'] = [
            'ok'   => $terakhir !== null && (time() - $terakhir) < 26 * 3600,
            'info' => $terakhir ? 'terakhir ' . date('Y-m-d H:i', $terakhir) . ' (' . count($backups) . ' berkas)' : 'belum ada backup',
        ];

        return $hasil;
    }

    // publik: hanya status, tanpa detail internal
    public function publik()
    {
        $h  = $this->cek();
        $ok = $h['database']['ok'] && $h['storage']['ok'];

        return response()->json(['status' => $ok ? 'ok' : 'error'], $ok ? 200 : 503);
    }

    // admin: detail lengkap
    public function sistem()
    {
        return view('admin.sistem', ['cek' => $this->cek()]);
    }

    public function backup()
    {
        $kode = Artisan::call('db:backup');
        AuditLogger::record('backup_manual');

        if ($kode === 0) {
            return back()->with('status', 'Backup database terenkripsi berhasil dibuat.');
        }

        return back()->with('error', 'Backup gagal dijalankan. Periksa koneksi database atau konfigurasi MYSQLDUMP_PATH.');
    }
}