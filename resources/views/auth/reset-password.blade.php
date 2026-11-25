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
                        Atur Ulang Kata Sandi
                    </h1>
                    <p class="text-sm text-slate-500">
                        Buat kata sandi baru untuk akun SIBEKA Anda.
                    </p>
                </div>
            </div>

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

            <!-- FORM RESET PASSWORD -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Alamat Email
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email', $request->email) }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Kata Sandi Baru
                    </label>
                    <input id="password"
                           type="password"
                           name="password"
                           placeholder="Minimal 8 karakter"
                           required
                           autocomplete="new-password"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           placeholder="Ulangi kata sandi baru"
                           required
                           autocomplete="new-password"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 text-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                </div>

                <div class="pt-1">
                    <button type="submit"
                            class="w-full py-3 px-6 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm shadow-md shadow-blue-600/20 transition cursor-pointer">
                        Simpan Kata Sandi Baru
                    </button>
                </div>
            </form>

        </div>

    </div>
</x-guest-layout>
