<?php

namespace App\Console\Commands;

use App\Services\AuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup {--keep=7 : jumlah backup yang disimpan}';
    protected $description = 'Backup database (terenkripsi AES + hash SHA-256 + retensi)';

    public function handle(): int
    {
        $dir = storage_path('app/private/backups');
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $nama  = 'backup_' . now()->format('Ymd_His');
        $plain = "$dir/$nama.sql";
        $cfg   = config('database.connections.mysql');

        $proc = new Process([
            env('MYSQLDUMP_PATH', 'mysqldump'),
            '--host=' . $cfg['host'],
            '--port=' . $cfg['port'],
            '--user=' . $cfg['username'],
            '--single-transaction',
            '--result-file=' . $plain,
            $cfg['database'],
        ], null, ['MYSQL_PWD' => (string) ($cfg['password'] ?? '')]);
        $proc->setTimeout(300);
        $proc->run();

        if (! $proc->isSuccessful() || ! is_file($plain)) {
            $this->error('Backup gagal: ' . $proc->getErrorOutput());
            return self::FAILURE;
        }

        $isi  = file_get_contents($plain);
        $hash = hash('sha256', $isi);

        file_put_contents("$dir/$nama.sql.enc", Crypt::encryptString($isi));
        file_put_contents("$dir/$nama.sha256", $hash);
        unlink($plain);   // file mentah tidak disimpan

        // retensi: hapus backup lama
        $semua = glob("$dir/backup_*.sql.enc");
        sort($semua);
        foreach (array_slice($semua, 0, max(0, count($semua) - (int) $this->option('keep'))) as $lama) {
            @unlink($lama);
            @unlink(str_replace('.sql.enc', '.sha256', $lama));
        }

        AuditLogger::record('backup_database', null, null, ['file' => "$nama.sql.enc"]);
        $this->info("Backup selesai: $nama.sql.enc");
        return self::SUCCESS;
    }
}