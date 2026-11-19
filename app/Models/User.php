<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

//Kolom yang boleh diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',];
//Kolom yang disembunyikan.
//Password dan remember_token tidak boleh
//ditampilkan ketika data User diubah menjadi JSON.
    protected $hidden = [
        'password',
        'remember_token',];

 //Menentukan tipe data beberapa kolom.
    protected function casts(): array
{
    return [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    ];
}

//relasi user dengan akun mahasiswa
    public function mahasiswa()
{
    return $this->hasOne(Mahasiswa::class, 'user_id', 'id');
}}