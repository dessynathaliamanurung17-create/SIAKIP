@php($terkunci = $application && $application->status !== 'draft')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Formulir Pendaftaran Beasiswa</h2>
                <p class="text-sm text-slate-500">Lengkapi berkas dan data akademik untuk pengajuan beasiswa mahasiswa.</p>
            </div>
            <div class="flex items-center gap-2">
                @if ($terkunci)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Status: Terkunci (Diajukan)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        Status: Draft Terbuka
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HERO HEADER BANNER & STEPPER -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white shadow-xl p-6 sm:p-8">
                <!-- Background Glow Decor -->
                <div class="absolute -right-10 -top-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        PERIODE PENDAFTARAN TERBUKA: JALUR PRESTASI & BANTUAN
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Formulir Pendaftaran Beasiswa</h1>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                            Lengkapi data diri, riwayat akademik, verifikasi ekonomi keluarga, serta pastikan berkas pendukung telah diunggah dengan cermat dan transparan.
                        </p>
                    </div>

                    <!-- STEPPER NAVIGATION INDICATOR -->
                    <div class="pt-6 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-400 flex items-center justify-center font-bold text-sm shrink-0">
                                ✓
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Tahap 01</p>
                                <p class="text-xs font-semibold text-slate-200">Identitas Diri</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-lg shadow-blue-500/40 shrink-0">
                                02
                            </div>
                            <div>
                                <p class="text-[10px] text-blue-300 uppercase tracking-wider font-semibold">Tahap 02</p>
                                <p class="text-xs font-semibold text-white">Data Akademik</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 opacity-75">
                            <div class="w-9 h-9 rounded-xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0">
                                03
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Tahap 03</p>
                                <p class="text-xs font-semibold text-slate-300">Kondisi Ekonomi</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 opacity-75">
                            <div class="w-9 h-9 rounded-xl bg-white/10 text-slate-300 border border-white/10 flex items-center justify-center font-bold text-sm shrink-0">
                                04
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Tahap 04</p>
                                <p class="text-xs font-semibold text-slate-300">Finalisasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NOTIFIKASI STATUS & ALERTS -->
            @if (session('status'))
                <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('status') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="space-y-1 text-sm">
                        <div class="font-semibold">Terdapat beberapa data yang perlu diperiksa:</div>
                        <ul class="list-disc list-inside space-y-0.5 text-red-700">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($terkunci)
                <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div>
                        <div class="font-semibold text-sm">Pendaftaran Telah Diajukan</div>
                        <p class="text-xs text-amber-700 mt-0.5">Formulir pendaftaran sudah dikunci dan sedang dalam tahap seleksi. Data tidak dapat disunting kembali.</p>
                    </div>
                </div>
            @endif

            <!-- NOTICE BANNER: KETENTUAN BEASISWA -->
            <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 bg-amber-100 text-amber-700 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <span class="font-bold text-xs uppercase tracking-wide text-amber-900">Ketentuan & Regulasi Penting</span>
                    <span class="text-[10px] bg-amber-200 text-amber-900 font-semibold px-2 py-0.5 rounded-full">WAJIB DIBACA</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1 text-xs text-slate-700">
                    <div class="p-3 bg-white/80 rounded-xl border border-amber-100 space-y-1">
                        <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">ATURAN 01</span>
                        <p class="font-semibold text-slate-800">Standar Capaian IPK</p>
                        <p class="text-slate-500 text-[11px]">Pastikan nilai IPK dan semester sesuai data KHS resmi dari SIAKAD kampus.</p>
                    </div>
                    <div class="p-3 bg-white/80 rounded-xl border border-amber-100 space-y-1">
                        <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">ATURAN 02</span>
                        <p class="font-semibold text-slate-800">Larangan Beasiswa Ganda</p>
                        <p class="text-slate-500 text-[11px]">Pendaftar dilarang menerima beasiswa ganda dari APBN/APBD/Swasta pada periode yang sama.</p>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: IDENTITAS DIRI (READ-ONLY) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-slate-900">1. Verifikasi Identitas Diri</h3>
                            <p class="text-xs text-slate-500">Data sinkronisasi otomatis dari profil akun mahasiswa</p>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-lg">Terverifikasi</span>
                </div>

                <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nama Mahasiswa</span>
                        <span class="text-sm font-bold text-slate-800 block truncate">{{ auth()->user()->name }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nomor Induk Mahasiswa (NIM)</span>
                        <span class="text-sm font-bold text-slate-800 font-mono block">{{ $mhs->nim }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Jurusan</span>
                        <span class="text-sm font-bold text-slate-800 block truncate">{{ $mhs->jurusan }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Program Studi</span>
                        <span class="text-sm font-bold text-slate-800 block truncate">{{ $mhs->program_studi }}</span>
                    </div>
                </div>
            </div>

            <!-- FORM PENDAFTARAN -->
            <form method="POST" action="{{ route('mahasiswa.pendaftaran.store') }}" class="space-y-6">
                @csrf
                <fieldset @disabled($terkunci) class="space-y-6 disabled:opacity-85">

                    <!-- SECTION 2: DATA AKADEMIK -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-base text-slate-900">2. Data Akademik</h3>
                                    <p class="text-xs text-slate-500">Pastikan nilai dan capaian akademik diisi sesuai kondisi terkini</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Indeks Prestasi Kumulatif (IPK) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <input type="number" step="0.01" min="0" max="4" name="ipk" value="{{ old('ipk', $application->ipk ?? '') }}" 
                                            class="block w-full text-base font-semibold border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                            placeholder="Contoh: 3.75" required>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1">Skala rentang nilai 0.00 sampai 4.00</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Semester Berjalan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" min="1" max="14" name="semester" value="{{ old('semester', $application->semester ?? '') }}" 
                                        class="block w-full text-base font-semibold border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                        placeholder="Contoh: 4" required>
                                    <p class="text-[11px] text-slate-500 mt-1">Masukkan semester aktif saat ini (angka)</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Riwayat Prestasi Akademik / Non-Akademik
                                </label>
                                <textarea name="riwayat_prestasi" rows="3" 
                                    class="block w-full text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                    placeholder="Tuliskan juara lomba, publikasi, kejuaraan, atau organisasi yang pernah diikuti (pisahkan dengan koma atau baris baru)...">{{ old('riwayat_prestasi', $application->riwayat_prestasi ?? '') }}</textarea>
                                <p class="text-[11px] text-slate-500 mt-1">Opsional tapi menjadi poin penunjang saat seleksi</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Riwayat Penerimaan Beasiswa Sebelumnya
                                </label>
                                <textarea name="riwayat_beasiswa" rows="3" 
                                    class="block w-full text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                    placeholder="Tuliskan nama beasiswa dan tahun perolehan jika pernah menerima beasiswa sebelumnya, atau tulis 'Belum Pernah'...">{{ old('riwayat_beasiswa', $application->riwayat_beasiswa ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: KONDISI EKONOMI -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2 bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-base text-slate-900">3. Kondisi Ekonomi Keluarga</h3>
                                    <p class="text-xs text-slate-500">Digunakan untuk kualifikasi bantuan finansial & beasiswa</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Disimpan Terenkripsi
                            </span>
                        </div>

                        <div class="p-5 sm:p-6 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Penghasilan Ortu / Bulan (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-semibold text-sm">
                                            Rp
                                        </div>
                                        <input type="number" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', $application->penghasilan_ortu ?? '') }}" 
                                            class="block w-full pl-10 text-sm font-semibold border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                            placeholder="Contoh: 2500000" required>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1">Gabungan ayah & ibu (tanpa titik/koma)</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Pekerjaan Orang Tua <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu', $application->pekerjaan_ortu ?? '') }}" 
                                        class="block w-full text-sm font-semibold border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                        placeholder="Contoh: Petani / Wiraswasta" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Jumlah Tanggungan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" min="0" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $application->jumlah_tanggungan ?? '') }}" 
                                        class="block w-full text-sm font-semibold border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                        placeholder="Contoh: 3" required>
                                    <p class="text-[11px] text-slate-500 mt-1">Jumlah anak/anggota keluarga yang ditanggung</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Deskripsi Kondisi Ekonomi Keluarga <span class="text-red-500">*</span>
                                </label>
                                <textarea name="kondisi_ekonomi" rows="3" 
                                    class="block w-full text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white placeholder-slate-400 transition" 
                                    placeholder="Jelaskan secara ringkas kondisi tempat tinggal, kepemilikan rumah, kondisi finansial keluarga, serta alasan membutuhkan beasiswa..." required>{{ old('kondisi_ekonomi', $application->kondisi_ekonomi ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- NOTICE MENU DOKUMEN & SUBMIT SECTION -->
                    @unless ($terkunci)
                        <div class="bg-blue-50/70 border border-blue-200 rounded-2xl p-5 shadow-sm space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-100 text-blue-700 rounded-xl shrink-0 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-bold text-sm text-blue-900">Perhatian Berkas Persyaratan Digital</h4>
                                    <p class="text-xs text-blue-800 leading-relaxed">
                                        Sebelum menekan tombol <strong>Ajukan</strong>, pastikan Anda telah mengunggah dokumen penting (Kartu Keluarga, KTM / KTP, Slip Gaji / Surat Keterangan Penghasilan, dan Sertifikat Prestasi jika ada) melalui menu <strong>Dokumen</strong>.
                                    </p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-blue-200/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <p class="text-[11px] text-slate-500">
                                    Data yang disimpan sebagai <em>Draft</em> masih dapat disunting sewaktu-waktu.
                                </p>

                                <div class="flex items-center gap-3 w-full sm:w-auto">
                                    <button type="submit" name="aksi" value="draft" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs tracking-wider uppercase transition shadow-sm hover:shadow">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                        Simpan Draft
                                    </button>

                                    <button type="submit" name="aksi" value="ajukan" 
                                        onclick="return confirm('Setelah diajukan, data tidak bisa diubah lagi. Pastikan semua data dan berkas sudah benar. Lanjutkan?')" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-500/20">
                                        <span>Ajukan Pendaftaran</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endunless

                </fieldset>
            </form>

        </div>
    </div>
</x-app-layout>