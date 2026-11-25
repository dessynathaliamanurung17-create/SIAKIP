<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Dokumen Persyaratan Beasiswa</h2>
                <p class="text-sm text-slate-500">Unggah dan kelola berkas digital legalisir untuk seleksi administrasi.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Format: PDF, JPG, PNG (Maks 2MB)
                </span>
            </div>
        </div>
    </x-slot>

    @php
    $jenisList = [
    'kk' => 'Kartu Keluarga (KK)',
    'ktm' => 'KTM / KTP Mahasiswa',
    'penghasilan' => 'Surat Keterangan Penghasilan / Slip Gaji',
    'lainnya' => 'Dokumen Pendukung / Sertifikat Prestasi'
    ];

    // Hitung ringkasan status berkas secara dinamis tanpa mengubah query backend
    $totalWajib = count($jenisList);
    $terunggahCount = 0;
    $validCount = 0;
    $menungguCount = 0;
    $revisiCount = 0;

    foreach ($jenisList as $k => $l) {
    $d = $documents[$k] ?? null;

    if ($d) {
    $terunggahCount++;
    $st = strtolower($d->status_verifikasi ?? '');

    if (str_contains($st, 'tidak') || str_contains($st, 'tolak') || str_contains($st, 'revisi')) {
    $revisiCount++;
    } elseif (str_contains($st, 'valid') || str_contains($st, 'setuju') || str_contains($st, 'diterima')) {
    $validCount++;
    } else {
    $menungguCount++;
    }
    }
    }
    @endphp

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER BANNER -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-950 text-white shadow-xl p-6 sm:p-8">
                <div class="relative z-10 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300 border border-blue-400/30">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        PORTAL BERKAS DIGITAL MAHASISWA
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Daftar Dokumen Persyaratan Beasiswa
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Pantau kelengkapan berkas digital Anda secara terpusat. Pastikan seluruh dokumen legal, terbaca dengan jelas, dan sesuai panduan verifikasi Bagian Administrasi Kemahasiswaan.
                    </p>
                </div>
            </div>

            <!-- STATISTIK / RINGKASAN STATUS BERKAS -->
            <div id="stat-cards" class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Card 1: Kelengkapan -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Dokumen Wajib
                        </span>

                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="text-2xl font-black text-slate-900">
                            {{ $terunggahCount }}
                            <span class="text-sm font-semibold text-slate-400">
                                / {{ $totalWajib }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 mt-0.5">
                            Berkas Terunggah
                        </p>
                    </div>

                    <div class="w-full bg-slate-100 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-blue-600 h-1.5 rounded-full"
                            style="width: {{ $totalWajib > 0 ? ($terunggahCount / $totalWajib) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Card 2: Status Verifikasi Realtime -->
                @php
                    $semuaTerunggah = $totalWajib > 0 && $terunggahCount === $totalWajib;
                    $semuaTerverifikasi = $semuaTerunggah && $validCount === $totalWajib;

                    if ($semuaTerverifikasi) {
                        $statusBadgeText = 'Berkas Telah Diverifikasi';
                        $statusBadgeClass = 'text-emerald-700 bg-emerald-50 border border-emerald-200';
                        $statusIconClass = 'bg-emerald-50 text-emerald-600';
                    } elseif ($semuaTerunggah) {
                        $statusBadgeText = 'Menunggu Diverifikasi';
                        $statusBadgeClass = 'text-amber-700 bg-amber-50 border border-amber-200';
                        $statusIconClass = 'bg-amber-50 text-amber-600';
                    } else {
                        $statusBadgeText = 'Belum Diupload';
                        $statusBadgeClass = 'text-amber-700 bg-amber-50 border border-amber-200';
                        $statusIconClass = 'bg-amber-50 text-amber-600';
                    }
                @endphp

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Status Verifikasi
                        </span>

                        <div class="w-7 h-7 rounded-lg {{ $statusIconClass }} flex items-center justify-center">
                            @if ($semuaTerverifikasi)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="text-2xl font-black text-slate-900">
                            {{ $validCount }}
                            <span class="text-sm font-semibold text-slate-400">
                                / {{ $totalWajib }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 mt-0.5">
                            Berkas Disetujui
                        </p>
                    </div>

                    <span class="text-[10px] {{ $statusBadgeClass }} font-medium px-2 py-0.5 rounded-md mt-2 inline-block w-fit">
                        {{ $statusBadgeText }}
                    </span>
                </div>

            </div>

            <!-- NOTIFIKASI STATUS & ERROR ALERTS -->
            @if (session('status'))
            <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <div class="text-sm font-medium">
                    {{ session('status') }}
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-900 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333-.77 3 1.732 3z" />
                </svg>

                <div class="space-y-1 text-sm">
                    <div class="font-semibold">
                        Terjadi kendala saat mengunggah berkas:
                    </div>

                    <ul class="list-disc list-inside space-y-0.5 text-red-700">
                        @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- BANNER KETENTUAN DIGITAL -->
            <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-4.5 sm:p-5 shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="space-y-1 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-blue-900 text-sm">
                            Ketentuan Dokumen Digital Mahasiswa
                        </span>

                        <span class="text-[10px] font-semibold bg-blue-200/80 text-blue-900 px-2 py-0.5 rounded-full">
                            STANDAR VALIDASI
                        </span>
                    </div>

                    <p class="text-slate-600 leading-relaxed">
                        Format berkas yang diterima adalah <strong>PDF, JPG, atau PNG</strong>
                        dengan ukuran maksimal <strong>2.0 MB per berkas</strong>.
                        Pastikan hasil scan/foto dokumen terlihat tajam, tidak terpotong,
                        stempel/tanda tangan basah terbaca jelas untuk menghindari penolakan verifikasi.
                    </p>
                </div>
            </div>

            <!-- LIST KARTU DOKUMEN -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <h3 class="font-bold text-base text-slate-800">
                        Berkas Persyaratan Verifikasi
                    </h3>

                    <span class="text-xs text-slate-500">
                        {{ $terunggahCount }} dari {{ $totalWajib }} telah diunggah
                    </span>
                </div>

                @foreach ($jenisList as $kode => $label)
                @php
                $doc = $documents[$kode] ?? null;
                $statusStr = strtolower($doc->status_verifikasi ?? '');
                $isPdf = $doc && str_ends_with(strtolower($doc->nama_asli), '.pdf');
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 transition hover:border-slate-300 space-y-4">

                    <!-- Header Baris Dokumen: Judul & Status Badge -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">

                                @if ($kode == 'kk')
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>

                                @elseif ($kode == 'ktm')
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>

                                @elseif ($kode == 'penghasilan')
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>

                                @else
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @endif

                            </div>

                            <div>
                                <h4 class="font-bold text-sm sm:text-base text-slate-800">
                                    {{ $label }}
                                </h4>

                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                                    {{ $kode == 'lainnya' ? 'Dokumen Pendukung Tambahan' : 'Dokumen Wajib Seleksi' }}
                                </span>
                            </div>
                        </div>

                        <!-- Badge Status -->
                        <div>
                            @if ($doc)

                            @if (str_contains($statusStr, 'tidak') || str_contains($statusStr, 'tolak') || str_contains($statusStr, 'revisi'))

                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Berkas Ditolak
                            </span>

                            @elseif (str_contains($statusStr, 'valid') || str_contains($statusStr, 'setuju') || str_contains($statusStr, 'diterima'))

                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Terverifikasi / Valid
                            </span>

                            @else

                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu Verifikasi
                            </span>

                            @endif

                            @else

                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Belum Diunggah
                            </span>

                            @endif
                        </div>
                    </div>

                    <!-- Info Berkas yang sudah diunggah -->
                    @if ($doc)

                    <div class="bg-slate-50/80 rounded-xl p-3.5 border border-slate-200/70 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="p-2 rounded-lg bg-red-100 text-red-600 shrink-0">

                                @if ($isPdf)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif

                            </div>

                            <div class="overflow-hidden">
                                <p class="text-xs sm:text-sm font-semibold text-slate-800 truncate"
                                    title="{{ $doc->nama_asli }}">
                                    {{ $doc->nama_asli }}
                                </p>

                                <p class="text-[11px] text-slate-500">
                                    Status:
                                    <span class="font-semibold text-slate-700 capitalize">
                                        {{ $doc->status_verifikasi }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="shrink-0">
                            <a href="{{ route('dokumen.unduh', $doc) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition">

                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>

                                Lihat / Unduh Dokumen
                            </a>
                        </div>
                    </div>

                    <!-- Catatan Verifikator jika ada -->
                    @if ($doc->catatan)
                    <div class="flex items-start gap-2.5 p-3 rounded-xl bg-amber-50/80 border border-amber-200 text-xs text-amber-900">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>

                        <div>
                            <span class="font-bold">Catatan Verifikator:</span>
                            {{ $doc->catatan }}
                        </div>
                    </div>
                    @endif

                    @else

                    <div class="py-2 text-xs text-slate-500 italic">
                        Dokumen ini belum diunggah. Silakan pilih berkas legalisir Anda di bawah ini:
                    </div>

                    @endif

                    <!-- Form Upload / Ganti Berkas (Logika Backend 100% Asli) -->
                    <form method="POST"
                        action="{{ route('mahasiswa.dokumen.store') }}"
                        enctype="multipart/form-data"
                        class="pt-2 flex flex-col sm:flex-row sm:items-center gap-3">

                        @csrf

                        <input type="hidden" name="jenis" value="{{ $kode }}">

                        <div class="relative flex-1">
                            <input type="file"
                                name="berkas"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                                class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl cursor-pointer bg-slate-50/50 focus:outline-none transition">
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-xl text-xs font-semibold text-white {{ $doc ? 'bg-slate-800 hover:bg-slate-900' : 'bg-blue-600 hover:bg-blue-700' }} shadow-sm transition">

                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>

                            <span>
                                {{ $doc ? 'Ganti Berkas' : 'Unggah Berkas' }}
                            </span>
                        </button>
                    </form>

                </div>
                @endforeach
            </div>

            <!-- KARTU BANTUAN & INFORMASI KEMAHASISWAAN -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>

                    <div class="text-xs">
                        <h5 class="font-bold text-slate-800">
                            Lokasi Layanan BAK
                        </h5>

                        <p class="text-slate-500 mt-0.5">
                            Gedung Direktorat & Administrasi Kemahasiswaan Lt. 1
                        </p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-purple-50 text-purple-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <div class="text-xs">
                        <h5 class="font-bold text-slate-800">
                            Keamanan Dokumen
                        </h5>

                        <p class="text-slate-500 mt-0.5">
                            Seluruh berkas disimpan aman dan dienkripsi
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statCards = document.getElementById('stat-cards');
            if (!statCards) return;

            setInterval(async () => {
                try {
                    const res = await fetch(window.location.href, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok || res.redirected) return;

                    const html = await res.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const latestCards = doc.getElementById('stat-cards');

                    if (latestCards && statCards.innerHTML !== latestCards.innerHTML) {
                        statCards.innerHTML = latestCards.innerHTML;
                    }
                } catch (_) {
                    // Abaikan sementara jika koneksi terputus
                }
            }, 5000);
        });
    </script>
</x-app-layout>