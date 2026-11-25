@php
    $pendingPelamar  = \App\Models\Application::where('status', 'diajukan')->count();
    $pendingDokumen  = \App\Models\Document::where('status_verifikasi', 'menunggu')->count();
    $adminName       = Auth::user()->name ?? 'Admin';
    $adminEmail      = Auth::user()->email ?? '';
    $nameParts       = preg_split('/\s+/', trim($adminName));
    $adminInitials   = strtoupper(substr($nameParts[0] ?? 'A', 0, 1) . substr($nameParts[1] ?? ($nameParts[0] ?? ''), 0, 1));
@endphp

<!-- BACKDROP MOBILE / TABLET -->
<div x-cloak
     x-show="drawerOpen"
     x-transition:enter="transition-opacity ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="drawerOpen = false"
     class="fixed inset-0 z-40 bg-[#07122f]/50 backdrop-blur-sm lg:hidden">
</div>

<!-- NAVIGATION DRAWER (SIDEBAR KIRI ADMIN) -->
<aside :class="drawerOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-[#081533] via-[#0c1f4a] to-[#0a193b] text-blue-50 border-r border-blue-900/60 flex flex-col transition-transform duration-200 ease-out shadow-2xl lg:shadow-lg">

    <!-- 1. BRAND HEADER DRAWER -->
    <div class="h-16 px-5 flex items-center justify-between border-b border-white/10 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group focus:outline-none">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center p-1 shadow-md shadow-blue-950/40 shrink-0 group-hover:scale-105 transition">
                <img src="{{ asset('images/logo%20sibeka.png') }}"
                     alt="Logo SIBEKA"
                     class="w-full h-full object-contain">
            </div>
            <div class="min-w-0">
                <div class="font-extrabold text-sm text-white tracking-tight leading-tight">
                    SIBEKA
                </div>
                <p class="text-[11px] font-medium text-sky-300/80 leading-tight mt-0.5">
                    Admin
                </p>
            </div>
        </a>

        <!-- Tombol tutup drawer di mobile -->
        <button type="button" @click="drawerOpen = false"
                class="lg:hidden p-1.5 rounded-lg text-blue-200/70 hover:text-white hover:bg-white/10 transition"
                aria-label="Tutup menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- 2. DAFTAR MENU TERKELOMPOK -->
    <nav class="flex-1 overflow-y-auto px-3.5 py-5 space-y-6">

        <!-- GRUP 1: RINGKASAN -->
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold text-sky-300/60 mb-2">
                Ringkasan
            </p>
            <a href="{{ route('admin.dashboard') }}"
               @click="drawerOpen = false"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-950/40' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-sky-300/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </span>
            </a>
        </div>

        <!-- GRUP 2: LAPORAN & DATA MASUK -->
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold text-sky-300/60 mb-2">
                Laporan & Data Masuk
            </p>

            <a href="{{ route('admin.pelamar') }}"
               @click="drawerOpen = false"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-medium transition {{ request()->routeIs('admin.pelamar*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-950/40' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.pelamar*') ? 'text-white' : 'text-sky-300/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Data Pelamar</span>
                </span>
                @if ($pendingPelamar > 0)
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-mono font-semibold tabular-nums {{ request()->routeIs('admin.pelamar*') ? 'bg-white/20 text-white' : 'bg-sky-500/20 text-sky-200 border border-sky-400/20' }}">
                        {{ $pendingPelamar }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.verifikasi') }}"
               @click="drawerOpen = false"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-medium transition {{ request()->routeIs('admin.verifikasi') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-950/40' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.verifikasi') ? 'text-white' : 'text-sky-300/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Verifikasi Dokumen</span>
                </span>
                @if ($pendingDokumen > 0)
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-mono font-semibold tabular-nums {{ request()->routeIs('admin.verifikasi') ? 'bg-white/20 text-white' : 'bg-amber-400/20 text-amber-200 border border-amber-300/20' }}">
                        {{ $pendingDokumen }}
                    </span>
                @endif
            </a>
        </div>

        <!-- GRUP 3: KEAMANAN & DATA TERJAGA -->
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold text-sky-300/60 mb-2">
                Keamanan & Data
            </p>

            <a href="{{ route('admin.audit-log') }}"
               @click="drawerOpen = false"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-medium transition {{ request()->routeIs('admin.audit-log') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-950/40' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.audit-log') ? 'text-white' : 'text-sky-300/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Audit Log</span>
                </span>
            </a>

            <a href="{{ route('admin.sistem') }}"
               @click="drawerOpen = false"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-medium transition {{ request()->routeIs('admin.sistem') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-950/40' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.sistem') ? 'text-white' : 'text-sky-300/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"/>
                    </svg>
                    <span>Kesehatan Sistem</span>
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50" title="Monitoring aktif"></span>
            </a>
        </div>

    </nav>

    <!-- 3. FOOTER PROFIL ADMIN & LOGOUT -->
    <div class="p-3.5 border-t border-white/10 bg-[#061028]/60 shrink-0 space-y-2.5">
        <div class="flex items-center gap-3 px-2 py-1">
            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-md shadow-blue-950/40">
                {{ $adminInitials }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-white truncate">{{ $adminName }}</p>
                <p class="text-[11px] text-blue-200/65 truncate">{{ $adminEmail }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-blue-100 text-xs font-medium transition">
                <svg class="w-3.5 h-3.5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Profil</span>
            </a>

            <button type="button"
                    @click="drawerOpen = false; $dispatch('open-modal', 'confirm-logout')"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 border border-rose-400/25 text-rose-200 text-xs font-medium transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Keluar</span>
            </button>
        </div>
    </div>

</aside>
