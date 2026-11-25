<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- SISI KIRI: LOGO TRANSPARAN & BRANDING SIBEKA -->
            <div class="flex items-center gap-6">
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('mahasiswa.dashboard')) : url('/') }}"
                    class="flex items-center gap-3 group focus:outline-none">

                    <!-- Logo SIBEKA (Tanpa Lingkaran Putih) -->
                    <div class="w-16 h-16 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                        <img src="{{ asset('images/logo%20sibeka.png') }}"
                            alt="Logo SIBEKA"
                            class="w-full h-full object-contain">
                    </div>


                </a>
            </div>

            <!-- SISI TENGAH: NAVIGATION LINKS -->
            <div class="hidden md:flex items-center space-x-1.5">
                @if (auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.pelamar') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pelamar*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Data Pelamar
                    </a>
                    <a href="{{ route('admin.verifikasi') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.verifikasi') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Verifikasi Dokumen
                    </a>
                    <a href="{{ route('admin.audit-log') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.audit-log') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Audit Log
                    </a>
                    <a href="{{ route('admin.sistem') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.sistem') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Sistem
                    </a>
                @else
                    <a href="{{ route('mahasiswa.dashboard') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.dashboard') || request()->is('/') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.pendaftaran') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Pendaftaran
                    </a>
                    <a href="{{ route('mahasiswa.dokumen') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.dokumen*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Dokumen
                    </a>
                    <a href="{{ route('mahasiswa.status') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.status') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-blue-700 hover:bg-slate-50' }}">
                        Status Seleksi
                    </a>
                @endif
            </div>

            <!-- SISI KANAN: PROFILE DROPDOWN / LOGIN & REGISTER -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs sm:text-sm font-semibold text-slate-800 transition focus:outline-none cursor-pointer">
                                @php($navFoto = Auth::user()->mahasiswa?->foto_url)
                                <div class="w-7 h-7 rounded-full overflow-hidden bg-blue-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                                    @if ($navFoto)
                                        <img src="{{ $navFoto }}" alt="Foto" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    @endif
                                </div>
                                <span class="max-w-[130px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-slate-100 text-xs">
                                <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="text-xs">
                                {{ __('Profil Akun') }}
                            </x-dropdown-link>

                            <button type="button"
                                @click="$dispatch('open-modal', 'confirm-logout')"
                                class="block w-full px-4 py-2 text-start text-xs leading-5 text-red-600 hover:text-red-700 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out">
                                {{ __('Keluar (Log Out)') }}
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-sm transition inline-block">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-white hover:bg-slate-50 border border-slate-300 text-slate-800 font-semibold text-sm px-5 py-2.5 rounded-xl transition inline-block">
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <!-- TOMBOL HAMBURGER (MOBILE) -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- RESPONSIVE MOBILE NAVIGATION MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t border-slate-200">
        <div class="p-3 space-y-1 text-xs font-semibold">
            @if (auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Dashboard</a>
                <a href="{{ route('admin.pelamar') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.pelamar*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Data Pelamar</a>
                <a href="{{ route('admin.verifikasi') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.verifikasi') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Verifikasi Dokumen</a>
                <a href="{{ route('admin.audit-log') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.audit-log') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Audit Log</a>
                <a href="{{ route('admin.sistem') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.sistem') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Sistem</a>
            @else
                <a href="{{ route('mahasiswa.dashboard') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.dashboard') || request()->is('/') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('mahasiswa.pendaftaran') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Pendaftaran</a>
                <a href="{{ route('mahasiswa.dokumen') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.dokumen*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Dokumen</a>
                <a href="{{ route('mahasiswa.status') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.status') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Status Seleksi</a>
            @endif
        </div>

        <div class="pt-4 pb-3 border-t border-slate-100 px-4">
            @auth
                <div class="flex items-center gap-3">
                    @php($mobFoto = Auth::user()->mahasiswa?->foto_url)
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        @if ($mobFoto)
                            <img src="{{ $mobFoto }}" alt="Foto" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <div class="font-bold text-sm text-slate-900 truncate">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-slate-500 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 text-xs font-semibold">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                        {{ __('Profil Akun') }}
                    </a>

                    <button type="button"
                        @click="open = false; $dispatch('open-modal', 'confirm-logout')"
                        class="block w-full text-left px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50">
                        {{ __('Keluar (Log Out)') }}
                    </button>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-blue-700 text-white font-bold text-xs">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-white border border-slate-300 text-slate-800 font-semibold text-xs">
                            Register
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
