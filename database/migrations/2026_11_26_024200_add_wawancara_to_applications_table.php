<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('status_wawancara', 30)->default('belum')->after('hasil_verifikasi');
            $table->string('jadwal_wawancara', 150)->nullable()->after('status_wawancara');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['status_wawancara', 'jadwal_wawancara']);
        });
    }
};
