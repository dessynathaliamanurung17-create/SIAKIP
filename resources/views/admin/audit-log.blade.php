<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Audit Log Sistem</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Rekam jejak aktivitas perubahan data dan kepatuhan sistem beasiswa POLMED.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Log Aktif · Real-Time Tracking
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/70 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. HEADER BANNER & RINGKASAN KEAMANAN -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Rekaman Log</span>
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-900">{{ $logs->total() ?? count($logs) }}</div>
                    <p class="text-xs text-slate-500">Aktivitas tercatat di database</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Integritas Data</span>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-black text-emerald-600">100% Valid</div>
                    <p class="text-xs text-slate-500">Pencatatan mutasi transparan</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Protokol Keamanan</span>
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-900">Enkripsi SHA</div>
                    <p class="text-xs text-slate-500">Kepatuhan standar audit BAK</p>
                </div>
            </div>

            <!-- 2. KARTU UTAMA TABEL AUDIT LOG -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-5">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-bold text-base text-slate-900">Histori Perubahan Data (Audit Trail)</h3>
                        <p class="text-xs text-slate-500">Catatan lengkap setiap aksi tambah, ubah, dan hapus yang dilakukan pengguna</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full w-fit">
                        Halaman Aktif: {{ $logs->currentPage() ?? 1 }}
                    </span>
                </div>

                <!-- TABEL DATA AUDIT -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <th class="py-3 px-3.5">Waktu (Timestamp)</th>
                                <th class="py-3 px-3.5">User ID</th>
                                <th class="py-3 px-3.5">Aksi</th>
                                <th class="py-3 px-3.5">Tabel & Record</th>
                                <th class="py-3 px-3.5 min-w-[220px]">Data Lama (Before)</th>
                                <th class="py-3 px-3.5 min-w-[220px]">Data Baru (After)</th>
                                <th class="py-3 px-3.5">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($logs as $log)
                                @php
                                    $aksi = strtolower($log->aksi ?? '');
                                    // Penentuan badge aksi
                                    if (str_contains($aksi, 'tambah') || str_contains($aksi, 'create') || str_contains($aksi, 'insert')) {
                                        $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    } elseif (str_contains($aksi, 'hapus') || str_contains($aksi, 'delete')) {
                                        $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    } elseif (str_contains($aksi, 'ubah') || str_contains($aksi, 'update')) {
                                        $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                    } else {
                                        $badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                    }
                                @endphp

                                <tr class="hover:bg-slate-50/70 transition align-top">
                                    <!-- Waktu -->
                                    <td class="py-3 px-3.5 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5 text-slate-800 font-mono text-[11px] font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $log->created_at }}</span>
                                        </div>
                                    </td>

                                    <!-- User ID -->
                                    <td class="py-3 px-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            ID: {{ $log->user_id ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3 px-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $badgeClass }}">
                                            {{ $log->aksi }}
                                        </span>
                                    </td>

                                    <!-- Tabel & Record ID -->
                                    <td class="py-3 px-3.5 whitespace-nowrap">
                                        <div class="space-y-0.5">
                                            <span class="font-bold font-mono text-slate-800 block text-xs">{{ $log->tabel }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">Record: #{{ $log->record_id }}</span>
                                        </div>
                                    </td>

                                    <!-- Data Lama (Before) -->
                                    <td class="py-3 px-3.5">
                                        @if ($log->data_lama)
                                            <details class="group cursor-pointer">
                                                <summary class="text-[10px] font-bold text-slate-600 hover:text-slate-900 select-none flex items-center gap-1">
                                                    <span>Data Sebelum Perubahan</span>
                                                    <span class="group-open:rotate-180 transition-transform text-slate-400">▾</span>
                                                </summary>
                                                <pre class="mt-1.5 p-2 rounded-xl bg-slate-900 text-amber-300 font-mono text-[10px] leading-relaxed overflow-x-auto max-h-36 border border-slate-800 shadow-inner">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT) }}</pre>
                                            </details>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">- Kosong / Data Baru -</span>
                                        @endif
                                    </td>

                                    <!-- Data Baru (After) -->
                                    <td class="py-3 px-3.5">
                                        @if ($log->data_baru)
                                            <details class="group cursor-pointer" open>
                                                <summary class="text-[10px] font-bold text-blue-700 hover:text-blue-900 select-none flex items-center gap-1">
                                                    <span>Data Setelah Perubahan</span>
                                                    <span class="group-open:rotate-180 transition-transform text-slate-400">▾</span>
                                                </summary>
                                                <pre class="mt-1.5 p-2 rounded-xl bg-slate-900 text-emerald-400 font-mono text-[10px] leading-relaxed overflow-x-auto max-h-36 border border-slate-800 shadow-inner">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT) }}</pre>
                                            </details>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">- Kosong / Dihapus -</span>
                                        @endif
                                    </td>

                                    <!-- IP Address -->
                                    <td class="py-3 px-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-mono font-semibold bg-slate-50 text-slate-700 border border-slate-200">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="max-w-xs mx-auto space-y-2">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <p class="font-bold text-sm text-slate-700">Belum Ada Aktivitas</p>
                                            <p class="text-xs text-slate-400">Belum terdapat catatan audit log yang terekam di sistem.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINASI -->
                <div class="pt-3 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>