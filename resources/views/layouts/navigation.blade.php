<nav x-data="{ open: false }" class="bg-[#07122f] border-b border-slate-800/80 sticky top-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- SISI KIRI: LOGO BULAT PUTIH & BRANDING SIBEKA POLMED (SESUAI FOTO) -->
            <div class="flex items-center gap-6">
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('mahasiswa.dashboard')) : url('/') }}" 
                   class="flex items-center gap-3.5 group focus:outline-none">
                    
                    <!-- Lambang Logo POLMED Bulat Putih -->
                    <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center p-1 shadow-md shrink-0 overflow-hidden group-hover:scale-105 transition">
                        <img src="{{ asset('build/assets/image/logo polmed.png') }}" 
                             alt="Logo POLMED" 
                             class="w-full h-full object-contain"
                             onerror="this.onerror=null; this.src='{{ asset('build/assets/image/logo%20polmed.png') }}';">
                    </div>

                    <!-- Teks Brand SIBEKA POLMED -->
                    <div class="text-left">
                        <div class="font-extrabold text-base text-white tracking-wide leading-tight">
                            SIBEKA POLMED
                        </div>
                        <p class="text-[11px] text-slate-400 tracking-tight hidden sm:block mt-0.5 font-normal">
                            Portal Beasiswa Resmi Politeknik Negeri Medan
                        </p>
                    </div>
                </a>
            </div>

            <!-- SISI TENGAH: NAVIGATION LINKS (TOMBOL AKTIF PUTIH SESUAI FOTO) -->
            <div class="hidden md:flex items-center space-x-1.5">
                @if (auth()->check() && auth()->user()->isAdmin())
                    <!-- MENU ADMIN -->
                    <a href="{{ route('admin.dashboard') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.pelamar') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pelamar*') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Data Pelamar
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.verifikasi') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Verifikasi Dokumen
                    </a>
                    <a href="{{ route('admin.audit-log') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.audit-log') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Audit Log
                    </a>
                    <a href="{{ route('admin.sistem') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.sistem') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Sistem
                    </a>
                @else
                    <!-- MENU MAHASISWA / GUEST -->
                    <a href="{{ route('mahasiswa.dashboard') }}" 
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.dashboard') || request()->is('/') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Beranda
                    </a>
                    <a href="{{ route('mahasiswa.pendaftaran') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Pendaftaran
                    </a>
                    <a href="{{ route('mahasiswa.dokumen') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.dokumen*') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Dokumen
                    </a>
                    <a href="{{ route('mahasiswa.status') }}" 
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('mahasiswa.status') ? 'bg-white text-slate-950 font-bold shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Status Seleksi
                    </a>
                @endif
            </div>

            <!-- SISI KANAN: TOMBOL LOGIN & REGISTER (PERSIS SEPERTI FOTO) / PROFILE JIKA SUDAH LOGIN -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
                    <!-- DROPDOWN PROFIL JIKA SUDAH LOGIN -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 text-xs sm:text-sm font-semibold text-white transition focus:outline-none shadow-sm cursor-pointer">
                                <!-- Avatar Inisial Bulat -->
                                <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
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

                            <!-- Form Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-xs text-red-600 hover:text-red-700 hover:bg-red-50">
                                    {{ __('Keluar (Log Out)') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- TOMBOL LOGIN & REGISTER PERSIS SESUAI FOTO -->
                    <a href="{{ route('login') }}" 
                       class="bg-[#2563eb] hover:bg-blue-600 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-md transition transform active:scale-95 inline-block">
                        Login
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="bg-white/10 hover:bg-white/15 border border-white/25 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition inline-block">
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <!-- TOMBOL HAMBURGER (TAMPILAN MOBILE) -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- RESPONSIVE MOBILE NAVIGATION MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-[#050d22] border-t border-slate-800/80">
        <div class="p-3 space-y-1 text-xs font-semibold">
            @if (auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                <a href="{{ route('admin.pelamar') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.pelamar*') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Data Pelamar</a>
                <a href="{{ route('admin.verifikasi') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.verifikasi') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Verifikasi Dokumen</a>
                <a href="{{ route('admin.audit-log') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.audit-log') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Audit Log</a>
                <a href="{{ route('admin.sistem') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('admin.sistem') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Sistem</a>
            @else
                <a href="{{ route('mahasiswa.dashboard') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.dashboard') || request()->is('/') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Beranda</a>
                <a href="{{ route('mahasiswa.pendaftaran') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Pendaftaran</a>
                <a href="{{ route('mahasiswa.dokumen') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.dokumen*') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Dokumen</a>
                <a href="{{ route('mahasiswa.status') }}" class="block px-3 py-2 rounded-xl {{ request()->routeIs('mahasiswa.status') ? 'bg-white text-slate-900 font-bold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Status Seleksi</a>
            @endif
        </div>

        <!-- Profil Akun Pengguna / Tombol Login di Mobile -->
        <div class="pt-4 pb-3 border-t border-slate-800 px-4">
            @auth
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="font-bold text-sm text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-slate-400 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 text-xs font-semibold">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white">
                        {{ __('Profil Akun') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block px-3 py-2 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300">
                            {{ __('Keluar (Log Out)') }}
                        </a>
                    </form>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-white/10 border border-white/20 text-white font-semibold text-xs">
                            Register
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>