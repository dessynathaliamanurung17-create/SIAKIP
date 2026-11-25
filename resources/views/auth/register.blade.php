<x-guest-layout>
    <div class="min-h-screen py-10 px-4 flex flex-col justify-center items-center bg-gradient-to-br from-[#e7f0fb] via-[#f4f8fe] to-[#dce9fa]">
        
        <!-- KARTU UTAMA REGISTRASI -->
        <div class="w-full max-w-2xl rounded-[2.5rem] p-7 md:p-10 shadow-2xl border border-white/15 relative overflow-hidden backdrop-blur-md"
             style="background: linear-gradient(180deg, rgba(7, 18, 47, 0.94) 0%, rgba(4, 12, 33, 0.98) 100%), url('{{ asset('images/plmd.jpeg') }}') center/cover no-repeat;">
            
            <!-- HEADER KARTU (LOGO & JUDUL) -->
            <div class="text-center mb-7">
                <!-- Badge Logo SIBEKA -->
                <div class="w-20 h-20 mx-auto rounded-2xl bg-white p-2 shadow-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo%20sibeka.png') }}" 
                         alt="Logo SIBEKA" 
                         class="w-full h-full object-contain">
                </div>

                <!-- Judul SIBEKA -->
                <h1 class="text-2xl font-black tracking-wide text-white mt-3 uppercase leading-none">
                    SIBEKA
                </h1>
                <p class="text-[11px] font-bold tracking-[0.2em] text-slate-300 uppercase mt-2">
                    SISTEM INFORMASI BEASISWA
                </p>
                <div class="mt-2 inline-block px-3 py-0.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-[11px] font-medium text-sky-200">
                    Pendaftaran Akun Mahasiswa
                </div>
            </div>

            <!-- ALERT ERROR GLOBAL (JIKA ADA) -->
            @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-red-500/15 border border-red-500/40 text-xs text-red-200">
                <ul class="list-disc ps-5 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- FORM PENDAFTARAN -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- GRID 2 KOLOM AGAR RAPI DAN COMPACT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    
                    <!-- 1. Name -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-200 mb-1">
                            Nama Lengkap
                        </label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required autofocus autocomplete="name"
                               placeholder="Nama lengkap sesuai KTM"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 2. NIM -->
                    <div>
                        <label for="nim" class="block text-xs font-semibold text-slate-200 mb-1">
                            NIM
                        </label>
                        <input id="nim" 
                               type="text" 
                               name="nim" 
                               value="{{ old('nim') }}" 
                               required
                               placeholder="Nomor Induk Mahasiswa"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('nim')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 3. Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-200 mb-1">
                            Email
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required autocomplete="username"
                               placeholder="nama@email.com"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 4. No. HP -->
                    <div>
                        <label for="no_hp" class="block text-xs font-semibold text-slate-200 mb-1">
                            No. HP / WhatsApp
                        </label>
                        <input id="no_hp" 
                               type="text" 
                               name="no_hp" 
                               value="{{ old('no_hp') }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 5. Jurusan -->
                    <div>
                        <label for="jurusan" class="block text-xs font-semibold text-slate-200 mb-1">
                            Jurusan
                        </label>
                        <input id="jurusan" 
                               type="text" 
                               name="jurusan" 
                               value="{{ old('jurusan') }}" 
                               required
                               placeholder="Contoh: Teknik Komputer & Informatika"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('jurusan')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 6. Program Studi -->
                    <div>
                        <label for="program_studi" class="block text-xs font-semibold text-slate-200 mb-1">
                            Program Studi
                        </label>
                        <input id="program_studi" 
                               type="text" 
                               name="program_studi" 
                               value="{{ old('program_studi') }}" 
                               required
                               placeholder="Contoh: D4 Rekayasa Perangkat Lunak"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('program_studi')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 7. Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-200 mb-1">
                            Password
                        </label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- 8. Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-200 mb-1">
                            Konfirmasi Password
                        </label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required autocomplete="new-password"
                               placeholder="Ulangi password"
                               class="w-full px-4 py-2.5 bg-[#eaf3fc] text-slate-800 placeholder-slate-400 rounded-xl border border-sky-200/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1ea7fd] text-sm transition shadow-inner">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-400" />
                    </div>

                </div>

                <!-- TOMBOL DAFTAR (PILL PUTIH SEPERTI LOGIN) -->
                <div class="mt-7 text-center">
                    <button type="submit" 
                            class="w-full sm:w-auto min-w-[200px] px-10 py-3 bg-white hover:bg-slate-100 text-[#07122f] font-bold text-sm rounded-full shadow-lg hover:shadow-xl transition transform active:scale-95 inline-flex items-center justify-center">
                        Daftar Sekarang
                    </button>
                </div>

                <!-- LINK KE LOGIN -->
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" 
                       class="text-xs text-slate-300 hover:text-white transition underline underline-offset-4">
                        Sudah punya akun? Masuk di sini
                    </a>
                </div>

                <!-- FOOTER KARTU -->
                <div class="text-center mt-6 pt-4 border-t border-white/10 text-[11px] text-slate-400">
                    © {{ date('Y') }} SIBEKA
                </div>

            </form>
        </div>

    </div>
</x-guest-layout>