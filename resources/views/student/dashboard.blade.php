<x-app-layout>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. HERO PROFILE CARD -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-950 text-white shadow-xl p-6 sm:p-8">
                <!-- Background Accent Blur -->
                <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl bg-white/10 border border-white/20 text-white flex items-center justify-center font-black text-2xl shadow-inner shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-500/30 text-blue-300 border border-blue-400/30">
                                Mahasiswa Aktif
                            </div>
                            <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight">{{ auth()->user()->name }}</h1>
                            <p class="text-xs text-slate-300 font-mono">
                                NIM: {{ $mhs?->nim ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Shortcut Status Cepat -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 flex items-center gap-4 shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/30 text-blue-300 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="text-xs">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Berkas Terunggah</span>
                            <span class="text-lg font-black text-white">
                                {{ $jumlahDokumen ?? 0 }} <span class="text-xs font-normal text-slate-300">Dokumen</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. DATA IDENTITAS & AKADEMIK (DARI PROFIL) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base text-slate-800">Identitas Akademik Mahasiswa</h3>
                            <p class="text-xs text-slate-500">Data sinkronisasi dari pangkalan data akademik kampus</p>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg">
                        Terdaftar di PDDikti
                    </span>
                </div>

                <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nama Lengkap</span>
                        <span class="text-sm font-bold text-slate-800 block truncate">{{ auth()->user()->name }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nomor Induk Mahasiswa (NIM)</span>
                        <span class="text-sm font-bold text-slate-800 font-mono block">{{ $mhs?->nim ?? '-' }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Jurusan / Program Studi</span>
                        <span class="text-sm font-bold text-slate-800 block truncate">
                            {{ $mhs?->jurusan ?? '-' }} / {{ $mhs?->program_studi ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 3. STATUS PENDAFTARAN BEASISWA CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base text-slate-800">Status Pengajuan Beasiswa</h3>
                            <p class="text-xs text-slate-500">Tahapan seleksi dan kelengkapan administrasi Anda</p>
                        </div>
                    </div>

                    <!-- Badge Status Dinamis -->
                    @if ($application)
                    @php
                    $status = strtolower($application->status ?? '');
                    @endphp
                    @if (str_contains($status, 'draft'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Draft (Belum Diajukan)
                    </span>
                    @elseif (str_contains($status, 'lulus') || str_contains($status, 'diterima'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Lolos Seleksi
                    </span>
                    @elseif (str_contains($status, 'tolak'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        Belum Memenuhi Syarat
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        Sedang Diproses
                    </span>
                    @endif
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        Belum Mendaftar
                    </span>
                    @endif
                </div>

                <div class="p-6 space-y-6">
                    @if ($application)
                    <!-- Tampilan Jika Sudah Ada Pengajuan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Status Pengajuan</span>
                                <span class="text-base font-bold text-slate-800 capitalize">{{ $application->status }}</span>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                OK
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Dokumen Terunggah</span>
                                <span class="text-base font-bold text-slate-800">{{ $jumlahDokumen }} Berkas Lengkap</span>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                {{ $jumlahDokumen }}
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500">
                            Pastikan berkas pendukung pada menu dokumen telah terunggah dengan jelas.
                        </p>
                        <a href="{{ route('mahasiswa.pendaftaran') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-500/20">
                            <span>{{ $application ? 'Lihat / ubah pendaftaran' : 'Isi pendaftaran beasiswa' }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                    @else
                    <!-- Tampilan Jika Belum Mendaftar -->
                    <div class="py-6 text-center space-y-4 max-w-md mx-auto">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 mx-auto flex items-center justify-center shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-base text-slate-800">Anda Belum Mengajukan Pendaftaran</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Segera isi data formulir akademik dan kondisi ekonomi keluarga untuk mengikuti seleksi beasiswa periode aktif.
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('mahasiswa.pendaftaran') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-500/20">
                                <span>{{ $application ? 'Lihat / ubah pendaftaran' : 'Isi pendaftaran beasiswa' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 4. PUSAT INFORMASI & TAUTAN KEMAHASISWAAN POLMED -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-xs space-y-1">
                        <h5 class="font-bold text-slate-800 text-sm">Ketentuan Seleksi & Validasi</h5>
                        <p class="text-slate-500 leading-relaxed">
                            Data yang diinputkan akan diverifikasi silang dengan KHS resmi SIAKAD dan berkas digital yang Anda unggah.
                        </p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="text-xs space-y-1">
                        <h5 class="font-bold text-slate-800 text-sm">Pusat Layanan BAK POLMED</h5>
                        <p class="text-slate-500 leading-relaxed">
                            Jika terdapat ketidaksesuaian data identitas atau prodi, silakan hubungi bagian kemahasiswaan Gedung Direktorat Lt. 1.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>