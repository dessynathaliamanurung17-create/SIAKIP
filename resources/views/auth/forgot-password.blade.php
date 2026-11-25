<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-gradient-to-br from-[#e7f0fb] via-[#f4f8fe] to-[#dce9fa]">

        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl shadow-blue-950/10 border border-blue-100/90 p-8 sm:p-10 space-y-6">

            <!-- LOGO & JUDUL -->
            <div class="text-center space-y-3">
                <img src="{{ asset('images/logo%20sibeka.png') }}"
                     alt="Logo SIBEKA"
                     class="w-20 h-20 object-contain mx-auto">

                <div class="space-y-1">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Lupa Kata Sandi
                    </h1>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Masukkan alamat email akun Anda, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                    </p>
                </div>
            </div>

            <!-- NOTIFIKASI STATUS -->
            <x-auth-session-status
                class="text-xs font-medium text-emerald-700 bg-emerald-50 p-3.5 rounded-xl border border-emerald-200"
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

            <!-- FORM KIRIM TAUTAN RESET -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

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
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit"
                            class="w-full py-3 px-6 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm shadow-md shadow-blue-600/20 transition cursor-pointer">
                        Kirim Tautan Reset Kata Sandi
                    </button>
                </div>
            </form>

            <!-- KEMBALI KE LOGIN -->
            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:text-blue-800 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Kembali ke Halaman Masuk</span>
                </a>
            </div>

        </div>

    </div>
</x-guest-layout>
