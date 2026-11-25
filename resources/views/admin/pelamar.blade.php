<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Data Pelamar</h2>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-mono font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    {{ $applications->total() ?? count($applications) }} Pelamar
                </span>
                <a href="{{ route('admin.pelamar.export', request()->query()) }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Export CSV</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- CARD UTAMA KELOLA DATA PELAMAR -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-5 sm:p-6 space-y-5">

                <!-- TOOLBAR PENCARIAN & FILTER -->
                <form method="GET" action="{{ route('admin.pelamar') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-5 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIM, jurusan, atau prodi..."
                            class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div class="sm:col-span-3">
                        <select name="status"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Status</option>
                            @foreach (['draft', 'diajukan', 'diverifikasi', 'ditolak'] as $s)
                                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <select name="hasil_akhir"
                            class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Hasil</option>
                            <option value="diterima" @selected(request('hasil_akhir') === 'diterima')>Diterima</option>
                            <option value="ditolak" @selected(request('hasil_akhir') === 'ditolak')>Ditolak</option>
                            <option value="belum" @selected(request('hasil_akhir') === 'belum')>Belum Ditetapkan</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-2">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition shadow-sm">
                            <span>Filter</span>
                        </button>

                        @if (request()->hasAny(['q', 'status', 'hasil_akhir']))
                            <a href="{{ route('admin.pelamar') }}"
                                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 text-xs font-semibold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- TABEL DATA PELAMAR DENGAN GAYA SIBEKA POLMED -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-600 font-semibold text-[13px] border-b border-slate-200/80">
                                <th class="py-3.5 px-4">Nama Mahasiswa</th>
                                <th class="py-3.5 px-4">NIM</th>
                                <th class="py-3.5 px-4">Program Studi</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4 text-right">Skor</th>
                                <th class="py-3.5 px-4">Hasil Akhir</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($applications as $a)
                                @php
                                    $nama = $a->mahasiswa?->user?->name ?? 'Mahasiswa';
                                    $initial = strtoupper(substr($nama, 0, 2));
                                    $statusVal = strtolower($a->status ?? '');
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- NAMA MAHASISWA & AVATAR -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-semibold flex items-center justify-center text-xs shrink-0">
                                                {{ $initial }}
                                            </div>
                                            <p class="font-semibold text-slate-900 text-sm">{{ $nama }}</p>
                                        </div>
                                    </td>

                                    <!-- NIM (Monospace) -->
                                    <td class="py-3.5 px-4 font-mono font-medium text-slate-800 text-[13px]">
                                        {{ $a->mahasiswa_nim }}
                                    </td>

                                    <!-- PROGRAM STUDI -->
                                    <td class="py-3.5 px-4">
                                        <span class="font-medium text-slate-800 block truncate max-w-[220px]" title="{{ $a->mahasiswa?->program_studi }}">
                                            {{ $a->mahasiswa?->program_studi ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- STATUS PENDAFTARAN (BADGE WARNA) -->
                                    <td class="py-3.5 px-4">
                                        @if ($statusVal === 'diverifikasi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Diverifikasi
                                            </span>
                                        @elseif ($statusVal === 'diajukan')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                Diajukan
                                            </span>
                                        @elseif ($statusVal === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <!-- SKOR (Monospace rata kanan) -->
                                    <td class="py-3.5 px-4 text-right font-mono">
                                        @if ($a->skor !== null)
                                            <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 font-semibold text-slate-900 text-[13px]">
                                                {{ number_format((float) $a->skor, 2) }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    <!-- HASIL AKHIR -->
                                    <td class="py-3.5 px-4">
                                        @if ($a->hasil_akhir)
                                            @php $hasilStr = strtolower($a->hasil_akhir); @endphp
                                            <span class="font-semibold {{ str_contains($hasilStr, 'lolos') || str_contains($hasilStr, 'terima') ? 'text-emerald-700' : 'text-rose-700' }}">
                                                {{ ucfirst($a->hasil_akhir) }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">Belum ditetapkan</span>
                                        @endif
                                    </td>

                                    <!-- TOMBOL AKSI DETAIL -->
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('admin.pelamar.show', $a) }}" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs border border-blue-200 transition shadow-sm">
                                            <span>Detail</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="max-w-xs mx-auto space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-slate-700">Belum Ada Pelamar Ditemukan</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Tidak ada data pendaftaran yang cocok dengan filter yang dipilih.</p>
                                            </div>
                                            @if (request('status'))
                                                <a href="{{ url()->current() }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">
                                                    Bersihkan Filter Status
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="pt-4 border-t border-slate-100">
                    {{ $applications->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>