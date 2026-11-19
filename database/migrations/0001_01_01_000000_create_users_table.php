<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// Fungsi untuk membuat tabel users
    public function up(): void
{
// Membuat tabel users
    Schema::create('users', function (Blueprint $table) {

// Membuat kolom id sebagai Primary Key
// Nilai id akan bertambah otomatis
    $table->id();

// Menyimpan nama pengguna
    $table->string('name');

// Menyimpan email pengguna
// unique() memastikan email tidak boleh sama
    $table->string('email')->unique();

// Menyimpan waktu verifikasi email
// nullable() berarti boleh kosong
    $table->timestamp('email_verified_at')->nullable();

// Menyimpan password pengguna
    $table->string('password');

// Membuat token untuk fitur Remember Me
     $table->rememberToken();

// Membuat kolom created_at dan updated_at
// Laravel mengisinya secara otomatis
    $table->timestamps();
});

// Membuat tabel untuk menyimpan token reset password
    Schema::create('password_reset_tokens', function (Blueprint $table) {

// Email sebagai Primary Key
    $table->string('email')->primary();

// Menyimpan token reset password
    $table->string('token');

// Menyimpan waktu pembuatan token
    $table->timestamp('created_at')->nullable();
});

// Membuat tabel sessions untuk menyimpan session pengguna
    Schema::create('sessions', function (Blueprint $table) {

// ID session sebagai Primary Key
    $table->string('id')->primary();

// Menghubungkan session dengan user
// nullable() berarti boleh kosong
    $table->foreignId('user_id')
    ->nullable()
    ->index();

// Menyimpan alamat IP pengguna
    $table->string('ip_address', 45)->nullable();

// Menyimpan informasi browser atau perangkat
    $table->text('user_agent')->nullable();

// Menyimpan data session
    $table->longText('payload');

// Menyimpan waktu aktivitas terakhir
    $table->integer('last_activity')->index();
});
}

    // Fungsi untuk membatalkan migration
    public function down(): void
{
// Menghapus tabel sessions
    Schema::dropIfExists('sessions');

// Menghapus tabel password_reset_tokens
    Schema::dropIfExists('password_reset_tokens');

// Menghapus tabel users
    Schema::dropIfExists('users');
}};