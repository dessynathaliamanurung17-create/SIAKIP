<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('application_id')->constrained()->cascadeOnDelete();
    $table->string('jenis');            // kk, ktm, penghasilan, lainnya
    $table->string('path');             // lokasi file terenkripsi
    $table->string('nama_asli');
    $table->string('mime')->nullable();
    $table->unsignedBigInteger('ukuran')->nullable();
    $table->string('sha256', 64);       // hash file asli, untuk cek integritas
    $table->string('status_verifikasi')->default('menunggu'); // menunggu, valid, tidak_valid
    $table->text('catatan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
