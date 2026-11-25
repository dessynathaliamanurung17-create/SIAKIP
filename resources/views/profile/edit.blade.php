<x-app-layout>
    @php
        $nama     = $user->name ?? 'Pengguna';
        $parts    = preg_split('/\s+/', trim($nama));
        $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? ($parts[0] ?? ''), 0, 1));
        $isAdmin  = $user->isAdmin();
        $mhs      = $mahasiswa ?? $user->mahasiswa;
        $app      = $mhs?->application;

        $statusLabel = 'Belum Mendaftar';
        $statusClass = 'bg-slate-100 text-slate-600 border-slate-200';
        if ($app) {
            $st = strtolower($app->status ?? 'draft');
            $ha = strtolower($app->hasil_akhir ?? '');
            if ($ha === 'diterima') {
                $statusLabel = 'Lolos Seleksi';
                $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            } elseif ($ha === 'ditolak' || $st === 'ditolak') {
                $statusLabel = 'Tidak Lolos';
                $statusClass = 'bg-rose-50 text-rose-700 border-rose-200';
            } elseif ($st === 'diverifikasi') {
                $statusLabel = 'Berkas Diverifikasi';
                $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            } elseif ($st === 'diajukan') {
                $statusLabel = 'Diajukan (Menunggu Verifikasi)';
                $statusClass = 'bg-blue-50 text-blue-700 border-blue-200';
            } else {
                $statusLabel = 'Draft (Belum Diajukan)';
                $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
            }
        }
    @endphp

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">
                    {{ $isAdmin ? 'Profil Akun' : 'Profil Mahasiswa Pendaftar Beasiswa' }}
                </h2>
                @unless ($isAdmin)
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Data identitas akademik dan kontak resmi yang digunakan pada proses seleksi beasiswa.
                    </p>
                @endunless
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $isAdmin ? 'bg-blue-50 text-blue-700 border border-blue-200' : $statusClass }} border shadow-sm">
                    <span class="w-2 h-2 rounded-full {{ $isAdmin ? 'bg-blue-600' : 'bg-current opacity-75' }}"></span>
                    {{ $isAdmin ? 'Administrator SIBEKA' : $statusLabel }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 {{ $isAdmin ? '' : 'bg-[#eef4fb]/70 min-h-screen' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if ($isAdmin)
                <!-- RINGKASAN AKUN ADMIN -->
                <div class="bg-white rounded-2xl border border-blue-100/90 shadow-sm p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#0c1f4a] to-blue-600 text-white font-bold text-lg flex items-center justify-center shrink-0 shadow-md shadow-blue-900/20">
                                {{ $initials }}
                            </div>
                            <div class="space-y-0.5 min-w-0">
                                <h3 class="text-lg font-bold text-slate-900 truncate">{{ $nama }}</h3>
                                <p class="text-sm text-slate-500 truncate">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-xs text-slate-600">
                            <span class="px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 font-mono">
                                ID #{{ $user->id }}
                            </span>
                            @if ($user->created_at)
                                <span class="px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                    Terdaftar <span class="font-mono">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- KARTU IDENTITAS FORMAL MAHASISWA PENDAFTAR BEASISWA -->
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                    <!-- Header Banner Formal Navy -->
                    <div class="bg-gradient-to-r from-[#081533] via-[#0c1f4a] to-[#132d69] px-6 py-6 sm:px-8 sm:py-7 text-white">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white/10 border-2 border-white/30 text-white font-bold text-xl flex items-center justify-center shrink-0 shadow-inner">
                                    @if ($mhs?->foto_url)
                                        <img src="{{ $mhs->foto_url }}" alt="Foto {{ $nama }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <p class="text-[11px] font-semibold tracking-wider text-sky-300 uppercase">
                                        Kartu Identitas Pendaftar Beasiswa • SIBEKA
                                    </p>
                                    <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-white truncate">
                                        {{ $nama }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-blue-100/85">
                                        <span class="font-mono font-semibold text-white">NIM: {{ $mhs?->nim ?? '-' }}</span>
                                        @if ($mhs?->asal_kampus)
                                            <span class="text-blue-300/50">•</span>
                                            <span class="font-semibold text-sky-200">{{ $mhs->asal_kampus }}</span>
                                        @endif
                                        <span class="text-blue-300/50">•</span>
                                        <span>{{ $mhs?->program_studi ?? '-' }}</span>
                                        <span class="text-blue-300/50">•</span>
                                        <span>{{ $mhs?->jurusan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Keamanan & Biometrik -->
                            <div class="flex flex-wrap md:flex-col items-start md:items-end gap-2 shrink-0">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold {{ $mhs?->face_descriptor ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-200 border border-amber-400/30' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Verifikasi Wajah: {{ $mhs?->face_descriptor ? 'Terdaftar' : 'Belum Terdaftar' }}
                                </span>
                                @if ($user->created_at)
                                    <span class="text-[11px] text-blue-200/75">
                                        Akun terdaftar sejak <span class="font-mono text-white">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Data Akademik Formal & Tautan Cepat -->
                    <div class="px-6 py-4 sm:px-8 bg-slate-50/70 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs">
                            <div>
                                <span class="text-slate-400 block">Email Resmi</span>
                                <span class="font-semibold text-slate-800">{{ $user->email }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">No. HP / WhatsApp</span>
                                <span class="font-mono font-semibold text-slate-800">{{ $mhs?->no_hp ?: '-' }}</span>
                            </div>
                            @if ($app)
                                <div>
                                    <span class="text-slate-400 block">IPK / Semester</span>
                                    <span class="font-mono font-semibold text-slate-800">
                                        {{ number_format((float) $app->ipk, 2) }} / Smt {{ $app->semester }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                            <a href="{{ route('mahasiswa.pendaftaran') }}"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition shadow-sm">
                                <span>Formulir Pendaftaran</span>
                            </a>
                            <a href="{{ route('mahasiswa.dokumen') }}"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-semibold text-xs transition">
                                <span>Dokumen</span>
                            </a>
                            <a href="{{ route('mahasiswa.status') }}"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-semibold text-xs transition">
                                <span>Status Seleksi</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- GRID 2 KOLOM: INFORMASI PROFIL & UBAH KATA SANDI -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-7">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- ZONA BERBAHAYA: HAPUS AKUN -->
            <div class="bg-white rounded-2xl border border-rose-200/80 shadow-sm p-6 sm:p-7">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
