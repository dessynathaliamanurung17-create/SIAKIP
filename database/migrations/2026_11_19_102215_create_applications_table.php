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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_nim', 20)->unique();
            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswa')->cascadeOnDelete();

            // data akademik
            $table->decimal('ipk', 3, 2);
            $table->unsignedTinyInteger('semester');
            $table->text('riwayat_prestasi')->nullable();
            $table->text('riwayat_beasiswa')->nullable();

            // data ekonomi (terenkripsi lewat cast)
            $table->text('penghasilan_ortu');
            $table->text('pekerjaan_ortu');
            $table->text('jumlah_tanggungan');
            $table->text('kondisi_ekonomi');

            // proses seleksi
            $table->string('status')->default('draft'); // draft, diajukan, diverifikasi, ditolak
            $table->text('hasil_verifikasi')->nullable();
            $table->decimal('skor', 5, 2)->nullable();
            $table->string('hasil_akhir')->nullable();  // diterima / ditolak

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
