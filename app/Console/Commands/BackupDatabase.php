<?php

namespace App\Console\Commands;

use App\Services\AuditLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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

        $isi = $this->dumpViaMysqldump($cfg, $plain);

        if ($isi === null) {
            try {
                $isi = $this->dumpViaPdo($cfg['database'] ?? 'database');
            } catch (\Throwable $e) {
                $this->error('Backup gagal: ' . $e->getMessage());
                return self::FAILURE;
            }
        }

        $hash = hash('sha256', $isi);

        file_put_contents("$dir/$nama.sql.enc", Crypt::encryptString($isi));
        file_put_contents("$dir/$nama.sha256", $hash);
        if (is_file($plain)) {
            @unlink($plain);   // file mentah tidak disimpan
        }

        // retensi: hapus backup lama
        $semua = glob("$dir/backup_*.sql.enc") ?: [];
        sort($semua);
        foreach (array_slice($semua, 0, max(0, count($semua) - (int) $this->option('keep'))) as $lama) {
            @unlink($lama);
            @unlink(str_replace('.sql.enc', '.sha256', $lama));
        }

        AuditLogger::record('backup_database', null, null, ['file' => "$nama.sql.enc"]);
        $this->info("Backup selesai: $nama.sql.enc");

        return self::SUCCESS;
    }

    private function resolveMysqldumpBinary(): ?string
    {
        $configured = env('MYSQLDUMP_PATH');
        if ($configured && is_file($configured)) {
            return $configured;
        }

        $patterns = [
            'C:/laragon/bin/mysql/*/bin/mysqldump.exe',
            'D:/laragon/bin/mysql/*/bin/mysqldump.exe',
            'C:/xampp/mysql/bin/mysqldump.exe',
            'D:/xampp/mysql/bin/mysqldump.exe',
            'C:/Program Files/MySQL/*/bin/mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ];

        foreach ($patterns as $pattern) {
            $matches = glob($pattern) ?: [];
            if (! empty($matches)) {
                return end($matches);
            }
        }

        return null;
    }

    private function dumpViaMysqldump(array $cfg, string $plain): ?string
    {
        $binary = $this->resolveMysqldumpBinary();
        if (! $binary) {
            return null;
        }

        $proc = new Process([
            $binary,
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
            if (is_file($plain)) {
                @unlink($plain);
            }
            return null;
        }

        $isi = file_get_contents($plain);
        @unlink($plain);

        return $isi !== false ? $isi : null;
    }

    private function dumpViaPdo(string $database): string
    {
        $pdo = DB::connection()->getPdo();
        $out = "-- SIBEKA SQL Backup (PDO Fallback)\n";
        $out .= "-- Database: `{$database}`\n";
        $out .= '-- Generated: ' . now()->toDateTimeString() . "\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $createRow = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            $createSql = $createRow['Create Table'] ?? array_values($createRow)[1] ?? '';

            $out .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $out .= $createSql . ";\n\n";

            $stmt = $pdo->query("SELECT * FROM `{$table}`");
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $cols = array_map(fn ($col) => "`{$col}`", array_keys($row));
                $vals = array_map(function ($val) use ($pdo) {
                    return $val === null ? 'NULL' : $pdo->quote((string) $val);
                }, array_values($row));

                $out .= 'INSERT INTO `' . $table . '` (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $vals) . ");\n";
            }
            $out .= "\n";
        }

        $out .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $out;
    }
}
