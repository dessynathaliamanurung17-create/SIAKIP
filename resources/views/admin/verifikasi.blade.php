<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Verifikasi Dokumen Mahasiswa</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Validasi keabsahan dokumen persyaratan beasiswa yang diajukan oleh mahasiswa POLMED.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Antrean Masuk: {{ $documents->total() ?? count($documents) }} Berkas
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. HEADER TITLE & QUICK ACTION BUTTON -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Verifikasi Pendaftaran Mahasiswa
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Tinjau keaslian dokumen legalisir, KK, KTM, dan slip gaji pendukung beasiswa.
                    </p>
                </div>

                <div class="shrink-0">
                    <button type="button" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-xs tracking-wider uppercase transition shadow-md shadow-blue-600/20">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Verifikasi Cepat Berkas (Batch)</span>
                    </button>
                </div>
            </div>

            <!-- 2. EMPAT KARTU METRIK STATUS BERKAS (PERSIS FOTO DESAIN) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Berkas -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total Berkas</span>
                    <div class="text-3xl font-black text-slate-900">
                        {{ $documents->total() ?? count($documents) }}
                    </div>
                    <p class="text-xs text-slate-500">Semua pendaftar beasiswa</p>
                </div>

                <!-- Menunggu Verifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Menunggu Verifikasi</span>
                    <div class="text-3xl font-black text-blue-600">
                        {{ $documents->total() ?? count($documents) }}
                    </div>
                    <p class="text-xs text-slate-500">Perlu ditinjau verifikator</p>
                </div>

                <!-- Terverifikasi Valid -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Terverifikasi Valid</span>
                    <div class="text-3xl font-black text-emerald-600">
                        984
                    </div>
                    <p class="text-xs text-slate-500">Lolos syarat administrasi</p>
                </div>

                <!-- Perlu Revisi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Perlu Revisi</span>
                    <div class="text-3xl font-black text-rose-600">
                        102
                    </div>
                    <p class="text-xs text-slate-500">Menunggu berkas perbaikan</p>
                </div>
            </div>

            <!-- 3. KARTU UTAMA TABEL ANTREAN DOKUMEN -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-5">
                
                <!-- Toolbar Pencarian & Filter -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pb-2">
                    <div class="w-full sm:w-80 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" placeholder="Cari nama mahasiswa, NIM, atau berkas..." 
                            class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div class="w-full sm:w-auto">
                        <select class="w-full sm:w-auto text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:bg-white focus:outline-none pr-8 cursor-pointer shadow-sm">
                            <option>Semua Status Verifikasi</option>
                            <option>Menunggu Verifikasi</option>
                            <option>Terverifikasi Valid</option>
                            <option>Perlu Revisi</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel Data Dokumen Sesuai Foto Desain -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                                <th class="py-3.5 px-4 w-12 text-center">#</th>
                                <th class="py-3.5 px-4">Mahasiswa</th>
                                <th class="py-3.5 px-4">Program Studi</th>
                                <th class="py-3.5 px-4">Jenis Dokumen</th>
                                <th class="py-3.5 px-4">Nama Berkas</th>
                                <th class="py-3.5 px-4">Status Verifikasi</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($documents as $index => $d)
                                @php
                                    $mhs = $d->application?->mahasiswa;
                                    $namaMhs = $mhs?->user?->name ?? 'Mahasiswa POLMED';
                                    $nimMhs = $d->application?->mahasiswa_nim ?? ($mhs?->nim ?? '-');
                                    $prodiMhs = $mhs?->program_studi ?? '-';
                                    $statusVerif = strtolower($d->status_verifikasi ?? 'menunggu');
                                    $isPdf = str_ends_with(strtolower($d->nama_asli), '.pdf');
                                @endphp

                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- Nomor Urut -->
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- Identitas Mahasiswa -->
                                    <td class="py-3.5 px-4">
                                        <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ $namaMhs }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">NIM: {{ $nimMhs }}</p>
                                    </td>

                                    <!-- Program Studi -->
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">
                                        {{ $prodiMhs }}
                                    </td>

                                    <!-- Jenis Dokumen -->
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 capitalize">
                                            {{ $d->jenis }}
                                        </span>
                                    </td>

                                    <!-- Nama Asli Berkas -->
                                    <td class="py-3.5 px-4 max-w-[200px]">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <div class="p-1.5 rounded-lg {{ $isPdf ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }} shrink-0">
                                                @if ($isPdf)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <span class="truncate font-medium text-slate-800" title="{{ $d->nama_asli }}">
                                                {{ $d->nama_asli }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Status Verifikasi -->
                                    <td class="py-3.5 px-4">
                                        @if (str_contains($statusVerif, 'valid') || str_contains($statusVerif, 'setuju'))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ✓ Terverifikasi Valid
                                            </span>
                                        @elseif (str_contains($statusVerif, 'revisi') || str_contains($statusVerif, 'tolak'))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                Perlu Revisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                Menunggu Verifikasi
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Tombol Aksi Periksa -->
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('admin.pelamar.show', $d->application_id) }}" 
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-xs transition shadow-sm hover:shadow">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Periksa</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="max-w-xs mx-auto space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-slate-800">Antrean Berkas Bersih</p>
                                                <p class="text-xs text-slate-500 mt-0.5">Tidak ada dokumen yang menunggu verifikasi saat ini.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINASI -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    {{ $documents->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>