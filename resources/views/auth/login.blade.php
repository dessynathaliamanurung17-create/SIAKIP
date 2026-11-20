
<x-guest-layout>
    <!-- CANVAS UTAMA -->
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-[#f8fafc] relative">

        <!-- KARTU LOGIN -->
        
        <div class="w-full max-w-[390px] rounded-[2.5rem] bg-gradient-to-b from-[#162744] via-[#0d1a31] to-[#081223] p-8 sm:p-9 shadow-[0_30px_70px_rgba(5,15,35,0.45)] border border-slate-700/40 relative overflow-hidden text-center">

            <!-- TEKSTUR LATAR BELAKANG -->
            <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:20px_20px] opacity-10 pointer-events-none">

                <img
                            src="{{ asset('build/assets/image/1.jpeg') }}"
                            alt="Politeknik Negeri Medan"
                            class="w-full h-full object-contain"
                        >

            </div>

            <div class="relative z-10 space-y-5">

                <!-- LOGO POLMED -->
                <div class="relative flex justify-center pt-1">

                    <!-- GLOW DI BELAKANG LOGO -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-emerald-400/25 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <!-- GAMBAR LOGO ASLI POLMED -->
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-b from-sky-400/20 to-blue-600/30 p-2 border border-sky-400/30 shadow-lg flex items-center justify-center relative z-10">

                        <img
                            src="{{ asset('build/assets/image/logo polmed.png') }}"
                            alt="Logo Politeknik Negeri Medan"
                            class="w-full h-full object-contain"
                        >

                    </div>
                </div>

                <!-- JUDUL BRANDING SIBEKA POLMED -->
                <div class="space-y-0.5">
                    <h1 class="text-3xl font-extrabold tracking-tight text-white font-sans">
                        SIBEKA
                    </h1>

                    <h2 class="text-3xl font-black text-[#0099ff] tracking-tight font-sans -mt-1">
                        POLMED
                    </h2>

                    <p class="text-[10px] sm:text-[11px] font-bold text-slate-300 uppercase tracking-[0.25em] pt-1">
                        SISTEM INFORMASI BEASISWA
                    </p>
                </div>

                <!-- NOTIFIKASI STATUS -->
                <x-auth-session-status
                    class="text-xs text-emerald-400 bg-emerald-950/60 p-2.5 rounded-xl border border-emerald-500/30 text-center"
                    :status="session('status')"
                />

                <!-- NOTIFIKASI ERROR -->
                @if ($errors->any())
                    <div class="p-2.5 bg-rose-950/60 border border-rose-500/40 rounded-xl text-xs text-rose-300 text-left space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-1.5">
                                <span class="text-rose-400 font-bold">•</span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- FORM LOGIN -->
                <form method="POST" action="{{ route('login') }}" class="space-y-3.5 text-left pt-1">
                    @csrf

                    <!-- INPUT USERNAME / EMAIL -->
                    <div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Username"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full px-5 py-3 bg-white text-slate-800 placeholder-slate-400 text-sm font-medium rounded-xl border-0 focus:ring-2 focus:ring-sky-400 focus:outline-none shadow-sm transition"
                        >
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required
                            autocomplete="current-password"
                            class="w-full px-5 py-3 bg-white text-slate-800 placeholder-slate-400 text-sm font-medium rounded-xl border-0 focus:ring-2 focus:ring-sky-400 focus:outline-none shadow-sm transition"
                        >
                    </div>

                    <!-- REMEMBER ME -->
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        value="1"
                        checked
                        class="hidden"
                    >

                    <!-- TOMBOL LOGIN -->
                    <div class="pt-2 flex justify-center">
                        <button
                            type="submit"
                            class="min-w-[140px] px-8 py-2.5 rounded-full bg-white hover:bg-slate-100 active:bg-slate-200 text-slate-900 font-bold text-sm tracking-wide shadow-md transition duration-150 cursor-pointer"
                        >
                            Login
                        </button>
                    </div>

                    <!-- LUPA PASSWORD -->
                    <div class="pt-2 text-center space-y-1.5">

                        @if (Route::has('password.request'))
                            <div>
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-xs text-slate-300 hover:text-white transition"
                                >
                                    Lupa Password?
                                </a>
                            </div>
                        @endif

                        <p class="text-[11px] text-slate-400 font-normal">
                            © Politeknik Negeri Medan
                        </p>

                    </div>
                </form>

            </div>
        </div>

        <!-- FOOTER DI BAWAH KARTU -->
        <div class="mt-6 text-center text-xs text-slate-400 tracking-wide font-normal">
            Akses Terpadu Sivitas Akademika • Kampus USU Medan Baru
        </div>

    </div>
</x-guest-layout>
