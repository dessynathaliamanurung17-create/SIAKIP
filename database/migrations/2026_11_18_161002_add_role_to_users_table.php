
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
// //mengubah struktur tabel users yang sudah ada sehingga setiap yang daftar akun otomatis sebagai mahasiswa
   Schema::table('users', function (Blueprint $table) {
   $table->enum('role', ['admin', 'mahasiswa'])
   ->default('mahasiswa');
});
}
//untuk membatalkan perubahaan migration apabila diperlukan
   public function down(): void
{
   Schema::table('users', function (Blueprint $table) {
   $table->dropColumn('role');
});
}};
