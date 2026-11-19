<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
// Menjalankan proses pengisian data awal ke dalam database.
    public function run(): void
    {
// Menjalankan UserSeeder untuk membuat data akun pengguna
        $this->call(UserSeeder::class);
    }
}