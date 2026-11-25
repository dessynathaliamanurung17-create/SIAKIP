<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-gradient-to-br from-[#e7f0fb] via-[#f4f8fe] to-[#dce9fa]">

        <!-- KARTU LOGIN 2 KOLOM ELEGAN -->
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-blue-950/15 border border-blue-100/90 overflow-hidden grid grid-cols-1 md:grid-cols-12">

            <!-- SISI KIRI: PANEL VISUAL -->
            <div class="md:col-span-5 relative overflow-hidden p-8 sm:p-10 flex flex-col justify-between text-white min-h-[240px] md:min-h-[540px]"
                 style="background: linear-gradient(155deg, rgba(7, 21, 53, 0.90) 0%, rgba(12, 33, 82, 0.78) 55%, rgba(8, 23, 58, 0.92) 100%), url('{{ asset('images/plmd.jpeg') }}') center/cover no-repeat;">

                <!-- Tombol Kembali ke Beranda -->
                <div class="relative z-10">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-200/90 hover:text-white transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                </div>

                <!-- Branding & Logo SIBEKA -->
                <div class="relative z-10 space-y-5 my-8 md:my-0">
                    <div class="flex flex-col items-center text-center space-y-3">
                        <div class="w-24 h-24 rounded-2xl bg-white p-2 shadow-lg flex items-center justify-center mx-auto">
                            <img src="{{ asset('images/logo%20sibeka.png') }}"
                                 alt="Logo SIBEKA"
                                 class="w-full h-full object-contain">
                        </div>

                        <div class="space-y-1.5">
                            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
                                <span class="text-[#38bdf8]">SIBEKA</span>
                            </h1>
                            <p class="text-xs sm:text-sm text-blue-100/85 leading-relaxed">
                                Sistem Informasi Beasiswa Mahasiswa.
                            </p>
                        </div>
                    </div>

                    <div class="hidden md:block pt-4 border-t border-white/15 space-y-2.5 text-xs text-blue-100/90 text-left">
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-sky-400/20 text-sky-300 flex items-center justify-center text-[10px] font-bold shrink-0">✓</span>
                            <span>Pendaftaran & unggah berkas terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-sky-400/20 text-sky-300 flex items-center justify-center text-[10px] font-bold shrink-0">✓</span>
                            <span>Keamanan verifikasi wajah 2 faktor</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-sky-400/20 text-sky-300 flex items-center justify-center text-[10px] font-bold shrink-0">✓</span>
                            <span>Pantau status seleksi secara real-time</span>
                        </div>
                    </div>
                </div>

                <div class="hidden md:block"></div>
            </div>

            <!-- SISI KANAN: FORM LOGIN BERSIH -->
            <div class="md:col-span-7 p-8 sm:p-10 lg:p-12 flex flex-col justify-center bg-white">
                <div class="w-full max-w-md mx-auto space-y-6">

                    <div class="space-y-1 text-center">
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                            Masuk ke Akun
                        </h2>
                        <p class="text-sm text-slate-500">
                            Masukkan email dan kata sandi Anda untuk melanjutkan.
                        </p>
                    </div>

                    <!-- NOTIFIKASI STATUS -->
                    <x-auth-session-status
                        class="text-xs font-medium text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-200"
                        :status="session('status')" />

                    <!-- NOTIFIKASI ERROR -->
                    @if ($errors->any())
                        <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- FORM LOGIN -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- EMAIL -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="nama@email.com"
                                       required
                                       autofocus
                                       autocomplete="username"
                                       class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                            </div>
                        </div>

                        <!-- PASSWORD DENGAN SHOW/HIDE -->
                        <div x-data="{ showPass: false }">
                            <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password"
                                       :type="showPass ? 'text' : 'password'"
                                       name="password"
                                       placeholder="Masukkan kata sandi"
                                       required
                                       autocomplete="current-password"
                                       class="w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                                <button type="button"
                                        @click="showPass = !showPass"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                        aria-label="Tampilkan kata sandi">
                                    <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.978 9.978 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0a3 3 0 00-2.121.879M3 3l18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- INGAT SAYA -->
                        <div class="flex items-center">
                            <label for="remember_me" class="inline-flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                                <input id="remember_me"
                                       type="checkbox"
                                       name="remember"
                                       value="1"
                                       checked
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span>Ingat sesi login saya</span>
                            </label>
                        </div>

                        <!-- TOMBOL MASUK -->
                        <div class="pt-1">
                            <button type="submit"
                                    class="w-full py-3 px-6 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm shadow-md shadow-blue-600/20 transition cursor-pointer">
                                Masuk
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center pt-1">
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-semibold text-blue-700 hover:text-blue-800 transition">
                                    Lupa kata sandi?
                                </a>
                            </div>
                        @endif
                    </form>

                    <!-- LINK DAFTAR -->
                    @if (Route::has('register'))
                        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
                            Belum memiliki akun mahasiswa?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-800 ml-1">
                                Daftar Sekarang
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</x-guest-layout>
