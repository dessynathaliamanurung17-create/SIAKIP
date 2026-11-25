<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Audit Log</h2>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Append-Only · <span class="font-mono">{{ number_format($totalLogs) }}</span>
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. RINGKASAN STATISTIK AUDIT LOG -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-1">
                    <span class="text-xs font-semibold text-slate-500 block">Total Log</span>
                    <div class="text-2xl font-bold font-mono text-slate-900">{{ number_format($totalLogs) }}</div>
                    <p class="text-xs text-slate-400"><span class="font-mono">{{ number_format($penggunaAktif) }}</span> akun</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-1">
                    <span class="text-xs font-semibold text-slate-500 block">Hari Ini</span>
                    <div class="text-2xl font-bold font-mono text-emerald-600">{{ number_format($logsHariIni) }}</div>
                    <p class="text-xs text-slate-400 font-mono">{{ now()->format('d M Y') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-1">
                    <span class="text-xs font-semibold text-slate-500 block">Aktivitas Terakhir</span>
                    <div class="text-lg font-bold text-slate-900 truncate">
                        {{ $aktivitasTerakhir ? \Carbon\Carbon::parse($aktivitasTerakhir)->diffForHumans() : 'Belum ada' }}
                    </div>
                    <p class="text-xs text-slate-400"><span class="font-mono">{{ $totalTabel }}</span> tabel</p>
                </div>
            </div>

            <!-- 2. KARTU UTAMA TABEL AUDIT LOG -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-5">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="font-bold text-base text-slate-900">Riwayat Aktivitas</h3>
                    <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full w-fit">
                        {{ $logs->count() }} / {{ number_format($logs->total()) }}
                    </span>
                </div>

                <!-- TOOLBAR PENCARIAN & FILTER -->
                <form method="GET" action="{{ route('admin.audit-log') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-5 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama user, aksi, tabel, record ID, atau IP..."
                            class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    <div class="sm:col-span-3">
                        <select name="aksi" class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Aksi</option>
                            @foreach ($daftarAksi as $a)
                                <option value="{{ $a }}" @selected(request('aksi') === $a)>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <select name="tabel" class="w-full text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Tabel</option>
                            @foreach ($daftarTabel as $t)
                                <option value="{{ $t }}" @selected(request('tabel') === $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-2">
                        <button type="submit"
                            class="flex-1 px-3 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition shadow-sm">
                            Filter
                        </button>
                        @if (request()->hasAny(['q', 'aksi', 'tabel']))
                            <a href="{{ route('admin.audit-log') }}"
                                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 text-xs font-semibold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- TABEL DATA AUDIT -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
                    <table class="w-full text-left text-[13px] border-collapse">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-600 font-semibold text-[13px] border-b border-slate-200">
                                <th class="py-3.5 px-3.5">Waktu</th>
                                <th class="py-3.5 px-3.5">Pengguna</th>
                                <th class="py-3.5 px-3.5">Aksi</th>
                                <th class="py-3.5 px-3.5">Tabel & Record</th>
                                <th class="py-3.5 px-3.5 min-w-[220px]">Data Lama</th>
                                <th class="py-3.5 px-3.5 min-w-[220px]">Data Baru</th>
                                <th class="py-3.5 px-3.5">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($logs as $log)
                                @php
                                    $aksi = strtolower($log->aksi ?? '');
                                    if (str_contains($aksi, 'tambah') || str_contains($aksi, 'create') || str_contains($aksi, 'insert') || str_contains($aksi, 'enroll')) {
                                        $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    } elseif (str_contains($aksi, 'hapus') || str_contains($aksi, 'delete') || str_contains($aksi, 'gagal')) {
                                        $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                                    } elseif (str_contains($aksi, 'ubah') || str_contains($aksi, 'update') || str_contains($aksi, 'verif')) {
                                        $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                    } elseif (str_contains($aksi, 'lihat') || str_contains($aksi, 'login')) {
                                        $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                    } else {
                                        $badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                    }
                                @endphp

                                <tr class="hover:bg-slate-50/70 transition align-top">
                                    <!-- Waktu -->
                                    <td class="py-3.5 px-3.5 whitespace-nowrap">
                                        <div class="flex items-center gap-1.5 text-slate-800 font-mono text-[13px]">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $log->created_at }}</span>
                                        </div>
                                    </td>

                                    <!-- Pengguna -->
                                    <td class="py-3.5 px-3.5 whitespace-nowrap">
                                        @if ($log->user)
                                            <p class="font-semibold text-slate-900 text-sm">{{ $log->user->name }}</p>
                                            <p class="text-xs text-slate-500">
                                                ID <span class="font-mono">{{ $log->user_id }}</span> · {{ ucfirst($log->user->role ?? 'user') }}
                                            </p>
                                        @elseif ($log->user_id)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-mono font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                ID: {{ $log->user_id }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">Sistem / Tamu</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3.5 px-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                            {{ $log->aksi }}
                                        </span>
                                    </td>

                                    <!-- Tabel & Record ID -->
                                    <td class="py-3.5 px-3.5 whitespace-nowrap">
                                        <div class="space-y-0.5">
                                            <span class="font-medium font-mono text-slate-800 block text-[13px]">{{ $log->tabel ?: '-' }}</span>
                                            @if ($log->record_id)
                                                <span class="text-xs text-slate-500 font-mono">#{{ $log->record_id }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Data Lama (Before) -->
                                    <td class="py-3.5 px-3.5">
                                        @if ($log->data_lama)
                                            <details class="group cursor-pointer">
                                                <summary class="text-xs font-semibold text-slate-600 hover:text-slate-900 select-none flex items-center gap-1">
                                                    <span>Lihat data sebelum</span>
                                                    <span class="group-open:rotate-180 transition-transform text-slate-400">▾</span>
                                                </summary>
                                                <pre class="mt-1.5 p-2.5 rounded-xl bg-slate-900 text-amber-300 font-mono text-xs leading-relaxed overflow-x-auto max-h-40 border border-slate-800 shadow-inner">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </details>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    <!-- Data Baru (After) -->
                                    <td class="py-3.5 px-3.5">
                                        @if ($log->data_baru)
                                            <details class="group cursor-pointer" open>
                                                <summary class="text-xs font-semibold text-blue-700 hover:text-blue-900 select-none flex items-center gap-1">
                                                    <span>Data sesudah</span>
                                                    <span class="group-open:rotate-180 transition-transform text-slate-400">▾</span>
                                                </summary>
                                                <pre class="mt-1.5 p-2.5 rounded-xl bg-slate-900 text-emerald-400 font-mono text-xs leading-relaxed overflow-x-auto max-h-40 border border-slate-800 shadow-inner">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </details>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    <!-- IP Address -->
                                    <td class="py-3.5 px-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-mono font-medium bg-slate-50 text-slate-700 border border-slate-200">
                                            {{ $log->ip_address ?: '-' }}
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
                                            <p class="text-xs text-slate-400">
                                                @if (request()->hasAny(['q', 'aksi', 'tabel']))
                                                    Tidak ada catatan audit log yang cocok dengan filter yang dipilih.
                                                @else
                                                    Belum terdapat catatan audit log yang terekam di sistem.
                                                @endif
                                            </p>
                                            @if (request()->hasAny(['q', 'aksi', 'tabel']))
                                                <a href="{{ route('admin.audit-log') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">
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
                        Menampilkan {{ $logs->firstItem() ?? 0 }} s/d {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total()) }} log
                    </span>
                    <div>
                        {{ $logs->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
