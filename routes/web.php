<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\FaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\Student\ApplicationController;


Route::get('/', function () {
    $penerimaAktif = \App\Models\Application::where('hasil_akhir', 'diterima')->count();

    return view('welcome', compact('penerimaAktif'));
});

// satu pintu: setelah login diarahkan sesuai role
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('mahasiswa.dashboard');
})->middleware('auth')->name('dashboard');

// verifikasi wajah (hanya mahasiswa, belum perlu face.verified)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('face')->name('face.')->group(function () {
    Route::get('/daftar', [FaceController::class, 'enrollForm'])->name('enroll');
    Route::post('/daftar', [FaceController::class, 'enroll'])->middleware('throttle:5,1')->name('enroll.store');
    Route::get('/verifikasi', [FaceController::class, 'verifyForm'])->name('verify');
    Route::post('/verifikasi', [FaceController::class, 'verify'])->middleware('throttle:5,1')->name('verify.store');
});

Route::get('/health', [HealthController::class, 'publik'])
    ->withoutMiddleware([
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ]);


// area mahasiswa: wajib login + role + wajah terverifikasi
Route::middleware(['auth', 'role:mahasiswa', 'face.verified'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [ApplicationController::class, 'dashboard'])->name('dashboard');
    Route::get('/pendaftaran', [ApplicationController::class, 'form'])->name('pendaftaran');
    Route::post('/pendaftaran', [ApplicationController::class, 'store'])->name('pendaftaran.store');
    Route::get('/status', [ApplicationController::class, 'status'])->name('status');

    Route::get('/dokumen', [DocumentController::class, 'index'])->name('dokumen');
    Route::post('/dokumen', [DocumentController::class, 'store'])->name('dokumen.store');
});

// unduh: mahasiswa pemilik (harus lolos wajah) atau admin, dicek oleh Policy
Route::get('/dokumen/{document}/unduh', [DocumentController::class, 'download'])
    ->middleware(['auth', 'face.verified', 'throttle:20,1'])
    ->name('dokumen.unduh');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');
    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit-log');

    Route::get('/pelamar', [AdminApplicationController::class, 'index'])->name('pelamar');
    Route::get('/pelamar/export', [AdminApplicationController::class, 'export'])->middleware('throttle:10,1')->name('pelamar.export');
    Route::get('/pelamar/{application}', [AdminApplicationController::class, 'show'])->name('pelamar.show');
    Route::put('/pelamar/{application}/seleksi', [AdminApplicationController::class, 'updateSeleksi'])->name('pelamar.seleksi');

    Route::get('/verifikasi', [AdminApplicationController::class, 'verifikasi'])->name('verifikasi');
    Route::put('/dokumen/{document}/verifikasi', [AdminApplicationController::class, 'verifikasiDokumen'])->name('dokumen.verifikasi');

    Route::get('/sistem', [HealthController::class, 'sistem'])->name('sistem');
Route::post('/sistem/backup', [HealthController::class, 'backup'])->middleware('throttle:3,1')->name('sistem.backup');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/foto-profil/{mahasiswa}', [ProfileController::class, 'foto'])->name('foto.profil');
});

require __DIR__.'/auth.php';