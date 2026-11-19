<?php

namespace App\Console\Commands;

use App\Services\AuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Process\Process;

class RestoreDatabase extends Command
{
    protected $signature = 'db:restore {file : nama file, contoh backup_20261120_020000.sql.enc}';
    protected $description = 'Pulihkan database dari backup (cek integritas SHA-256 dulu)';

    public function handle(): int
    {
        $dir  = storage_path('app/private/backups');
        $path = $dir . '/' . basename($this->argument('file'));   // basename: cegah path traversal

        if (! is_file($path)) {
            $this->error('File backup tidak ditemukan.');
            return self::FAILURE;
        }

        $sql  = Crypt::decryptString(file_get_contents($path));
        $hash = trim((string) @file_get_contents(str_replace('.sql.enc', '.sha256', $path)));

        if (! hash_equals($hash, hash('sha256', $sql))) {
            $this->error('Integritas backup GAGAL: isi berkas berubah. Restore dibatalkan.');
            return self::FAILURE;
        }

        if (! $this->confirm('Database saat ini akan ditimpa. Lanjutkan?')) {
            return self::FAILURE;
        }

        $cfg  = config('database.connections.mysql');
        $proc = new Process([
            env('MYSQL_PATH', 'mysql'),
            '--host=' . $cfg['host'],
            '--port=' . $cfg['port'],
            '--user=' . $cfg['username'],
            $cfg['database'],
        ], null, ['MYSQL_PWD' => (string) ($cfg['password'] ?? '')]);
        $proc->setInput($sql);
        $proc->setTimeout(300);
        $proc->run();

        if (! $proc->isSuccessful()) {
            $this->error('Restore gagal: ' . $proc->getErrorOutput());
            return self::FAILURE;
        }

        AuditLogger::record('restore_database', null, null, ['file' => basename($path)]);
        $this->info('Database berhasil dipulihkan.');
        return self::SUCCESS;
    }
}