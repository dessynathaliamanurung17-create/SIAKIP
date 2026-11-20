<x-app-layout>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- 1. HEADER BANNER & ACTION CEPAT -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Sisa 12 Hari Menuju Penutupan Tahap 1</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Selamat Datang Admin SIBEKA
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Kelola data pendaftar, validasi dokumen berkas, dan pantau penetapan kuota beasiswa POLMED.
                    </p>
                </div>

                <div class="shrink-0">
                    <a href="{{ Route::has('admin.verifikasi') ? route('admin.verifikasi') : '#' }}" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-600/20">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Verifikasi Cepat</span>
                    </a>
                </div>
            </div>

            <!-- 2. EMPAT KARTU METRIK UTAMA (STATS) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1: Total Pendaftar -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        </span>

                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Pendaftar Masuk</span>
                        <div class="text-3xl font-black text-slate-900 mt-0.5">500</div>
                        <p class="text-[11px] text-slate-500 mt-1">Seluruh 6 Jurusan POLMED</p>
                    </div>
                </div>

                <!-- Card 2: Berkas Terverifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>

                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Berkas Terverifikasi</span>
                        <div class="text-3xl font-black text-slate-900 mt-0.5">450</div>
                        <p class="text-[11px] text-emerald-600 mt-1 flex items-center gap-1 font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Memenuhi Syarat Administrasi
                        </p>
                    </div>
                </div>

                <!-- Card 3: Menunggu Verifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                            Prioritas
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Menunggu Verifikasi</span>
                        <div class="text-3xl font-black text-blue-600 mt-0.5">50</div>
                        <p class="text-[11px] text-slate-500 mt-1">Perlu pengecekan faktual BAK</p>
                    </div>
                </div>

                <!-- Card 4: Kuota SK POLMED -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kuota SK POLMED</span>
                        <div class="text-3xl font-black text-slate-900 mt-0.5">200 <span class="text-sm font-semibold text-slate-500">Kursi</span></div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 72%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. DISTRIBUSI PENDAFTAR PER JURUSAN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <h3 class="font-bold text-base text-slate-900">Distribusi Pendaftar per Jurusan</h3>
                        </div>
                        <p class="text-xs text-slate-500">Jumlah berkas pelamar beasiswa pada masing-masing jurusan vokasi aktif</p>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-semibold">
                        <button class="px-3 py-1 rounded-lg bg-white text-slate-900 shadow-sm">Semua Jalur</button>
                        <button class="px-3 py-1 rounded-lg text-slate-600 hover:text-slate-900">KIP-K</button>
                        <button class="px-3 py-1 rounded-lg text-slate-600 hover:text-slate-900">Prestasi</button>
                    </div>
                </div>

                <!-- Grid 6 Jurusan Progress Bars -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-xs">
                    <!-- Jurusan 1 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                Teknik Informatika & Komputer
                            </span>
                            <span class="font-bold text-slate-900">380 <span class="text-slate-400 font-normal">(26.6%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-700 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>

                    <!-- Jurusan 2 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Teknik Mesin
                            </span>
                            <span class="font-bold text-slate-900">290 <span class="text-slate-400 font-normal">(20.3%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>

                    <!-- Jurusan 3 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                                Teknik Elektro
                            </span>
                            <span class="font-bold text-slate-900">260 <span class="text-slate-400 font-normal">(18.2%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-slate-700 h-2 rounded-full" style="width: 54%"></div>
                        </div>
                    </div>

                    <!-- Jurusan 4 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                Teknik Sipil
                            </span>
                            <span class="font-bold text-slate-900">245 <span class="text-slate-400 font-normal">(17.1%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-sky-600 h-2 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Jurusan 5 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                Administrasi Niaga
                            </span>
                            <span class="font-bold text-slate-900">185 <span class="text-slate-400 font-normal">(12.9%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-slate-500 h-2 rounded-full" style="width: 38%"></div>
                        </div>
                    </div>

                    <!-- Jurusan 6 -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-300"></span>
                                Akuntansi
                            </span>
                            <span class="font-bold text-slate-900">168 <span class="text-slate-400 font-normal">(11.7%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-indigo-400 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <span class="text-slate-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Data terintegrasi langsung dengan Pangkalan Data Pendidikan Tinggi (PDDikti POLMED)
                    </span>
                    <a href="{{ Route::has('admin.pelamar') ? route('admin.pelamar') : '#' }}" class="font-semibold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                        <span>Lihat Rincian Program Studi</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 4. TABEL ANTREAN VERIFIKASI BERKAS TERBARU -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden space-y-4 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <h3 class="font-bold text-base text-slate-900">Antrean Verifikasi Berkas Terbaru</h3>
                        </div>
                        <p class="text-xs text-slate-500">Daftar mahasiswa pendaftar beasiswa yang menunggu peninjauan atau update berkas</p>
                    </div>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200 w-fit">
                        Menampilkan 5 dari 342 Antrean
                    </span>
                </div>

                <!-- Search & Filters Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2">
                    <div class="sm:col-span-6 relative">
                        <input type="text" placeholder="Cari pendaftar Nama / NIM / Berkas..." 
                            class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-1 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <select class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-600 focus:bg-white focus:outline-none">
                            <option>Semua Jurusan</option>
                            <option>Teknik Informatika & Komputer</option>
                            <option>Teknik Mesin</option>
                            <option>Teknik Elektro</option>
                            <option>Teknik Sipil</option>
                            <option>Administrasi Niaga</option>
                            <option>Akuntansi</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <select class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-600 focus:bg-white focus:outline-none">
                            <option>Semua Status</option>
                            <option>Menunggu</option>
                            <option>Valid</option>
                            <option>Perlu Revisi</option>
                        </select>
                    </div>
                </div>

                <!-- Data Table Sesuai Foto Desain -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-y border-slate-100">
                                <th class="py-3 px-3">Mahasiswa</th>
                                <th class="py-3 px-3">Jurusan & Prodi</th>
                                <th class="py-3 px-3">Jalur & IPK</th>
                                <th class="py-3 px-3">Dokumen</th>
                                <th class="py-3 px-3">Status</th>
                                <th class="py-3 px-3 text-right">Aksi Tim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <!-- Row 1: Rian Pratama -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shrink-0">RP</div>
                                        <div>
                                            <p class="font-bold text-slate-900">Rian Pratama S.</p>
                                            <p class="text-[10px] text-slate-400 font-mono">NIM: 2105172048</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">D4 Teknik Informatika</p>
                                    <p class="text-[10px] text-slate-400">Teknik Komputer & Inf.</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-semibold text-[10px]">KIP-Kuliah POLMED</span>
                                    <p class="font-bold text-slate-800 text-[11px] mt-0.5">IPK: 3.82</p>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        5 / 5
                                    </p>
                                    <p class="text-[10px] text-slate-400">SKTM & Foto Rumah</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ Valid
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                        <button class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 2: Siti Nurhaliza -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-xs shrink-0">SN</div>
                                        <div>
                                            <p class="font-bold text-slate-900">Siti Nurhaliza</p>
                                            <p class="text-[10px] text-slate-400 font-mono">NIM: 2205181012</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">D3 Akuntansi</p>
                                    <p class="text-[10px] text-slate-400">Jurusan Akuntansi</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-semibold text-[10px]">Prestasi Unggul</span>
                                    <p class="font-bold text-slate-800 text-[11px] mt-0.5">IPK: 3.91</p>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">5 / 5</p>
                                    <p class="text-[10px] text-slate-400">Sertifikat Juara 1</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        ⏳ Menunggu
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ Route::has('admin.verifikasi') ? route('admin.verifikasi') : '#' }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold text-[11px]">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Periksa
                                    </a>
                                </td>
                            </tr>

                            <!-- Row 3: Ahmad Fauzan -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-rose-600 text-white font-bold flex items-center justify-center text-xs shrink-0">AF</div>
                                        <div>
                                            <p class="font-bold text-slate-900">Ahmad Fauzan</p>
                                            <p class="text-[10px] text-slate-400 font-mono">NIM: 2105143009</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">D4 Teknik Mesin</p>
                                    <p class="text-[10px] text-slate-400">Jurusan Teknik Mesin</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-semibold text-[10px]">KIP-Kuliah POLMED</span>
                                    <p class="font-bold text-slate-800 text-[11px] mt-0.5">IPK: 3.45</p>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-rose-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        4 / 5
                                    </p>
                                    <p class="text-[10px] text-rose-500 font-medium">Slip Gaji Buram</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Perlu Revisi
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-[11px] border border-rose-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        Ingatkan
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 4: Putri Anggraini -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-slate-700 text-white font-bold flex items-center justify-center text-xs shrink-0">PA</div>
                                        <div>
                                            <p class="font-bold text-slate-900">Putri Anggraini</p>
                                            <p class="text-[10px] text-slate-400 font-mono">NIM: 2205162033</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">D4 Administrasi Bisnis</p>
                                    <p class="text-[10px] text-slate-400">Administrasi Niaga</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-purple-50 text-purple-700 font-semibold text-[10px]">Kemitraan Industri</span>
                                    <p class="font-bold text-slate-800 text-[11px] mt-0.5">IPK: 3.75</p>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">5 / 5</p>
                                    <p class="text-[10px] text-slate-400">Portofolio Magang</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        ⏳ Menunggu
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ Route::has('admin.verifikasi') ? route('admin.verifikasi') : '#' }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold text-[11px]">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Periksa
                                    </a>
                                </td>
                            </tr>

                            <!-- Row 5: Budi Santoso -->
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-blue-700 text-white font-bold flex items-center justify-center text-xs shrink-0">BS</div>
                                        <div>
                                            <p class="font-bold text-slate-900">Budi Santoso</p>
                                            <p class="text-[10px] text-slate-400 font-mono">NIM: 2305131055</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800">D3 Teknik Sipil</p>
                                    <p class="text-[10px] text-slate-400">Jurusan Teknik Sipil</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-semibold text-[10px]">KIP-Kuliah POLMED</span>
                                    <p class="font-bold text-slate-800 text-[11px] mt-0.5">IPK: 3.60</p>
                                </td>
                                <td class="py-3 px-3">
                                    <p class="font-bold text-slate-800 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        5 / 5
                                    </p>
                                    <p class="text-[10px] text-slate-400">KIP & Rekening Listrik</p>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ Valid
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                        <button class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <span>Menampilkan baris 1 s/d 5 dari total 342 berkas antrean aktif</span>
                    <div class="inline-flex items-center gap-1">
                        <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600">&lt;</button>
                        <button class="px-2.5 py-1 rounded-lg bg-blue-700 text-white font-bold">1</button>
                        <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600">2</button>
                        <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600">3</button>
                        <span class="px-1 text-slate-400">...</span>
                        <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600">69</button>
                        <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600">&gt;</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>