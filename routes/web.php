<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DocumentController;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn () => view('welcome'));

// satu pintu: setelah login diarahkan sesuai role
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('mahasiswa.dashboard');
})->middleware('auth')->name('dashboard');


Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn () => view('student.dashboard'))->name('dashboard');
    // Dessy menambah route form pendaftaran & dokumen di sini
     Route::get('/dokumen', [DocumentController::class, 'index'])->name('dokumen');
    Route::post('/dokumen', [DocumentController::class, 'store'])->name('dokumen.store');
});

// unduh: boleh mahasiswa pemilik atau admin (dicek oleh Policy)
Route::get('/dokumen/{document}/unduh', [DocumentController::class, 'download'])
    ->middleware(['auth', 'throttle:20,1'])
    ->name('dokumen.unduh');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit-log');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
