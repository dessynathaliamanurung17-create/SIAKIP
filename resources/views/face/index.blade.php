<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <!-- Icon Biometrik -->
                <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/30 flex items-center justify-center text-blue-600 shrink-0 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m16 0V5a2 2 0 00-2-2h-4m0 18h4a2 2 0 002-2v-4M3 15v4a2 2 0 002 2h4M9 9h.01M15 9h.01M9 15c.833.667 2.167 1 3 1s2.167-.333 3-1" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-xl text-slate-800 dark:text-white leading-tight">
                        {{ $mode === 'enroll' ? 'Pendaftaran Wajah (Biometrik)' : 'Verifikasi Wajah (Autentikasi)' }}
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Sistem Keamanan & Verifikasi Identitas Mahasiswa SIBEKA
                    </p>
                </div>
            </div>

            <!-- Badge Mode -->
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $mode === 'enroll' ? 'bg-amber-500/10 text-amber-600 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/30' }}">
                    <span class="w-2 h-2 rounded-full {{ $mode === 'enroll' ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500 animate-pulse' }}"></span>
                    {{ $mode === 'enroll' ? 'Registrasi Wajah Baru' : 'Verifikasi Akses Masuk' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto">
            
            <!-- KARTU UTAMA BIOMETRIK (LOGIKA data-mode & data-url TETAP UTUH) -->
            <div id="face-root" 
                 data-mode="{{ $mode }}" 
                 data-url="{{ $url }}"
                 class="relative rounded-3xl p-6 sm:p-8 text-center space-y-6 shadow-2xl border border-slate-700/60 overflow-hidden"
                 style="background: linear-gradient(180deg, #091533 0%, #060e24 100%);">

                <!-- DEKORASI GLOW LATAR BELAKANG -->
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- DESKRIPSI INSTRUKSI -->
                <div class="relative z-10">
                    <p class="text-sm text-slate-300 leading-relaxed max-w-md mx-auto">
                        @if ($mode === 'enroll')
                            <span class="font-semibold text-white">Wajah belum terdaftar.</span> Silakan hadapkan wajah tegak ke arah kamera. Sistem hanya menyimpan representasi numerik terenkripsi (*face vector*), bukan foto fisik.
                        @else
                            <span class="font-semibold text-white">Login berhasil.</span> Lakukan pemindaian wajah untuk memastikan otentikasi identitas Anda.
                        @endif
                    </p>
                </div>

                <!-- KAMERA VIEWFINDER & HUD RETICLE -->
                <div class="relative mx-auto max-w-[480px] rounded-2xl overflow-hidden bg-black/80 border-2 border-slate-700/70 shadow-2xl group">
                    
                    <!-- VIDEO ELEMENT (ID, WIDTH, HEIGHT & ATTRIBUT ASLI TIDAK DIUBAH) -->
                    <video id="video" 
                           class="mx-auto rounded-2xl w-full h-auto aspect-[4/3] object-cover block bg-slate-950" 
                           width="480" 
                           height="360" 
                           autoplay 
                           muted 
                           playsinline></video>

                    <!-- HUD RETICLE CORNER TARGETS (Sudut Pemindai Biometrik) -->
                    <div class="absolute top-3 left-3 w-6 h-6 border-t-2 border-l-2 border-sky-400 rounded-tl pointer-events-none"></div>
                    <div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-sky-400 rounded-tr pointer-events-none"></div>
                    <div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-sky-400 rounded-bl pointer-events-none"></div>
                    <div class="absolute bottom-3 right-3 w-6 h-6 border-b-2 border-r-2 border-sky-400 rounded-br pointer-events-none"></div>

                    <!-- SILUET PANDUAN WAJAH (WATERMARK) -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
                        <svg class="w-44 h-56 text-sky-300 stroke-current" fill="none" viewBox="0 0 100 130">
                            <ellipse cx="50" cy="55" rx="35" ry="45" stroke-width="1.5" stroke-dasharray="4 3" />
                            <path d="M35 110 C 35 95, 65 95, 65 110" stroke-width="1.5" stroke-dasharray="3 3" />
                        </svg>
                    </div>

                    <!-- INDIKATOR LIVE SCANNING -->
                    <div class="absolute top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-sm border border-slate-700/80 text-[10px] text-slate-300 font-mono tracking-wider flex items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-sky-400 animate-ping"></span>
                        LIVE CAMERA
                    </div>
                </div>

                <!-- STATUS PEMINDAIAN (ID status DIPERTAHANKAN) -->
                <div class="flex justify-center">
                    <div id="status" 
                         class="text-xs sm:text-sm font-semibold text-sky-300 py-2 px-5 rounded-xl bg-sky-950/60 border border-sky-500/40 inline-block shadow-sm">
                        Memulai...
                    </div>
                </div>

                <!-- TOMBOL AKSI (ID btn, type=button, disabled DIPERTAHANKAN) -->
                <div class="pt-2">
                    <button id="btn" 
                            type="button" 
                            disabled
                            class="w-full sm:w-auto min-w-[240px] px-8 py-3.5 rounded-full font-bold text-sm tracking-wide transition-all duration-200 shadow-lg inline-flex items-center justify-center gap-2
                                   disabled:bg-slate-800 disabled:text-slate-500 disabled:border disabled:border-slate-700 disabled:cursor-not-allowed
                                   enabled:bg-gradient-to-r enabled:from-[#2563eb] enabled:to-[#1ea7fd] enabled:text-white enabled:hover:opacity-95 enabled:shadow-sky-500/25 enabled:active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $mode === 'enroll' ? 'Daftarkan Wajah' : 'Verifikasi' }}</span>
                    </button>
                </div>

                <!-- CATATAN KEAMANAN & PRIVASI -->
                <div class="pt-4 border-t border-slate-800 text-[11px] text-slate-400 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Enkripsi Biometrik Aktif • Privasi Data Mahasiswa Terlindungi</span>
                </div>

            </div>

            <!-- FORM LOGOUT (LOGIKA ASLI DIPERTAHANKAN) -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
                @csrf
                <button type="submit" 
                        class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 hover:text-red-500 dark:hover:text-red-400 font-medium transition inline-flex items-center gap-1.5 underline underline-offset-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar dari Sesi
                </button>
            </form>

        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT ASLI -->
    @vite('resources/js/face.js')
</x-app-layout>