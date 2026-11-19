<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Mahasiswa;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'nim'           => ['required', 'regex:/^[0-9]{5,20}$/', 'unique:mahasiswa,nim'],
            'jurusan'       => ['required', 'string', 'max:100'],
            'program_studi' => ['required', 'string', 'max:100'],
            'no_hp'         => ['nullable', 'regex:/^[0-9+]{8,20}$/'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // transaksi: kalau salah satu gagal, dua-duanya dibatalkan
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]); // role otomatis 'mahasiswa' dari default migration

            Mahasiswa::create([
                'nim'           => $request->nim,
                'user_id'       => $user->id,
                'jurusan'       => $request->jurusan,
                'program_studi' => $request->program_studi,
                'no_hp'         => $request->no_hp,
            ]);

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
