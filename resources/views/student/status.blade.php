<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Status Seleksi Beasiswa</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pantau hasil seleksi administrasi, verifikasi faktual, dan pengumuman SK secara realtime.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Portal SIBEKA POLMED
                </span>
            </div>
        </div>
    </x-slot>

    {{-- ================================================================= --}}
    {{-- LOGIKA 6 TAHAPAN SELEKSI REALTIME (PHP)                           --}}
    {{-- ================================================================= --}}
    @php
    $mhsData = $mhs ?? (auth()->user()->mahasiswa ?? null);
    $nim = $mhsData?->nim ?? '-';
    $jurusan = $mhsData?->jurusan ?? '-';
    $prodi = $mhsData?->program_studi ?? '-';
    $initials = strtoupper(substr(auth()->user()->name, 0, 2));

    $statusPendaftaran = strtolower($application->status ?? '');
    $hasilVerifikasi = strtolower($application->hasil_verifikasi ?? '');
    $hasilAkhir = strtolower($application->hasil_akhir ?? '');

    // Data berkas dokumen
    $docs = $application ? $application->documents : collect();
    $totalDocs = $docs->count();
    $wajibDocs = ['kk', 'ktm', 'penghasilan'];
    $uploadedWajib = $docs->whereIn('jenis', $wajibDocs)->pluck('jenis')->toArray();
    $missingWajib = array_diff($wajibDocs, $uploadedWajib);
    $validDocs = $docs->where('status_verifikasi', 'valid')->count();

    // 1. TAHAP PENDAFTARAN: Ceklist jika sudah mendaftar (data application ada)
    $step1_done = !empty($application);
    $step1_active = !$step1_done;

    // 2. TAHAP INPUT BERKAS: Ceklist jika berkas wajib sudah diunggah / status diajukan / diverifikasi
    $step2_done = $step1_done && (empty($missingWajib) || in_array($statusPendaftaran, ['diajukan', 'diverifikasi']) || $totalDocs >= 3);
    $step2_active = $step1_done && !$step2_done;

    // 3. TAHAP PENGUMUMAN SELEKSI BERKAS: Ceklist jika berkas diverifikasi & lulus oleh admin
    $step3_lulus = $step2_done && (
    $statusPendaftaran === 'diverifikasi' ||
    ($totalDocs > 0 && $validDocs === $totalDocs) ||
    !empty($hasilAkhir) ||
    str_contains($hasilVerifikasi, 'lolos') ||
    str_contains($hasilVerifikasi, 'valid') ||
    str_contains($hasilVerifikasi, 'terverifikasi')
    );
    $step3_ditolak = $statusPendaftaran === 'ditolak' || str_contains($hasilVerifikasi, 'tidak lolos') || str_contains($hasilVerifikasi, 'ditolak');
    $step3_active = $step2_done && !$step3_lulus && !$step3_ditolak;

    // 4. TAHAP SELEKSI WAWANCARA: Ceklist jika wawancara sudah selesai / dinilai
    $step4_done = $step3_lulus && (
    !is_null($application?->skor) ||
    !empty($hasilAkhir) ||
    str_contains($hasilVerifikasi, 'wawancara selesai')
    );
    $step4_active = $step3_lulus && !$step4_done;

    // 5. TAHAP PENGUMUMAN HASIL WAWANCARA: Ceklist jika skor/hasil wawancara sudah keluar
    $step5_done = $step4_done && (
    !is_null($application?->skor) ||
    !empty($hasilAkhir)
    );
    $step5_active = $step4_done && !$step5_done;

    // 6. TAHAP PENGUMUMAN KELULUSAN FINAL: Ceklist jika SK Direktur sudah ditetapkan
    $isLolosAkhir = in_array($hasilAkhir, ['diterima', 'lolos']);
    $isGagalAkhir = in_array($hasilAkhir, ['ditolak', 'gagal']);
    $step6_done = !empty($hasilAkhir);
    $step6_active = $step5_done && !$step6_done;
    @endphp

    <div class="py-8 bg-slate-50/70 min-h-screen" x-data="{ showWawancaraCard: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- NOTIFIKASI SUKSES DARI CONTROLLER -->
            @if (session('status'))
            <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('status') }}</div>
            </div>
            @endif

            <!-- 1. HEADER INFO BADGE -->
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200/60">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>PORTAL BEASISWA POLMED · TAHUN AKADEMIK 2025/2026 · Biro Administrasi Kemahasiswaan & Alumni</span>
                </div>
            </div>

            {{-- ====================================================================================== --}}
            {{-- 2. CARD BANNER SELEKSI BEASISWA MAHASISWA DENGAN 6 TAHAPAN REALTIME                     --}}
            {{-- ====================================================================================== --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white shadow-xl p-6 sm:p-8">
                <!-- Background Radial Glow Decor -->
                <div class="absolute -right-10 -top-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5">
                    <!-- Top Pill Badge & Info Realtime -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 w-fit">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            PERIODE PENDAFTARAN TERBUKA: JALUR PRESTASI & BANTUAN
                        </div>
                        <span class="text-xs text-slate-300 font-mono flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $step1_done ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                            Status Pendaftaran: <b class="text-white uppercase">{{ $application ? $application->status : 'Belum Terdaftar' }}</b>
                        </span>
                    </div>

                    <!-- Judul & Deskripsi Sesuai Halaman Seleksi Mahasiswa -->
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Status Seleksi Beasiswa Mahasiswa</h1>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1.5 max-w-3xl leading-relaxed">
                            Pantau alur dan tahapan seleksi beasiswa Anda secara realtime mulai dari pendaftaran identitas, kelengkapan berkas, verifikasi administrasi, seleksi wawancara, hingga pengumuman kelulusan final.
                        </p>
                    </div>

                    <!-- STEPPER 6 TAHAPAN REALTIME (ANGKA DI ATAS, KETERANGAN DI BAWAH, TANPA IKON PANAH) -->
                    <div class="pt-6 border-t border-white/10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">

                        <!-- 1. TAHAP 01: Pendaftaran -->
                        <a href="{{ route('mahasiswa.pendaftaran') }}" class="flex flex-col items-center text-center group transition-transform hover:scale-105 cursor-pointer" title="Klik nomor untuk menuju Formulir Pendaftaran">
                            <!-- ANGKA DI ATAS -->
                            @if ($step1_done)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20 group-hover:border-emerald-300">
                                ✓
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0 group-hover:bg-blue-400">
                                01
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 group-hover:text-slate-300 uppercase tracking-wider font-semibold">Tahap 01</p>
                                <p class="text-xs font-semibold {{ $step1_done ? 'text-slate-200' : 'text-white' }} group-hover:text-white leading-tight">
                                    Pendaftaran
                                </p>
                            </div>
                        </a>

                        <!-- 2. TAHAP 02: Input Berkas -->
                        <a href="{{ route('mahasiswa.dokumen') }}" class="flex flex-col items-center text-center group transition-transform hover:scale-105 cursor-pointer {{ !$step2_done && !$step2_active ? 'opacity-70' : '' }}" title="Klik nomor untuk menuju Pengunggahan Dokumen">
                            <!-- ANGKA DI ATAS -->
                            @if ($step2_done)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20 group-hover:border-emerald-300">
                                ✓
                            </div>
                            @elseif ($step2_active)
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0 group-hover:bg-blue-400">
                                02
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0 group-hover:bg-white/20">
                                02
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 group-hover:text-slate-300 uppercase tracking-wider font-semibold">Tahap 02</p>
                                <p class="text-xs font-semibold {{ $step2_done ? 'text-slate-200' : ($step2_active ? 'text-white' : 'text-slate-300') }} group-hover:text-white leading-tight">
                                    Input Berkas
                                </p>
                            </div>
                        </a>

                        <!-- 3. TAHAP 03: Pengumuman Seleksi Berkas -->
                        <a href="{{ route('mahasiswa.dokumen') }}" class="flex flex-col items-center text-center group transition-transform hover:scale-105 cursor-pointer {{ !$step3_lulus && !$step3_active ? 'opacity-70' : '' }}" title="Klik nomor untuk menuju Pengumuman Seleksi Berkas">
                            <!-- ANGKA DI ATAS -->
                            @if ($step3_lulus)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20 group-hover:border-emerald-300">
                                ✓
                            </div>
                            @elseif ($step3_ditolak)
                            <div class="w-11 h-11 rounded-2xl bg-rose-500/20 border border-rose-400/50 text-rose-400 flex items-center justify-center font-bold text-sm shrink-0">
                                ✕
                            </div>
                            @elseif ($step3_active)
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0 group-hover:bg-blue-400">
                                03
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0 group-hover:bg-white/20">
                                03
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 group-hover:text-slate-300 uppercase tracking-wider font-semibold">Tahap 03</p>
                                <p class="text-xs font-semibold {{ $step3_lulus ? 'text-slate-200' : ($step3_ditolak ? 'text-rose-200' : ($step3_active ? 'text-white' : 'text-slate-300')) }} group-hover:text-white leading-tight">
                                    {{ $step3_ditolak ? 'Berkas Ditolak' : 'Pengumuman Seleksi Berkas' }}
                                </p>
                            </div>
                        </a>

                        <!-- 4. TAHAP 04: Wawancara (KLIK NOMOR UNTUK MEMUNCULKAN KARTU INFORMASI WAWANCARA) -->
                        <button type="button" @click="showWawancaraCard = !showWawancaraCard" class="flex flex-col items-center text-center group transition-transform hover:scale-105 cursor-pointer focus:outline-none w-full {{ !$step4_done && !$step4_active ? 'opacity-70' : '' }}" title="Klik nomor untuk melihat Detail & Jadwal Wawancara">
                            <!-- ANGKA DI ATAS -->
                            @if ($step4_done)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20 group-hover:border-emerald-300">
                                ✓
                            </div>
                            @elseif ($step4_active)
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0 group-hover:bg-blue-400">
                                04
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0 group-hover:bg-white/20">
                                04
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 group-hover:text-slate-300 uppercase tracking-wider font-semibold">Tahap 04</p>
                                <p class="text-xs font-semibold {{ $step4_done ? 'text-slate-200' : ($step4_active ? 'text-white' : 'text-slate-300') }} group-hover:text-white leading-tight">
                                    Wawancara
                                </p>
                            </div>
                        </button>

                        <!-- 5. TAHAP 05: Hasil Wawancara -->
                        <div class="flex flex-col items-center text-center {{ !$step5_done && !$step5_active ? 'opacity-70' : '' }}">
                            <!-- ANGKA DI ATAS -->
                            @if ($step5_done)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20" title="Hasil Wawancara Diumumkan">
                                ✓
                            </div>
                            @elseif ($step5_active)
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0">
                                05
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0">
                                05
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Tahap 05</p>
                                <p class="text-xs font-semibold {{ $step5_done ? 'text-slate-200' : ($step5_active ? 'text-white' : 'text-slate-300') }} leading-tight">
                                    Hasil Wawancara
                                </p>
                            </div>
                        </div>

                        <!-- 6. TAHAP 06: Pengumuman Kelulusan Final -->
                        <div class="flex flex-col items-center text-center {{ !$step6_done && !$step6_active ? 'opacity-70' : '' }}">
                            <!-- ANGKA DI ATAS -->
                            @if ($isLolosAkhir)
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 shadow-sm shadow-emerald-500/20" title="Lolos Beasiswa">
                                ✓
                            </div>
                            @elseif ($isGagalAkhir)
                            <div class="w-11 h-11 rounded-2xl bg-rose-500/20 border border-rose-400/50 text-rose-400 flex items-center justify-center font-bold text-sm shrink-0" title="Tidak Lolos">
                                ✕
                            </div>
                            @elseif ($step6_active)
                            <div class="w-11 h-11 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/40 ring-2 ring-blue-400/30 shrink-0">
                                06
                            </div>
                            @else
                            <div class="w-11 h-11 rounded-2xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0">
                                06
                            </div>
                            @endif
                            <!-- KETERANGAN DI BAWAH -->
                            <div class="mt-2.5 space-y-0.5">
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Tahap 06</p>
                                <p class="text-xs font-semibold {{ $isLolosAkhir ? 'text-emerald-300' : ($isGagalAkhir ? 'text-rose-200' : ($step6_active ? 'text-white' : 'text-slate-300')) }} leading-tight">
                                    {{ $isLolosAkhir ? 'Lolos Final' : ($isGagalAkhir ? 'Tidak Lolos' : 'Kelulusan Final') }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ====================================================================================== --}}
            {{-- KARTU DETAIL & JADWAL SELEKSI WAWANCARA (MUNCUL KETIKA TAHAP WAWANCARA DIKLIK)           --}}
            {{-- ====================================================================================== --}}
            <div x-show="showWawancaraCard"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-3 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-3 scale-[0.98]"
                x-cloak
                class="bg-white rounded-3xl border border-blue-200 shadow-xl overflow-hidden ring-4 ring-blue-500/10">

                <!-- Header Kartu Wawancara -->
                <div class="p-6 bg-gradient-to-r from-blue-900 via-indigo-950 to-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/20 border border-blue-400/40 text-blue-300 flex items-center justify-center shrink-0 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/30 text-blue-200 border border-blue-400/30 uppercase tracking-wider">Tahap 04</span>
                                <h3 class="font-extrabold text-base sm:text-lg text-white">Kartu Informasi Seleksi Wawancara</h3>
                            </div>
                            <p class="text-xs text-slate-300 mt-0.5">Jadwal verifikasi faktual, petunjuk pelaksanaan, dan tata tertib wawancara beasiswa POLMED.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 self-end sm:self-center">
                        @if ($step4_done)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Wawancara Selesai (Skor: {{ $application->skor ?? 'Terdata' }})
                        </span>
                        @elseif ($step4_active)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/30 text-blue-200 border border-blue-400/40">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            Siap Mengikuti Wawancara
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-700/50 text-slate-300 border border-slate-600/40">
                            Menunggu Seleksi Berkas Lolos
                        </span>
                        @endif

                        <button type="button" @click="showWawancaraCard = false" class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white transition" title="Tutup Kartu">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Konten Kartu Wawancara -->
                <div class="p-6 space-y-6">
                    <!-- 3 Kotak Detail Jadwal & Lokasi -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-200/80 space-y-1">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Waktu & Sesi Wawancara</span>
                            <p class="font-extrabold text-sm text-slate-900">08.30 - 15.30 WIB</p>
                            <p class="text-xs text-slate-500">Sesuai sesi jadwal pemanggilan masing-masing prodi / jurusan.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Tempat / Ruang Wawancara</span>
                            <p class="font-extrabold text-sm text-slate-900">Gedung Direktorat Lt. 1</p>
                            <p class="text-xs text-slate-500">Ruang Rapat BAK POLMED / Tautan Zoom Resmi Panitia.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-indigo-50/70 border border-indigo-200/80 space-y-1">
                            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider block">Tim Penguji & Penilai</span>
                            <p class="font-extrabold text-sm text-slate-900">Tim Panitia Beasiswa BAK</p>
                            <p class="text-xs text-slate-500">Dosen Verifikator & Tim Bagian Administrasi Kemahasiswaan.</p>
                        </div>
                    </div>

                    <!-- Ketentuan & Tata Tertib Wawancara -->
                    <div class="space-y-3">
                        <h4 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tata Tertib & Persiapan Pelaksanaan Wawancara
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0 text-[11px] mt-0.5">1</span>
                                <div>
                                    <strong class="text-slate-800 block mb-0.5">Kehadiran Tepat Waktu</strong>
                                    Peserta wajib hadir paling lambat 15 menit sebelum waktu wawancara dimulai.
                                </div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0 text-[11px] mt-0.5">2</span>
                                <div>
                                    <strong class="text-slate-800 block mb-0.5">Membawa Berkas Asli</strong>
                                    Wajib membawa fisik dokumen asli: KTM, KTP, Kartu Keluarga, dan Slip Gaji / Surat Keterangan Penghasilan Ortu.
                                </div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0 text-[11px] mt-0.5">3</span>
                                <div>
                                    <strong class="text-slate-800 block mb-0.5">Pakaian Resmi & Rapi</strong>
                                    Mengenakan kemeja putih berkerah, bawahan hitam formal (bukan jeans), dan sepatu tertutup rapi.
                                </div>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0 text-[11px] mt-0.5">4</span>
                                <div>
                                    <strong class="text-slate-800 block mb-0.5">Materi Pengujian</strong>
                                    Fokus pengujian meliputi integritas data ekonomi keluarga, motivasi kuliah, dan keaktifan akademik.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tutup & Bantuan -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-500">
                            Jika memiliki kendala jadwal, silakan lapor ke loket BAK Gedung Direktorat Lt. 1.
                        </p>
                        <button type="button" @click="showWawancaraCard = false" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition shadow-sm">
                            Tutup Kartu Informasi
                        </button>
                    </div>
                </div>

            </div>

            {{-- ================================================================= --}}
            {{-- 3. GRID 2 KOLOM (KIRI IDENTITAS, KANAN DETAIL HASIL SELEKSI)      --}}
            {{-- ================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- KOLOM KIRI: CEK STATUS PENERIMAAN -->
                <div class="lg:col-span-4 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
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
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
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
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ $nim }}" readonly
                                    class="w-full pl-9 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono font-semibold text-slate-700 cursor-not-allowed">
                            </div>
                        </div>

                        <button type="button" onclick="window.location.reload()"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Periksa Status Seleksi</span>
                        </button>
                    </div>

                    <div class="pt-2 border-t border-slate-100 space-y-3 text-[11px] text-slate-500">
                        <div class="flex items-center gap-2 text-emerald-700">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Data terintegrasi secara langsung dengan SIAKAD & Database BAK POLMED.</span>
                        </div>

                        <div class="p-3 bg-blue-50/70 rounded-xl border border-blue-200/60 text-slate-700 leading-relaxed">
                            Gunakan NIM yang terdaftar resmi. Jika terdapat ketidaksesuaian status berkas, kunjungi loket layanan BAK Gedung Direktorat Lt. 1.
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: STATUS DETAIL / AKSI PENDAFTARAN -->
                <div class="lg:col-span-8 space-y-5">

                    @if (! $application)
                    <!-- TAMPILAN JIKA BELUM MENDAFTAR -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 mx-auto flex items-center justify-center shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-lg text-slate-800">Tahap 01: Mulai Pengisian Pendaftaran</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                                Anda saat ini berada pada <b>Tahap 01 (Pendaftaran)</b>. Silakan mengisi formulir identitas akademik dan kondisi ekonomi untuk menyelesaikan Tahap 01 agar otomatis ter-ceklist.
                            </p>
                        </div>
                        @if (Route::has('mahasiswa.pendaftaran'))
                        <a href="{{ route('mahasiswa.pendaftaran') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-500/20">
                            <span>Isi Formulir Pendaftaran Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        @endif
                    </div>
                    @else
                    <!-- TAMPILAN JIKA SUDAH MENDAFTAR: KARTU RINCIAN HASIL SELEKSI -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                        <!-- Banner Ringkas Status Hasil Terkini -->
                        <div class="p-6 {{ $isGagalAkhir ? 'bg-gradient-to-r from-red-900 to-rose-950' : ($isLolosAkhir ? 'bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900' : 'bg-gradient-to-r from-blue-900 via-indigo-950 to-slate-900') }} text-white space-y-2">
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
                                        {{ strtoupper($application->hasil_akhir) === 'DITERIMA' ? 'DITERIMA SEBAGAI PENERIMA BEASISWA' : 'TIDAK LOLOS SELEKSI BEASISWA' }}
                                        @elseif ($step3_lulus)
                                        Lolos Seleksi Berkas Administrasi
                                        @elseif ($step2_done)
                                        Menunggu Verifikasi Berkas oleh Tim BAK
                                        @else
                                        Tahap Pengunggahan Berkas Persyaratan
                                        @endif
                                    </h2>
                                    <p class="text-xs text-slate-300 mt-0.5">
                                        Status Pendaftaran: <span class="font-bold text-white uppercase">{{ $application->status }}</span>
                                    </p>
                                </div>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $isGagalAkhir ? 'bg-red-500/30 text-red-200 border border-red-400/40' : 'bg-emerald-500/30 text-emerald-200 border border-emerald-400/40' }} w-fit shrink-0">
                                    {{ $application->hasil_verifikasi ?? ($step3_lulus ? 'Terverifikasi' : 'Proses Seleksi') }}
                                </span>
                            </div>
                        </div>

                        <!-- Data Mahasiswa Ringkas -->
                        <div class="p-5 sm:p-6 border-b border-slate-100 bg-slate-50/50 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-blue-700 text-white font-black text-sm flex items-center justify-center shrink-0 shadow-inner">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-base text-slate-800">{{ auth()->user()->name }}</h4>
                                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Mahasiswa Aktif</span>
                                        </div>
                                        <p class="text-xs text-slate-500 font-mono">
                                            NIM: {{ $nim }} · POLMED
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
                                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Keputusan Akhir</span>
                                    <span class="font-bold {{ $isLolosAkhir ? 'text-emerald-600' : ($isGagalAkhir ? 'text-rose-600' : 'text-blue-700') }} truncate block">
                                        {{ $application->hasil_akhir ? ucfirst($application->hasil_akhir) : 'Belum ditetapkan' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Alur Seleksi 6 Tahap -->
                        <div class="p-5 sm:p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-sm sm:text-base text-slate-800">Detail Alur Seleksi Beasiswa</h4>
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">
                                    Hasil Verifikasi: {{ $application->hasil_verifikasi ?? 'Proses Verifikasi' }}
                                </span>
                            </div>

                            <div class="space-y-3 text-xs">
                                <!-- Detail 1: Pendaftaran -->
                                <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">1. Pendaftaran Berkas Administrasi</span>
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">TERCATAT</span>
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">Identitas diri, data akademik semester & IPK, serta data ekonomi telah tersimpan di sistem.</p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">Selesai</span>
                                </div>

                                <!-- Detail 2: Input Berkas -->
                                <div class="p-3.5 rounded-xl border {{ $step2_done ? 'border-emerald-200 bg-emerald-50/40' : ($step2_active ? 'border-blue-200 bg-blue-50/40 ring-1 ring-blue-300' : 'border-slate-200 bg-slate-50/40') }} flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full {{ $step2_done ? 'bg-emerald-600 text-white' : ($step2_active ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600') }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            {{ $step2_done ? '✓' : '2' }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">2. Input Berkas Persyaratan</span>
                                                @if ($step2_done)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">LENGKAP</span>
                                                @elseif ($step2_active)
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">SEDANG PROSES</span>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">BELUM DIAJUKAN</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">
                                                Unggah berkas wajib: Kartu Keluarga (KK), KTM, dan Slip Gaji / Keterangan Penghasilan.
                                                @if (!$step2_done && Route::has('mahasiswa.dokumen'))
                                                <a href="{{ route('mahasiswa.dokumen') }}" class="text-blue-600 font-semibold hover:underline ml-1">Unggah berkas sekarang →</a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">{{ $totalDocs }} Berkas</span>
                                </div>

                                <!-- Detail 3: Pengumuman Seleksi Berkas -->
                                <div class="p-3.5 rounded-xl border {{ $step3_lulus ? 'border-emerald-200 bg-emerald-50/40' : ($step3_ditolak ? 'border-rose-200 bg-rose-50/40' : ($step3_active ? 'border-blue-200 bg-blue-50/40' : 'border-slate-200 bg-slate-50/40')) }} flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full {{ $step3_lulus ? 'bg-emerald-600 text-white' : ($step3_ditolak ? 'bg-rose-600 text-white' : ($step3_active ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600')) }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            {{ $step3_lulus ? '✓' : ($step3_ditolak ? '✕' : '3') }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">3. Pengumuman Seleksi Berkas & Verifikasi Faktual</span>
                                                @if ($step3_lulus)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">LOLOS VERIFIKASI</span>
                                                @elseif ($step3_ditolak)
                                                <span class="text-[10px] font-bold text-rose-700 bg-rose-100 px-2 py-0.5 rounded">BERKAS DITOLAK</span>
                                                @elseif ($step3_active)
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">MENUNGGU VERIFIKASI ADMIN</span>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">BELUM DIMULAI</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">Pemeriksaan keabsahan dokumen oleh tim verifikator BAK POLMED.</p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">{{ $validDocs }} Valid</span>
                                </div>

                                <!-- Detail 4: Tahap Seleksi Wawancara -->
                                <div class="p-3.5 rounded-xl border {{ $step4_done ? 'border-emerald-200 bg-emerald-50/40' : ($step4_active ? 'border-blue-200 bg-blue-50/40' : 'border-slate-200 bg-slate-50/40') }} flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full {{ $step4_done ? 'bg-emerald-600 text-white' : ($step4_active ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600') }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            {{ $step4_done ? '✓' : '4' }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">4. Tahap Seleksi Wawancara & Uji Faktual</span>
                                                @if ($step4_done)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">SELESAI</span>
                                                @elseif ($step4_active)
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">PROSES WAWANCARA</span>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">MENUNGGU TAHAP 3</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">
                                                Wawancara komprehensif profil akademik, komitmen, dan validasi kondisi ekonomi.
                                                <button type="button" @click="showWawancaraCard = true" class="text-blue-600 font-semibold hover:underline ml-1">Lihat detail wawancara →</button>
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">Penguji</span>
                                </div>

                                <!-- Detail 5: Pengumuman Hasil Wawancara -->
                                <div class="p-3.5 rounded-xl border {{ $step5_done ? 'border-emerald-200 bg-emerald-50/40' : ($step5_active ? 'border-blue-200 bg-blue-50/40' : 'border-slate-200 bg-slate-50/40') }} flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full {{ $step5_done ? 'bg-emerald-600 text-white' : ($step5_active ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600') }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            {{ $step5_done ? '✓' : '5' }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">5. Pengumuman Hasil Wawancara & Skor Penilaian</span>
                                                @if ($step5_done)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">DIUMUMKAN</span>
                                                @elseif ($step5_active)
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">REKAPITULASI</span>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">MENUNGGU JADWAL</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">Penetapan skor evaluasi tim penguji dan kelayakan kandidat beasiswa.</p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">BAK POLMED</span>
                                </div>

                                <!-- Detail 6: Pengumuman Kelulusan Final -->
                                <div class="p-3.5 rounded-xl border {{ $isLolosAkhir ? 'border-emerald-300 bg-emerald-50/60' : ($isGagalAkhir ? 'border-rose-300 bg-rose-50/60' : ($step6_active ? 'border-blue-200 bg-blue-50/40' : 'border-slate-200 bg-slate-50/40')) }} flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full {{ $isLolosAkhir ? 'bg-emerald-600 text-white' : ($isGagalAkhir ? 'bg-rose-600 text-white' : ($step6_active ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600')) }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            {{ $isLolosAkhir ? '✓' : ($isGagalAkhir ? '✕' : '6') }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800">6. Pengumuman Kelulusan Final & Penerbitan SK</span>
                                                @if ($isLolosAkhir)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">LOLOS PENERIMA BEASISWA</span>
                                                @elseif ($isGagalAkhir)
                                                <span class="text-[10px] font-bold text-rose-700 bg-rose-100 px-2 py-0.5 rounded">TIDAK LOLOS</span>
                                                @elseif ($step6_active)
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">MENUNGGU SK DIREKTUR</span>
                                                @else
                                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">TAHAP AKHIR</span>
                                                @endif
                                            </div>
                                            <p class="text-slate-500 text-[11px] mt-0.5">Keputusan resmi melalui Surat Keputusan (SK) Direktur Politeknik Negeri Medan.</p>
                                        </div>
                                    </div>
                                    <span class="text-[11px] font-bold {{ $isLolosAkhir ? 'text-emerald-700' : ($isGagalAkhir ? 'text-rose-700' : 'text-slate-400') }} shrink-0">
                                        {{ $application->hasil_akhir ? ucfirst($application->hasil_akhir) : 'Pending' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tombol Aksi Cetak & Layanan -->
                            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                                <button type="button" onclick="window.print()"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs transition shadow-sm">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Unduh Bukti Tanda Lolos (.PDF)</span>
                                </button>

                                <a href="#pusat-bantuan"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Hubungi Layanan BAK</span>
                                </a>
                            </div>
                        </div>

                    </div>
                    @endif

                    <!-- KETENTUAN RESMI -->
                    <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-4.5 flex items-start gap-3 text-xs text-blue-900">
                        <span class="p-1.5 bg-blue-100 text-blue-700 rounded-lg shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <p class="leading-relaxed">
                            <strong>Ketentuan Resmi:</strong> Mahasiswa yang telah dinyatakan lolos seleksi wajib memastikan data rekening bank aktif atas nama pribadi dan tidak sedang menerima beasiswa dari sumber Anggaran Pendapatan dan Belanja Negara (APBN) lain secara bersamaan.
                        </p>
                    </div>

                </div>

            </div>
</x-app-layout>