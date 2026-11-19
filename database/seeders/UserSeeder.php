<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
//menghubungkan seeder dengan model
use App\Models\User;
use App\Models\Mahasiswa;
// Menggunakan Hash untuk mengamankan password
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
// Membuat data awal User dan Mahasiswa.
    public function run(): void
{
 // Membuat akun Admin
    User::create ([
    'name' => 'Admin KIP',
    'email' => 'admin@kipkampus.com',
    'password' =>hash::make('password'),
    'role' => 'admin',
]);

// Membuat akun Mahasiswa
    $user = User::create([
    'name' => 'Budi Mahasiswa',
    'email' => 'budi@gmail.com',
    'password' =>hash::make('password'),
    'role' => 'mahasiswa',
]);

// Membuat akun mahasiswa
    Mahasiswa::create([
    'nim' => '231234567',
    'user_id' => $user->id,
    'jurusan' => 'Teknik Informatika',
    'program_studi' => 'Informatika',
    'no_hp' => '08123456789',
]);
}}