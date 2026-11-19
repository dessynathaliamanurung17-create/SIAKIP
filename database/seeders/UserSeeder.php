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
        // Membuat akun Admin (role di-set langsung, bukan lewat mass assignment)
        $admin = new User([
            'name'     => 'Admin Beasiswa',
            'email'    => 'admin@kipkampus.com',
            'password' => Hash::make('password'),
        ]);
        $admin->role = 'admin';
        $admin->save();

        // Membuat akun Mahasiswa
        $user = User::create([
            'name'     => 'Budi Mahasiswa',
            'email'    => 'budi@gmail.com',
            'password' => 'password',
        ]);

        // Membuat akun mahasiswa
        Mahasiswa::create([
            'nim' => '231234567',
            'user_id' => $user->id,
            'jurusan' => 'Teknik Informatika',
            'program_studi' => 'Informatika',
            'no_hp' => '08123456789',
        ]);
    }
}
