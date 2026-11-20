<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Data Pelamar Beasiswa</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Daftar seluruh berkas pengajuan beasiswa mahasiswa Politeknik Negeri Medan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Total Terdata: {{ $applications->total() ?? count($applications) }} Pelamar
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- CARD UTAMA KELOLA DATA PELAMAR -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden p-6 sm:p-7 space-y-6">
                
                <!-- HEADER & TOOLBAR FILTER STATUS -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <h3 class="font-bold text-base text-slate-900">Daftar Berkas Masuk</h3>
                        </div>
                        <p class="text-xs text-slate-500">Filter data berdasarkan tahapan status seleksi pelamar</p>
                    </div>

                    <!-- FORM FILTER STATUS -->
                    <form method="GET" class="flex flex-wrap items-center gap-2.5">
                        <div class="relative">
                            <select name="status" 
                                class="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition pr-8 cursor-pointer shadow-sm">
                                <option value="">Semua Status Pendaftaran</option>
                                @foreach (['draft', 'diajukan', 'diverifikasi', 'ditolak'] as $s)
                                    <option value="{{ $s }}" @selected(request('status') === $s)>
                                        Status: {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs tracking-wide uppercase transition shadow-sm hover:shadow">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Filter</span>
                        </button>

                        @if (request('status'))
                            <a href="{{ url()->current() }}" 
                                class="inline-flex items-center gap-1 px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 text-xs font-medium transition" title="Reset Filter">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- TABEL DATA PELAMAR DENGAN GAYA SIBEKA POLMED -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200/80">
                                <th class="py-3.5 px-4">Nama Mahasiswa</th>
                                <th class="py-3.5 px-4">NIM</th>
                                <th class="py-3.5 px-4">Program Studi</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4 text-center">Skor</th>
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
                                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-sm">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ $nama }}</p>
                                                <span class="text-[10px] text-slate-400">Pendaftar Beasiswa</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- NIM -->
                                    <td class="py-3.5 px-4 font-mono font-semibold text-slate-800">
                                        {{ $a->mahasiswa_nim }}
                                    </td>

                                    <!-- PROGRAM STUDI -->
                                    <td class="py-3.5 px-4">
                                        <span class="font-semibold text-slate-800 block truncate max-w-[200px]" title="{{ $a->mahasiswa?->program_studi }}">
                                            {{ $a->mahasiswa?->program_studi ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- STATUS PENDAFTARAN (BADGE WARNA) -->
                                    <td class="py-3.5 px-4">
                                        @if ($statusVal === 'diverifikasi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Diverifikasi
                                            </span>
                                        @elseif ($statusVal === 'diajukan')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                Diajukan
                                            </span>
                                        @elseif ($statusVal === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <!-- SKOR -->
                                    <td class="py-3.5 px-4 text-center">
                                        @if ($a->skor)
                                            <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-slate-800 text-xs">
                                                {{ $a->skor }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 font-mono">-</span>
                                        @endif
                                    </td>

                                    <!-- HASIL AKHIR -->
                                    <td class="py-3.5 px-4">
                                        @if ($a->hasil_akhir)
                                            @php $hasilStr = strtolower($a->hasil_akhir); @endphp
                                            <span class="font-bold {{ str_contains($hasilStr, 'lolos') || str_contains($hasilStr, 'terima') ? 'text-emerald-700' : 'text-slate-800' }}">
                                                {{ $a->hasil_akhir }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Belum ditetapkan</span>
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