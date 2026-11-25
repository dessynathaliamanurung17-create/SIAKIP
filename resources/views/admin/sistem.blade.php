<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Kesehatan Sistem</h2>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 w-fit">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Monitoring Aktif
            </span>
        </div>
    </x-slot>

    @php
        $totalCek = count($cek);
        $totalOk = 0;
        foreach ($cek as $item) {
            if (!empty($item['ok'])) $totalOk++;
        }
        $semuaOk = ($totalOk === $totalCek && $totalCek > 0);
    @endphp

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- NOTIFIKASI STATUS DARI CONTROLLER -->
            @if (session('status'))
                <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('status') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                </div>
            @endif

            <!-- 1. BANNER STATUS KESEHATAN SISTEM -->
            <div class="relative overflow-hidden rounded-3xl {{ $semuaOk ? 'bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950' : 'bg-gradient-to-r from-slate-950 via-slate-900 to-rose-950' }} text-white shadow-xl p-6 sm:p-7">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $semuaOk ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-rose-500/20 text-rose-300 border border-rose-400/30' }}">
                            <span class="w-2 h-2 rounded-full {{ $semuaOk ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></span>
                            {{ $semuaOk ? 'Semua layanan normal' : 'Beberapa layanan terkendala' }}
                        </div>
                        <h1 class="text-xl font-bold tracking-tight">
                            Status Server SIBEKA
                        </h1>
                    </div>

                    <!-- Indikator Score -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/15 flex items-center gap-4 shrink-0">
                        <div class="w-11 h-11 rounded-xl {{ $semuaOk ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }} flex items-center justify-center font-black text-lg">
                            {{ $semuaOk ? '✓' : '!' }}
                        </div>
                        <div class="text-xs">
                            <span class="text-slate-300 block font-medium">Layanan Sehat</span>
                            <span class="text-xl font-bold font-mono text-white">
                                {{ $totalOk }} <span class="text-xs font-sans font-normal text-slate-300">/ {{ $totalCek }} Modul</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. DAFTAR PEMERIKSAAN KESEHATAN MODUL (TABEL CHECK STATUS) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-base text-slate-900">Komponen Layanan</h3>
                    <button type="button" onclick="window.location.reload()" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Refresh</span>
                    </button>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach ($cek as $nama => $r)
                        @php
                            $namaClean = strtolower($nama);
                        @endphp
                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/50 p-2 rounded-xl transition">
                            
                            <!-- Nama Layanan & Ikon -->
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $r['ok'] ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center shrink-0">
                                    @if (str_contains($namaClean, 'data') || str_contains($namaClean, 'db'))
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3s3.5-1 3.5-3V7c0-2-1.5-3-3.5-3S4 5 4 7zm0 5c0 2 1.5 3 3.5 3s3.5-1 3.5-3m5-5v10c0 2 1.5 3 3.5 3s3.5-1 3.5-3V7c0-2-1.5-3-3.5-3S13 5 13 7zm0 5c0 2 1.5 3 3.5 3s3.5-1 3.5-3"/></svg>
                                    @elseif (str_contains($namaClean, 'storage') || str_contains($namaClean, 'berkas') || str_contains($namaClean, 'file'))
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900 capitalize">{{ $nama }}</h4>
                                    <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $r['info'] }}</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="sm:text-right shrink-0">
                                @if ($r['ok'])
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        OK · Normal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Bermasalah
                                    </span>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. PANEL PENCADANGAN DATABASE -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-base text-slate-900">Backup Database</h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Backup otomatis setiap 00:00 WIB (terenkripsi).
                        </p>
                    </div>

                    <!-- FORM BACKUP SISTEM -->
                    <form method="POST" action="{{ route('admin.sistem.backup') }}" class="shrink-0">
                        @csrf
                        <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm transition shadow-sm cursor-pointer">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Backup Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>