<x-app-layout>
    @php
        $nama     = $user->name ?? 'Pengguna';
        $parts    = preg_split('/\s+/', trim($nama));
        $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? ($parts[0] ?? ''), 0, 1));
        $isAdmin  = $user->isAdmin();
    @endphp

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 tracking-tight">Profil Akun</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Kelola informasi akun, pembaruan kata sandi, dan pengaturan keamanan Anda di SIBEKA POLMED.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $isAdmin ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }} shadow-sm">
                    <span class="w-2 h-2 rounded-full {{ $isAdmin ? 'bg-blue-600' : 'bg-emerald-500' }}"></span>
                    {{ $isAdmin ? 'Administrator SIBEKA' : 'Mahasiswa POLMED' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- RINGKASAN AKUN -->
            <div class="bg-white rounded-3xl border border-blue-100/90 shadow-sm p-6 sm:p-7">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#0c1f4a] to-blue-600 text-white font-bold text-xl flex items-center justify-center shrink-0 shadow-md shadow-blue-900/20">
                            {{ $initials }}
                        </div>
                        <div class="space-y-1 min-w-0">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 truncate">{{ $nama }}</h3>
                            <p class="text-sm text-slate-500 truncate">{{ $user->email }}</p>
                            <div class="flex flex-wrap items-center gap-2 pt-0.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $isAdmin ? 'Role: Admin' : 'Role: Mahasiswa' }}
                                </span>
                                @if ($user->created_at)
                                    <span class="text-xs text-slate-500">
                                        Terdaftar sejak <span class="font-mono text-slate-700">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-4 py-3 rounded-2xl bg-blue-50/70 border border-blue-100 text-xs text-blue-900 shrink-0">
                        <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-slate-800">Keamanan Akun Aktif</p>
                            <p class="text-slate-500">ID Akun: <span class="font-mono font-semibold text-slate-700">#{{ $user->id }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRID 2 KOLOM: INFORMASI PROFIL & UBAH KATA SANDI -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <div class="bg-white rounded-3xl border border-blue-100/90 shadow-sm p-6 sm:p-7">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white rounded-3xl border border-blue-100/90 shadow-sm p-6 sm:p-7">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- ZONA BERBAHAYA: HAPUS AKUN -->
            <div class="bg-white rounded-3xl border border-rose-200/80 shadow-sm p-6 sm:p-7">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
