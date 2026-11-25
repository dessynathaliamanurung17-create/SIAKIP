<x-app-layout>
    @php
        $mhs       = $application->mahasiswa;
        $user      = $mhs?->user;
        $nama      = $user?->name ?? 'Mahasiswa';
        $parts     = preg_split('/\s+/', trim($nama));
        $initials  = strtoupper(substr($parts[0] ?? 'M', 0, 1) . substr($parts[1] ?? ($parts[0] ?? ''), 0, 1));
        $statusVal = strtolower($application->status ?? 'draft');

        $docs        = $application->documents;
        $totalDocs   = $docs->count();
        $validDocs   = $docs->where('status_verifikasi', 'valid')->count();
        $semuaValid  = $totalDocs > 0 && $validDocs === $totalDocs;

        $penghasilan = $application->penghasilan_ortu;
        $penghasilanFmt = is_numeric($penghasilan)
            ? 'Rp ' . number_format((float) $penghasilan, 0, ',', '.')
            : ($penghasilan ?: '-');

        // Format nomor HP untuk tautan WhatsApp wawancara
        $rawHp = preg_replace('/[^0-9]/', '', (string) ($mhs?->no_hp ?? ''));
        if (str_starts_with($rawHp, '0')) {
            $waNumber = '62' . substr($rawHp, 1);
        } else {
            $waNumber = $rawHp;
        }
        $waText = rawurlencode(
            "Halo {$nama} (NIM: {$application->mahasiswa_nim}), kami dari Tim Seleksi Beasiswa SIBEKA. "
            . ($application->jadwal_wawancara ? "Anda dijadwalkan mengikuti wawancara pada {$application->jadwal_wawancara}. " : "Anda dijadwalkan untuk tahap wawancara seleksi beasiswa. ")
            . "Mohon konfirmasi kesiapan Anda. Terima kasih."
        );
        $waUrl = $waNumber ? "https://wa.me/{$waNumber}?text={$waText}" : null;
    @endphp

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="space-y-1">
                <a href="{{ route('admin.pelamar') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:text-blue-800 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Kembali</span>
                </a>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Detail Pelamar</h2>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($statusVal === 'diverifikasi')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Status: Diverifikasi
                    </span>
                @elseif ($statusVal === 'diajukan')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        Status: Diajukan
                    </span>
                @elseif ($statusVal === 'ditolak')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Status: Ditolak
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Status: Draft
                    </span>
                @endif

                @if ($application->hasil_akhir)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border shadow-sm {{ $application->hasil_akhir === 'diterima' ? 'bg-emerald-600 text-white border-emerald-700' : 'bg-rose-600 text-white border-rose-700' }}">
                        Hasil Akhir: {{ ucfirst($application->hasil_akhir) }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- FLASH ALERTS -->
            @if (session('status'))
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="space-y-1">
                        <p class="font-bold">Terjadi kesalahan saat menyimpan:</p>
                        <ul class="list-disc ps-4 space-y-0.5 text-xs">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- BANNER RINGKASAN PROFIL PELAMAR -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-blue-700 text-white font-black text-lg flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20 border border-blue-200">
                            @if ($mhs?->foto_url)
                                <img src="{{ $mhs->foto_url }}" alt="Foto {{ $nama }}" class="w-full h-full object-cover">
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">{{ $nama }}</h3>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                                <span class="font-mono font-semibold text-slate-700">NIM: {{ $application->mahasiswa_nim }}</span>
                                @if ($mhs?->asal_kampus)
                                    <span class="text-slate-300">•</span>
                                    <span class="font-semibold text-blue-700">{{ $mhs->asal_kampus }}</span>
                                @endif
                                <span class="text-slate-300">•</span>
                                <span>{{ $mhs?->program_studi ?? '-' }}</span>
                                <span class="text-slate-300">•</span>
                                <span>{{ $mhs?->jurusan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- MINI STATS -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 shrink-0">
                        <div class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-right">
                            <span class="block text-xs font-medium text-slate-500">IPK</span>
                            <span class="text-base font-bold font-mono text-slate-900">{{ number_format((float) $application->ipk, 2) }}</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-right">
                            <span class="block text-xs font-medium text-slate-500">Semester</span>
                            <span class="text-base font-bold font-mono text-slate-900">{{ $application->semester }}</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-right">
                            <span class="block text-xs font-medium text-slate-500">Dokumen</span>
                            <span class="text-base font-bold font-mono {{ $semuaValid ? 'text-emerald-600' : 'text-blue-600' }}">{{ $validDocs }}/{{ $totalDocs }}</span>
                        </div>
                        <div class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-right">
                            <span class="block text-xs font-medium text-slate-500">Skor</span>
                            <span class="text-base font-bold font-mono text-slate-900">{{ $application->skor !== null ? number_format((float) $application->skor, 2) : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTEN 2 KOLOM -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                <!-- KOLOM KIRI: DATA IDENTITAS, AKADEMIK, EKONOMI, DOKUMEN -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- 1. IDENTITAS & AKADEMIK -->
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-6">
                        <div class="pb-3 border-b border-slate-100">
                            <h3 class="font-bold text-base text-slate-900">Identitas & Akademik</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Nama Lengkap</span>
                                <p class="font-semibold text-slate-900 mt-1">{{ $nama }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Email</span>
                                <p class="font-medium text-slate-800 mt-1 break-all">{{ $user?->email ?? '-' }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">NIM</span>
                                <p class="font-mono font-semibold text-slate-900 mt-1">{{ $application->mahasiswa_nim }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">No. HP / WhatsApp</span>
                                <p class="font-mono font-medium text-slate-800 mt-1">{{ $mhs?->no_hp ?: '-' }}</p>
                            </div>
                            <div class="sm:col-span-2 p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Asal Kampus / Perguruan Tinggi</span>
                                <p class="font-semibold text-slate-900 mt-1">{{ $mhs?->asal_kampus ?: '-' }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Jurusan</span>
                                <p class="font-medium text-slate-800 mt-1">{{ $mhs?->jurusan ?: '-' }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Program Studi</span>
                                <p class="font-medium text-slate-800 mt-1">{{ $mhs?->program_studi ?: '-' }}</p>
                            </div>
                            <div class="sm:col-span-2 p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Riwayat Prestasi</span>
                                <p class="text-slate-700 mt-1 leading-relaxed">{{ $application->riwayat_prestasi ?: '-' }}</p>
                            </div>
                            <div class="sm:col-span-2 p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Riwayat Beasiswa</span>
                                <p class="text-slate-700 mt-1 leading-relaxed">{{ $application->riwayat_beasiswa ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. KONDISI EKONOMI (TERENKRIPSI) -->
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-6">
                        <div class="flex items-center justify-between gap-3 pb-3 border-b border-slate-100">
                            <h3 class="font-bold text-base text-slate-900">Kondisi Ekonomi</h3>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Audit Log Aktif
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Penghasilan Orang Tua</span>
                                <p class="font-mono font-semibold text-slate-900 mt-1">{{ $penghasilanFmt }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Pekerjaan Orang Tua</span>
                                <p class="font-medium text-slate-800 mt-1">{{ $application->pekerjaan_ortu ?: '-' }}</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Jumlah Tanggungan</span>
                                <p class="font-semibold text-slate-900 mt-1"><span class="font-mono">{{ $application->jumlah_tanggungan }}</span> Orang</p>
                            </div>
                            <div class="sm:col-span-3 p-3.5 rounded-2xl bg-slate-50/70 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block">Deskripsi Kondisi Ekonomi</span>
                                <p class="text-slate-700 mt-1 leading-relaxed">{{ $application->kondisi_ekonomi ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. DOKUMEN PERSYARATAN -->
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-5">
                        <div class="flex items-center justify-between gap-3 pb-3 border-b border-slate-100">
                            <h3 class="font-bold text-base text-slate-900">Dokumen</h3>
                            <span class="text-xs font-mono font-semibold px-2.5 py-1 rounded-full border {{ $semuaValid ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                {{ $validDocs }}/{{ $totalDocs }} Valid
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse ($docs as $doc)
                                @php
                                    $isPdf = str_ends_with(strtolower($doc->nama_asli ?? ''), '.pdf');
                                    $docStatus = strtolower($doc->status_verifikasi ?? 'menunggu');
                                @endphp
                                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/50 p-4 space-y-3">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="p-2 rounded-xl {{ $isPdf ? 'bg-rose-50 text-rose-600' : 'bg-blue-50 text-blue-600' }} shrink-0 mt-0.5">
                                                @if ($isPdf)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase bg-blue-100 text-blue-800">
                                                        {{ strtoupper($doc->jenis) }}
                                                    </span>
                                                    <span class="font-bold text-slate-900 text-xs sm:text-sm truncate" title="{{ $doc->nama_asli }}">
                                                        {{ $doc->nama_asli }}
                                                    </span>
                                                </div>
                                                <p class="text-[10px] text-slate-400 font-mono mt-1 break-all">
                                                    SHA-256: {{ $doc->sha256 }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 shrink-0">
                                            @if ($docStatus === 'valid')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    ✓ Valid
                                                </span>
                                            @elseif ($docStatus === 'tidak_valid')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                    ✕ Tidak Valid
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                    ⏳ Menunggu
                                                </span>
                                            @endif

                                            <a href="{{ route('dokumen.unduh', $doc) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs border border-slate-200 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                <span>Unduh</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- FORM VERIFIKASI PER DOKUMEN -->
                                    <form method="POST" action="{{ route('admin.dokumen.verifikasi', $doc) }}"
                                        class="pt-3 border-t border-slate-200/70 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                                        @csrf
                                        @method('PUT')

                                        <select name="status_verifikasi"
                                            class="text-xs font-semibold bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            <option value="valid" @selected($doc->status_verifikasi === 'valid')>Valid</option>
                                            <option value="tidak_valid" @selected($doc->status_verifikasi === 'tidak_valid')>Tidak Valid (Revisi)</option>
                                        </select>

                                        <input type="text" name="catatan" value="{{ $doc->catatan }}"
                                            placeholder="Tambahkan catatan verifikasi (opsional)..."
                                            class="flex-1 text-xs bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-slate-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                                        <button type="submit"
                                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition shadow-sm shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>Simpan</span>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="py-10 text-center rounded-2xl border border-dashed border-slate-200 bg-slate-50/50">
                                    <p class="font-bold text-xs text-slate-600">Belum Ada Dokumen Diunggah</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Mahasiswa belum mengunggah berkas persyaratan beasiswa.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN: PANEL PROSES SELEKSI (STICKY) -->
                <div class="lg:col-span-1 lg:sticky lg:top-6">
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-5">
                        <div class="pb-3 border-b border-slate-100">
                            <h3 class="font-bold text-base text-slate-900">Proses Seleksi</h3>
                        </div>

                        <!-- INFO INTEGRITAS DOKUMEN -->
                        @if ($semuaValid)
                            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-medium flex items-start gap-2">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Semua dokumen sudah valid. Hasil akhir dapat ditetapkan.</span>
                            </div>
                        @else
                            <div class="p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-medium flex items-start gap-2">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Hasil akhir hanya bisa ditetapkan setelah seluruh dokumen berstatus <b>Valid</b>.</span>
                            </div>
                        @endif

                        <!-- HUBUNGI WAWANCARA VIA WHATSAPP -->
                        @if ($waUrl)
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.86 11.86 0 0012.06 0C5.47 0 .1 5.37.1 11.96c0 2.1.55 4.16 1.6 5.97L0 24l6.24-1.64a11.9 11.9 0 005.82 1.49h.01c6.59 0 11.96-5.37 11.96-11.96 0-3.2-1.25-6.2-3.51-8.41zM12.07 21.8h-.01a9.87 9.87 0 01-5.04-1.38l-.36-.21-3.7.97.99-3.61-.24-.37a9.84 9.84 0 01-1.51-5.24c0-5.44 4.43-9.87 9.88-9.87 2.64 0 5.12 1.03 6.98 2.9a9.82 9.82 0 012.89 6.98c0 5.45-4.43 9.83-9.88 9.83zm5.42-7.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.21 5.09 4.5.71.31 1.27.49 1.7.63.72.23 1.37.2 1.88.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35z"/></svg>
                                <span>Hubungi Wawancara (WhatsApp)</span>
                            </a>
                        @else
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 text-center">
                                Mahasiswa belum mengisi nomor HP/WhatsApp.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.pelamar.seleksi', $application) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="status" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Status Pendaftaran
                                </label>
                                <select id="status" name="status"
                                    class="w-full text-sm font-medium bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    @foreach (['draft' => 'Draft', 'diajukan' => 'Diajukan', 'diverifikasi' => 'Diverifikasi', 'ditolak' => 'Ditolak'] as $val => $label)
                                        <option value="{{ $val }}" @selected(old('status', $application->status) === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="status_wawancara" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Status Wawancara
                                </label>
                                <select id="status_wawancara" name="status_wawancara"
                                    class="w-full text-sm font-medium bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    @foreach (['belum' => 'Belum Dijadwalkan', 'dijadwalkan' => 'Dijadwalkan (Siap WA)', 'lulus' => 'Lulus Wawancara', 'tidak_lulus' => 'Tidak Lulus Wawancara'] as $val => $label)
                                        <option value="{{ $val }}" @selected(old('status_wawancara', $application->status_wawancara ?? 'belum') === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jadwal_wawancara" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Jadwal Wawancara (Opsional)
                                </label>
                                <input id="jadwal_wawancara" type="text" name="jadwal_wawancara"
                                    value="{{ old('jadwal_wawancara', $application->jadwal_wawancara) }}"
                                    placeholder="Contoh: Kamis, 28 Nov · 10:00 WIB"
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="skor" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Skor Penilaian (0 – 100)
                                </label>
                                <input id="skor" type="number" step="0.01" min="0" max="100" name="skor"
                                    value="{{ old('skor', $application->skor) }}"
                                    placeholder="Contoh: 87.50"
                                    class="w-full text-sm font-mono font-medium bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="hasil_verifikasi" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Catatan / Hasil Verifikasi
                                </label>
                                <textarea id="hasil_verifikasi" name="hasil_verifikasi" rows="3"
                                    placeholder="Tuliskan catatan pemeriksaan berkas atau alasan keputusan..."
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('hasil_verifikasi', $application->hasil_verifikasi) }}</textarea>
                            </div>

                            <div>
                                <label for="hasil_akhir" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Keputusan Hasil Akhir
                                </label>
                                <select id="hasil_akhir" name="hasil_akhir"
                                    class="w-full text-sm font-medium bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <option value="">(Belum Ditetapkan)</option>
                                    <option value="diterima" @selected(old('hasil_akhir', $application->hasil_akhir) === 'diterima')>Diterima</option>
                                    <option value="ditolak" @selected(old('hasil_akhir', $application->hasil_akhir) === 'ditolak')>Ditolak</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm transition shadow-md shadow-blue-600/20">
                                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Simpan Seleksi</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
