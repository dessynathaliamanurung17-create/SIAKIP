<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load('mahasiswa.application');

        return view('profile.edit', [
            'user'      => $user,
            'mahasiswa' => $user->mahasiswa,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->fill([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (! $user->isAdmin() && $user->mahasiswa) {
            $mhs = $user->mahasiswa;
            $updateMhs = [
                'asal_kampus'   => $validated['asal_kampus'],
                'jurusan'       => $validated['jurusan'],
                'program_studi' => $validated['program_studi'],
                'no_hp'         => $validated['no_hp'] ?? null,
            ];

            if ($request->boolean('hapus_foto') && $mhs->foto_profil) {
                Storage::disk('public')->delete($mhs->foto_profil);
                $updateMhs['foto_profil'] = null;
            }

            if ($request->hasFile('foto_profil')) {
                if ($mhs->foto_profil) {
                    Storage::disk('public')->delete($mhs->foto_profil);
                }
                $updateMhs['foto_profil'] = $request->file('foto_profil')->store('profil-mahasiswa', 'public');
            }

            $mhs->update($updateMhs);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Tampilkan file foto profil mahasiswa secara langsung (bebas masalah symlink & APP_URL).
     */
    public function foto(Request $request, Mahasiswa $mahasiswa)
    {
        $user = $request->user();
        if (! $user->isAdmin() && $mahasiswa->user_id !== $user->id) {
            abort(403);
        }

        if (! $mahasiswa->foto_profil || ! Storage::disk('public')->exists($mahasiswa->foto_profil)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($mahasiswa->foto_profil), [
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
