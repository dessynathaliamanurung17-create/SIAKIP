<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#07122b] via-[#0c1f4a] to-[#081533] px-4 py-10">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200/80 p-8 sm:p-10">
            {{-- Header & Logo --}}
            <div class="flex flex-col items-center text-center mb-7">
                <img src="{{ asset('images/logo%20sibeka.png') }}" alt="Logo SIBEKA" class="h-14 w-auto object-contain mb-4">

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-[11px] font-semibold text-slate-700 mb-3">
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Akses Terbatas · Khusus Administrator
                </span>

                <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                    Portal Administrator SIBEKA
                </h1>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">
                    Masuk menggunakan kredensial pengelola yang terdaftar.
                </p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-xs font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-xs font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Email Administrator
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@sibeka.ac.id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-[#0c1f4a] focus:ring-2 focus:ring-[#0c1f4a]/15 focus:outline-none transition"
                    >
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 pr-10 text-sm text-slate-900 placeholder-slate-400 focus:border-[#0c1f4a] focus:ring-2 focus:ring-[#0c1f4a]/15 focus:outline-none transition"
                        >
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600 focus:outline-none"
                            tabindex="-1"
                            aria-label="Tampilkan kata sandi"
                        >
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between pt-0.5">
                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-[#0c1f4a] focus:ring-[#0c1f4a]/25"
                        >
                        <span class="text-xs text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full mt-2 rounded-xl bg-[#0c1f4a] hover:bg-[#132c63] active:bg-[#091738] text-white text-sm font-semibold py-3 px-4 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#0c1f4a]/40 focus:ring-offset-2"
                >
                    Masuk ke Panel Admin
                </button>
            </form>

            {{-- Security Footer --}}
            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-400">
                    Seluruh aktivitas autentikasi dicatat di Audit Log.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
