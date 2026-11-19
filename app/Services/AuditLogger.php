<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    // kolom yang isinya tidak boleh masuk log
    public const SENSITIVE = [
        'penghasilan_ortu', 'pekerjaan_ortu', 'jumlah_tanggungan',
        'kondisi_ekonomi', 'face_descriptor', 'password',
    ];

    public static function record(string $aksi, ?Model $model = null, ?array $lama = null, ?array $baru = null): void
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => $aksi,
            'tabel'      => $model?->getTable(),
            'record_id'  => $model?->getKey(),
            'data_lama'  => $lama,
            'data_baru'  => $baru,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
        ]);
    }

    public static function mask(array $data, bool $changed = false): array
    {
        foreach (self::SENSITIVE as $kolom) {
            if (array_key_exists($kolom, $data)) {
                $data[$kolom] = $changed ? '[diubah]' : '[terenkripsi]';
            }
        }
        unset($data['updated_at']);
        return $data;
    }
}