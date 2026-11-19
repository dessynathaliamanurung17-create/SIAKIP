
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{//untuk menjalankan perubahan database
    public function up(): void

{//buat tebel mahasiswa
    Schema::create('mahasiswa', function (Blueprint $table) 
{//nim sebagai PK (primary key)
    $table->string('nim', 20)->primary();

//foreing key (relasi tabel)
    $table->foreignId('user_id')
    ->unique()
//menghubungkan dengan tabel user
    ->constrained('users')
    ->cascadeOnDelete();

//membuat kolom jurusan
    $table->string('jurusan')->nullable();
//membuat kolom prodi
    $table->string('program_studi')->nullable();
//membat kolom no_hp
    $table->string('no_hp', 20)->nullable();
//untuk nyimpan waktu pertama kali data dibuat
    $table->timestamps();
});
}
    public function down(): void
{
    Schema::dropIfExists('mahasiswa');
}
};
