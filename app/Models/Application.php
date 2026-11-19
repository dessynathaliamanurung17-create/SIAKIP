<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'mahasiswa_nim', 'ipk', 'semester', 'riwayat_prestasi', 'riwayat_beasiswa',
        'penghasilan_ortu', 'pekerjaan_ortu', 'jumlah_tanggungan', 'kondisi_ekonomi',
    ];
    // status, hasil_verifikasi, skor, hasil_akhir sengaja TIDAK fillable:
    // hanya diubah admin lewat kode khusus, bukan mass assignment dari form mahasiswa.

    protected $casts = [
        'penghasilan_ortu'  => 'encrypted',
        'pekerjaan_ortu'    => 'encrypted',
        'jumlah_tanggungan' => 'encrypted',
        'kondisi_ekonomi'   => 'encrypted',
    ];

    public function mahasiswa() { return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim'); }
    public function documents() { return $this->hasMany(Document::class); }
}