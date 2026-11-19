<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    // Menentukan nama tabel di database
    protected $table = 'mahasiswa';

    // Menentukan NIM sebagai Primary Key
    protected $primaryKey = 'nim';

    // Primary Key tidak menggunakan angka otomatis
    public $incrementing = false;

    // Tipe Primary Key adalah string
    protected $keyType = 'string';

    // Kolom yang boleh diisi melalui Eloquent
    protected $fillable = [
        'nim',
        'user_id',
        'jurusan',
        'program_studi',
        'no_hp',
    ];

    protected $casts = [
        'face_descriptor' => 'encrypted',
    ];

    // Relasi mahasiswa dengan akun pengguna
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'mahasiswa_nim', 'nim');
    }
}
