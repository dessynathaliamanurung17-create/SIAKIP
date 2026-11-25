<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Halaman login umum (khusus mahasiswa).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login mahasiswa — akun admin DILARANG masuk lewat /login umum.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if ($request->user()->isAdmin()) {
            AuditLogger::record('login_admin_ditolak_di_portal_umum', $request->user());

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi tidak valid.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('mahasiswa.dashboard', absolute: false));
    }

    /**
     * Halaman login khusus administrator (/portal-admin-sibeka).
     */
    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Proses login khusus administrator — hanya role admin yang diizinkan.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (! $request->user()->isAdmin()) {
            AuditLogger::record('percobaan_login_admin_ilegal', $request->user());

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Kredensial administrator tidak valid.',
            ]);
        }

        $request->session()->regenerate();
        AuditLogger::record('login_admin_berhasil', $request->user());

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
