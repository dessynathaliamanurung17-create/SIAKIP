<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Verifikasi Dokumen</h2>
            <div class="flex items-center gap-2">
                @if ($firstPendingAppId)
                    <a href="{{ route('admin.pelamar.show', $firstPendingAppId) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm transition shadow-sm">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Periksa Antrean Teratas</span>
                    </a>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Semua Terperiksa
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. EMPAT KARTU METRIK STATUS BERKAS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.verifikasi') }}" class="block bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:border-blue-300 transition space-y-1.5">
                    <span class="text-xs font-semibold text-slate-500 block">Total Berkas</span>
                    <div class="text-3xl font-bold font-mono text-slate-900">{{ number_format($totalBerkas) }}</div>
                </a>

                <a href="{{ route('admin.verifikasi', ['status' => 'menunggu']) }}" class="block bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:border-blue-300 transition space-y-1.5">
                    <span class="text-xs font-semibold text-slate-500 block">Menunggu</span>
                    <div class="text-3xl font-bold font-mono text-blue-600">{{ number_format($menungguCount) }}</div>
                </a>

                <a href="{{ route('admin.verifikasi', ['status' => 'valid']) }}" class="block bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:border-emerald-300 transition space-y-1.5">
                    <span class="text-xs font-semibold text-slate-500 block">Valid</span>
                    <div class="text-3xl font-bold font-mono text-emerald-600">{{ number_format($validCount) }}</div>
                </a>

                <a href="{{ route('admin.verifikasi', ['status' => 'tidak_valid']) }}" class="block bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:border-rose-300 transition space-y-1.5">
                    <span class="text-xs font-semibold text-slate-500 block">Perlu Revisi</span>
                    <div class="text-3xl font-bold font-mono text-rose-600">{{ number_format($tidakValidCount) }}</div>
                </a>
            </div>

            <!-- 3. KARTU UTAMA TABEL ANTREAN DOKUMEN -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-5">

                <!-- Toolbar Pencarian & Filter -->
                <form method="GET" action="{{ route('admin.verifikasi') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pb-2">
                    <div class="w-full sm:w-96 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama mahasiswa, NIM, jenis, atau berkas..."
                            class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <select name="status" class="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none pr-8 cursor-pointer shadow-sm">
                            <option value="">Semua Status Verifikasi</option>
                            <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu Verifikasi</option>
                            <option value="valid" @selected(request('status') === 'valid')>Terverifikasi Valid</option>
                            <option value="tidak_valid" @selected(request('status') === 'tidak_valid')>Perlu Revisi</option>
                        </select>

                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition shadow-sm">
                            <span>Filter</span>
                        </button>

                        @if (request()->hasAny(['q', 'status']))
                            <a href="{{ route('admin.verifikasi') }}"
                                class="inline-flex items-center gap-1 px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 text-xs font-semibold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Tabel Data Dokumen -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-600 font-semibold text-[13px] border-b border-slate-200/80">
                                <th class="py-3.5 px-4 w-12 text-right">#</th>
                                <th class="py-3.5 px-4">Mahasiswa</th>
                                <th class="py-3.5 px-4">Program Studi</th>
                                <th class="py-3.5 px-4">Jenis Dokumen</th>
                                <th class="py-3.5 px-4">Nama Berkas</th>
                                <th class="py-3.5 px-4">Status Verifikasi</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($documents as $d)
                                @php
                                    $mhs         = $d->application?->mahasiswa;
                                    $namaMhs     = $mhs?->user?->name ?? 'Mahasiswa';
                                    $nimMhs      = $d->application?->mahasiswa_nim ?? ($mhs?->nim ?? '-');
                                    $prodiMhs    = $mhs?->program_studi ?? '-';
                                    $statusVerif = strtolower($d->status_verifikasi ?? 'menunggu');
                                    $isPdf       = str_ends_with(strtolower($d->nama_asli ?? ''), '.pdf');
                                @endphp

                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- Nomor Urut -->
                                    <td class="py-3.5 px-4 text-right font-mono font-medium text-slate-400 text-[13px]">
                                        {{ ($documents->firstItem() ?? 1) + $loop->index }}
                                    </td>

                                    <!-- Identitas Mahasiswa -->
                                    <td class="py-3.5 px-4">
                                        <p class="font-semibold text-slate-900 text-sm">{{ $namaMhs }}</p>
                                        <p class="text-[13px] text-slate-500 font-mono mt-0.5">{{ $nimMhs }}</p>
                                    </td>

                                    <!-- Program Studi -->
                                    <td class="py-3.5 px-4 font-medium text-slate-800">
                                        {{ $prodiMhs }}
                                    </td>

                                    <!-- Jenis Dokumen -->
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-semibold bg-blue-50 text-blue-700 border border-blue-200 uppercase">
                                            {{ strtoupper($d->jenis) }}
                                        </span>
                                    </td>

                                    <!-- Nama Asli Berkas -->
                                    <td class="py-3.5 px-4 max-w-[240px]">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <div class="p-1.5 rounded-lg {{ $isPdf ? 'bg-rose-50 text-rose-600' : 'bg-blue-50 text-blue-600' }} shrink-0">
                                                @if ($isPdf)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <span class="truncate font-medium text-slate-800 text-[13px]" title="{{ $d->nama_asli }}">
                                                {{ $d->nama_asli }}
                                            </span>
                                        </div>
                                        @if ($d->catatan)
                                            <p class="text-xs text-slate-400 truncate mt-0.5" title="{{ $d->catatan }}">
                                                Catatan: {{ $d->catatan }}
                                            </p>
                                        @endif
                                    </td>

                                    <!-- Status Verifikasi -->
                                    <td class="py-3.5 px-4">
                                        @if ($statusVerif === 'valid')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ✓ Terverifikasi Valid
                                            </span>
                                        @elseif ($statusVerif === 'tidak_valid')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                ✕ Perlu Revisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                ⏳ Menunggu Verifikasi
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Tombol Aksi -->
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <a href="{{ route('dokumen.unduh', $d) }}"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition" title="Unduh Berkas">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                            <a href="{{ route('admin.pelamar.show', $d->application_id) }}"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-xs transition shadow-sm hover:shadow">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Periksa</span>
                                            </a>
                                        </div>
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
                                                <p class="font-bold text-sm text-slate-800">Tidak Ada Dokumen Ditemukan</p>
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    @if (request()->hasAny(['q', 'status']))
                                                        Tidak ada berkas yang cocok dengan pencarian atau filter yang dipilih.
                                                    @else
                                                        Belum ada dokumen mahasiswa yang diunggah saat ini.
                                                    @endif
                                                </p>
                                            </div>
                                            @if (request()->hasAny(['q', 'status']))
                                                <a href="{{ route('admin.verifikasi') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">
                                                    Reset Pencarian & Filter
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINASI -->
                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <span>
                        Menampilkan {{ $documents->firstItem() ?? 0 }} s/d {{ $documents->lastItem() ?? 0 }} dari {{ number_format($documents->total()) }} berkas
                    </span>
                    <div>
                        {{ $documents->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
