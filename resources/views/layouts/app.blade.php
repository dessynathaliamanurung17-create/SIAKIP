<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIBEKA POLMED') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&family=roboto:400,500,700,900&family=jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        @if (auth()->check() && auth()->user()->isAdmin())
            @php
                $pageLabel = match (true) {
                    request()->routeIs('admin.dashboard')    => 'Dashboard Ringkasan',
                    request()->routeIs('admin.pelamar.show') => 'Detail Pelamar',
                    request()->routeIs('admin.pelamar*')     => 'Data Pelamar',
                    request()->routeIs('admin.verifikasi')   => 'Verifikasi Dokumen',
                    request()->routeIs('admin.audit-log')    => 'Audit Log Sistem',
                    request()->routeIs('admin.sistem')       => 'Kesehatan Sistem',
                    request()->routeIs('profile.*')          => 'Profil Akun',
                    default                                  => 'Panel Admin',
                };
            @endphp

            <!-- ADMIN SHELL: NAVIGATION DRAWER + BLUISH-WHITE CANVAS -->
            <div x-data="{ drawerOpen: false }" class="admin-panel font-admin min-h-screen bg-gradient-to-br from-[#eaf2fb] via-[#f1f6fd] to-[#e5effa]">
                @include('layouts.admin-drawer')

                <div class="lg:pl-72 flex flex-col min-h-screen">
                    <!-- TOP BAR MINIMALIS PUTIH KEBIRUAN -->
                    <div class="sticky top-0 z-30 h-16 bg-white/85 backdrop-blur-md border-b border-blue-100/90 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 shadow-sm shadow-blue-950/5">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Tombol Buka Drawer (Mobile & Tablet) -->
                            <button type="button"
                                    @click="drawerOpen = true"
                                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-blue-700 hover:bg-blue-50 focus:outline-none transition"
                                    aria-label="Buka menu navigasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>

                            <!-- Breadcrumb Bersih -->
                            <div class="flex items-center gap-2 text-xs min-w-0">
                                <span class="text-blue-600/70 font-medium hidden sm:inline">Admin</span>
                                <span class="text-blue-200 hidden sm:inline">/</span>
                                <span class="font-bold text-slate-800 truncate text-[13px]">{{ $pageLabel }}</span>
                            </div>
                        </div>

                        <!-- Sisi Kanan: Indikator Keamanan & Tanggal -->
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Sesi Aman · Terenkripsi
                            </span>
                            <span class="text-xs font-mono font-medium text-slate-500 hidden sm:inline">
                                {{ now()->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Page Heading (Jika view mengirim slot header) -->
                    @isset($header)
                        <header class="bg-white/75 backdrop-blur-sm border-b border-blue-100/80">
                            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main class="flex-1">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        @else
            <!-- MAHASISWA / GUEST SHELL: TOP NAVBAR -->
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif

        @auth
            <!-- POP-UP KONFIRMASI KELUAR (LOGOUT) -->
            <x-modal name="confirm-logout" maxWidth="sm" focusable>
                <div class="p-6 space-y-5 bg-white text-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">
                            Apakah Anda yakin mau keluar?
                        </h3>
                    </div>

                    <div class="flex justify-end gap-2.5 pt-2">
                        <button type="button"
                                x-on:click="$dispatch('close')"
                                class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold text-sm transition">
                            Batal
                        </button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-semibold text-sm transition shadow-sm">
                                Ya, Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </x-modal>
        @endauth
    </body>
</html>
