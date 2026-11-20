<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Status Seleksi Beasiswa</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pantau hasil seleksi administrasi, verifikasi faktual, dan pengumuman SK.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Portal SIBEKA POLMED
                </span>
            </div>
        </div>
    </x-slot>

    @php
        $mhsData = $mhs ?? (auth()->user()->mahasiswa ?? null);
        $nim = $mhsData?->nim ?? '-';
        $jurusan = $mhsData?->jurusan ?? '-';
        $prodi = $mhsData?->program_studi ?? '-';
        $initials = strtoupper(substr(auth()->user()->name, 0, 2));

        $statusPendaftaran = strtolower($application->status ?? '');
        $hasilVerifikasi = strtolower($application->hasil_verifikasi ?? '');
        $hasilAkhir = strtolower($application->hasil_akhir ?? '');

        // Penentuan warna banner hasil seleksi
        $isLolosAkhir = str_contains($hasilAkhir, 'lolos') || str_contains($hasilAkhir, 'terima');
        $isGagalAkhir = str_contains($hasilAkhir, 'tolak') || str_contains($hasilAkhir, 'gagal');
    @endphp

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- NOTIFIKASI STATUS DARI CONTROLLER -->
            @if (session('status'))
                <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('status') }}</div>
                </div>
            @endif

            <!-- HEADER TITLE SECTION -->
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200/60">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>PORTAL BEASISWA POLMED · TAHUN AKADEMIK 2025/2026 · Biro Administrasi Kemahasiswaan & Alumni</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Status Seleksi Beasiswa Mahasiswa</h1>
            </div>

            <!-- GRID UTAMA (2 KOLOM: KIRI FORM VERIFIKASI IDENTITAS, KANAN HASIL SELEKSI) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- KOLOM KIRI: CEK STATUS PENERIMAAN -->
                <div class="lg:col-span-4 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base text-slate-900">Cek Status Penerimaan</h3>
                            <p class="text-xs text-slate-500">Verifikasi portal terpadu mahasiswa</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">
                                Nama Lengkap Mahasiswa <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" value="{{ auth()->user()->name }}" readonly 
                                    class="w-full pl-9 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-700 cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1.5">
                                Nomor Induk Mahasiswa (NIM) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                </div>
                                <input type="text" value="{{ $nim }}" readonly 
                                    class="w-full pl-9 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono font-semibold text-slate-700 cursor-not-allowed">
                            </div>
                        </div>

                        <button type="button" onclick="window.location.reload()" 
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Periksa Status Seleksi</span>
                        </button>
                    </div>

                    <div class="pt-2 border-t border-slate-100 space-y-3 text-[11px] text-slate-500">
                        <div class="flex items-center gap-2 text-emerald-700">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Data terintegrasi secara langsung dengan Sistem Informasi Akademik (SIAKAD) & Database BAK POLMED.</span>
                        </div>

                        <div class="p-3 bg-blue-50/70 rounded-xl border border-blue-200/60 text-slate-700 leading-relaxed">
                            Gunakan NIM yang terdaftar resmi. Jika terdapat ketidaksesuaian status berkas, kunjungi loket layanan BAK Gedung Direktorat Lt. 1.
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: HASIL SELEKSI & TAHAPAN PROGRESS -->
                <div class="lg:col-span-8 space-y-5">
                    
                    @if (! $application)
                        <!-- TAMPILAN JIKA BELUM MENDAFTAR -->
                        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center space-y-4">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-bold text-lg text-slate-800">Anda Belum Mengajukan Pendaftaran</h3>
                                <p class="text-xs text-slate-500 max-w-md mx-auto">
                                    Data Anda belum tercatat pada seleksi beasiswa periode aktif saat ini. Silakan melengkapi formulir pendaftaran untuk mengikuti alur seleksi.
                                </p>
                            </div>
                            @if (Route::has('mahasiswa.pendaftaran'))
                                <a href="{{ route('mahasiswa.pendaftaran') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-500/20">
                                    <span>Isi Formulir Pendaftaran</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @endif
                        </div>
                    @else
                        <!-- TAMPILAN JIKA SUDAH MENDAFTAR (SESUAI GAMBAR REFERENSI) -->
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                            
                            <!-- Banner Hasil Seleksi Terkini (Hijau/Biru/Merah Sesuai Status) -->
                            <div class="p-6 {{ $isGagalAkhir ? 'bg-gradient-to-r from-red-900 to-rose-950' : 'bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900' }} text-white space-y-2">
                                <div class="flex items-center gap-2 text-xs font-medium text-emerald-300">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center font-bold">
                                        ✓
                                    </div>
                                    <span class="uppercase tracking-wider">HASIL SELEKSI TERKINI · Tahun Akademik 2025/2026</span>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                                    <div>
                                        <h2 class="text-xl sm:text-2xl font-black tracking-tight">
                                            @if ($application->hasil_akhir)
                                                {{ $application->hasil_akhir }}
                                            @elseif ($application->hasil_verifikasi)
                                                {{ $application->hasil_verifikasi }}
                                            @else
                                                Tahap Seleksi Administrasi & Verifikasi
                                            @endif
                                        </h2>
                                        <p class="text-xs text-slate-300 mt-0.5">
                                            Status Pendaftaran: <span class="font-bold text-white uppercase">{{ $application->status }}</span>
                                        </p>
                                    </div>

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $isGagalAkhir ? 'bg-red-500/30 text-red-200 border border-red-400/40' : 'bg-emerald-500/30 text-emerald-200 border border-emerald-400/40' }} w-fit shrink-0">
                                        {{ $application->hasil_verifikasi ?? 'Proses Verifikasi' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Data Mahasiswa Ringkas -->
                            <div class="p-5 sm:p-6 border-b border-slate-100 bg-slate-50/50 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-blue-700 text-white font-black text-sm flex items-center justify-center shrink-0 shadow-inner">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-base text-slate-800">{{ auth()->user()->name }}</h4>
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Aktif</span>
                                            </div>
                                            <p class="text-xs text-slate-500 font-mono">
                                                NIM: {{ $nim }} · Mahasiswa Aktif POLMED
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-xl w-fit">
                                        Reguler D4 T.A. 2025
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Program Studi</span>
                                        <span class="font-bold text-slate-800 truncate block">{{ $prodi }}</span>
                                    </div>
                                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Jurusan</span>
                                        <span class="font-bold text-slate-800 truncate block">{{ $jurusan }}</span>
                                    </div>
                                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Hasil Akhir</span>
                                        <span class="font-bold text-blue-700 truncate block">{{ $application->hasil_akhir ?? 'Belum ditetapkan' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tahapan & Alur Seleksi Beasiswa (Stepper) -->
                            <div class="p-5 sm:p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm sm:text-base text-slate-800">Tahapan & Alur Seleksi Beasiswa</h4>
                                    <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">
                                        Hasil Verifikasi: {{ $application->hasil_verifikasi ?? 'Belum ada' }}
                                    </span>
                                </div>

                                <div class="space-y-3 text-xs">
                                    <!-- Tahap 1: Pendaftaran Berkas Administrasi -->
                                    <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-800">1. Pendaftaran Berkas Administrasi</span>
                                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">SELESAI</span>
                                                </div>
                                                <p class="text-slate-500 text-[11px] mt-0.5">Pengunggahan kartu KIP/KTM, Kartu Keluarga, dan Slip Gaji Orang Tua.</p>
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-slate-400 shrink-0 font-medium">Status: {{ $application->status }}</span>
                                    </div>

                                    <!-- Tahap 2: Verifikasi Dokumen Faktual (BAK POLMED) -->
                                    <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-800">2. Verifikasi Dokumen Faktual (BAK POLMED)</span>
                                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">
                                                        {{ $application->hasil_verifikasi ?? 'TERVERIFIKASI' }}
                                                    </span>
                                                </div>
                                                <p class="text-slate-500 text-[11px] mt-0.5">Validasi keabsahan berkas oleh Tim Verifikator BAK POLMED.</p>
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-slate-400 shrink-0 font-medium">Hasil: {{ $application->hasil_verifikasi ?? 'Belum ada' }}</span>
                                    </div>

                                    <!-- Tahap 3: Wawancara & Uji Faktual Lapangan -->
                                    <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-800">3. Wawancara & Survei Faktual Lapangan</span>
                                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">LOLOS</span>
                                                </div>
                                                <p class="text-slate-500 text-[11px] mt-0.5">Wawancara komprehensif profil akademik dan verifikasi tempat tinggal.</p>
                                            </div>
                                        </div>
                                        <span class="text-[11px] text-slate-400 shrink-0 font-medium">Selesai</span>
                                    </div>

                                    <!-- Tahap 4: Penetapan SK Direktur & Hasil Akhir -->
                                    <div class="p-3.5 rounded-xl border {{ $isLolosAkhir ? 'border-emerald-300 bg-emerald-50/50' : 'border-blue-200 bg-blue-50/40' }} flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full {{ $isLolosAkhir ? 'bg-emerald-600' : 'bg-blue-600' }} text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">4</div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-800">4. Penetapan SK Direktur & Buku Tabungan</span>
                                                    <span class="text-[10px] font-bold {{ $isLolosAkhir ? 'text-emerald-700 bg-emerald-100' : 'text-blue-700 bg-blue-100' }} px-2 py-0.5 rounded">
                                                        {{ $application->hasil_akhir ?? 'SEDANG BERJALAN' }}
                                                    </span>
                                                </div>
                                                <p class="text-slate-500 text-[11px] mt-0.5">
                                                    Hasil Akhir: <b>{{ $application->hasil_akhir ?? 'Belum ditetapkan' }}</b>. Koordinasi penerbitan SK Direktur POLMED & Bank Penyalur.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- skor sengaja tidak ditampilkan ke mahasiswa --}}

                                <!-- Tombol Aksi Download Bukti & Hubungi Layanan -->
                                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                                    <button type="button" onclick="window.print()" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs transition shadow-sm">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span>Unduh Bukti Tanda Lolos (.PDF)</span>
                                    </button>

                                    <a href="#pusat-bantuan" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        <span>Hubungi Layanan BAK</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <!-- Banner Ketentuan Resmi di bawah kartu seleksi -->
                        <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-4.5 flex items-start gap-3 text-xs text-blue-900">
                            <span class="p-1.5 bg-blue-100 text-blue-700 rounded-lg shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <p class="leading-relaxed">
                                <strong>Ketentuan Resmi:</strong> Mahasiswa yang telah dinyatakan lolos seleksi wajib memastikan data rekening bank aktif atas nama pribadi dan tidak sedang menerima beasiswa dari sumber Anggaran Pendapatan dan Belanja Negara (APBN) lain secara bersamaan.
                            </p>
                        </div>
                    @endif

                </div>

            </div>

            <!-- BAGIAN BAWAH: PUSAT INFORMASI & LAYANAN SELEKSI -->
            <div id="pusat-bantuan" class="space-y-4 pt-4 border-t border-slate-200">
                <div>
                    <h3 class="font-bold text-lg text-slate-900">Pusat Informasi & Layanan Seleksi</h3>
                    <p class="text-xs text-slate-500">Kanal resmi pendampingan dan jadwal lanjutan seleksi beasiswa POLMED</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800">Jadwal Pengumuman SK</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pengumuman final penerima SK Direktur Politeknik Negeri Medan direncanakan serentak sesuai kalender akademik melalui portal ini.
                        </p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800">Loket BAK POLMED</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pelayanan tatap muka bertempat di Gedung Direktorat Lt. 1, Bagian Administrasi Kemahasiswaan (BAK). Buka setiap hari kerja Senin - Jumat (08.30 - 15.30 WIB).
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>