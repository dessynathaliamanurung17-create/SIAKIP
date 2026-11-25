<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- 1. HEADER & AKSI CEPAT -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                    Dashboard
                </h1>

                <div class="shrink-0">
                    <a href="{{ route('admin.verifikasi') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm transition shadow-sm">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Verifikasi Cepat</span>
                    </a>
                </div>
            </div>

            <!-- 2. EMPAT KARTU METRIK UTAMA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1: Total Pendaftar -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Total Pendaftar</span>
                        <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                            {{ $totalMahasiswa }} Akun
                        </span>
                    </div>
                    <div class="text-3xl font-bold font-mono text-slate-900">{{ number_format($totalPendaftar) }}</div>
                    <p class="text-xs text-slate-400">
                        {{ $jumlahJurusan }} jurusan • {{ $totalDraft }} draft
                    </p>
                </div>

                <!-- Card 2: Berkas Terverifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Terverifikasi</span>
                        @if ($totalPendaftar > 0)
                            <span class="text-xs font-mono font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                {{ round(($berkasTerverifikasi / $totalPendaftar) * 100) }}%
                            </span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold font-mono text-emerald-600">{{ number_format($berkasTerverifikasi) }}</div>
                    <p class="text-xs text-slate-400">Lolos administrasi</p>
                </div>

                <!-- Card 3: Menunggu Verifikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Menunggu Verifikasi</span>
                        @if ($menungguVerifikasi > 0 || $dokumenMenunggu > 0)
                            <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                                Prioritas
                            </span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold font-mono text-blue-600">{{ number_format($menungguVerifikasi) }}</div>
                    <p class="text-xs text-slate-400">
                        <span class="font-mono">{{ number_format($dokumenMenunggu) }}</span> dokumen menunggu
                    </p>
                </div>

                <!-- Card 4: Diterima / Kuota -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Kuota Diterima</span>
                        <span class="text-xs font-mono font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">
                            {{ $persenKuota }}%
                        </span>
                    </div>
                    <div class="text-3xl font-bold font-mono text-slate-900">
                        {{ number_format($totalDiterima) }}
                        <span class="text-sm font-sans font-medium text-slate-400">/ {{ number_format($kuotaBeasiswa) }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-blue-600 h-1.5 rounded-full transition-all" style="width: {{ $persenKuota }}%"></div>
                    </div>
                </div>
            </div>

            <!-- 3. DISTRIBUSI PENDAFTAR PER JURUSAN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="font-bold text-base text-slate-900">Distribusi per Jurusan</h3>

                    <!-- Filter Tabs Status -->
                    <div class="inline-flex p-1 bg-slate-100 rounded-xl text-xs font-semibold">
                        @php
                            $distTabs = [
                                null           => 'Semua',
                                'diajukan'     => 'Diajukan',
                                'diverifikasi' => 'Diverifikasi',
                                'diterima'     => 'Diterima',
                            ];
                        @endphp
                        @foreach ($distTabs as $val => $label)
                            <a href="{{ route('admin.dashboard', array_filter(array_merge(request()->except('page'), ['dist_status' => $val]))) }}"
                                class="px-3 py-1 rounded-lg transition {{ $distStatus === $val ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @php
                    $barColors = [
                        ['dot' => 'bg-blue-600',   'bar' => 'bg-blue-700'],
                        ['dot' => 'bg-emerald-500','bar' => 'bg-emerald-600'],
                        ['dot' => 'bg-indigo-500', 'bar' => 'bg-indigo-600'],
                        ['dot' => 'bg-sky-500',    'bar' => 'bg-sky-600'],
                        ['dot' => 'bg-slate-500',  'bar' => 'bg-slate-600'],
                        ['dot' => 'bg-purple-500', 'bar' => 'bg-purple-600'],
                    ];
                @endphp

                <!-- Grid Jurusan Progress Bars -->
                @if ($distribusiJurusan->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 text-xs">
                        @foreach ($distribusiJurusan as $idx => $item)
                            @php
                                $persen = $totalDistribusi > 0 ? round(($item->total / $totalDistribusi) * 100, 1) : 0;
                                $color  = $barColors[$idx % count($barColors)];
                            @endphp
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-slate-800 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $color['dot'] }}"></span>
                                        {{ $item->jurusan ?: 'Belum Diisi' }}
                                    </span>
                                    <span class="font-bold text-slate-900">
                                        {{ number_format($item->total) }}
                                        <span class="text-slate-400 font-normal">({{ $persen }}%)</span>
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="{{ $color['bar'] }} h-2 rounded-full transition-all" style="width: {{ $persen }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-xs text-slate-400 bg-slate-50/60 rounded-xl border border-dashed border-slate-200">
                        Belum ada data pendaftar untuk kategori ini.
                    </div>
                @endif

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end text-xs">
                    <a href="{{ route('admin.pelamar') }}" class="font-semibold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                        <span>Lihat Semua Pelamar</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 4. TABEL PENDAFTAR TERBARU -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden space-y-4 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="font-bold text-base text-slate-900">Pendaftar Terbaru</h3>
                    <span class="text-xs font-mono font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200 w-fit">
                        {{ $applications->count() }} / {{ number_format($applications->total()) }}
                    </span>
                </div>

                <!-- Search & Filters Bar -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2">
                    @if ($distStatus)
                        <input type="hidden" name="dist_status" value="{{ $distStatus }}">
                    @endif
                    <div class="sm:col-span-5 relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pendaftar Nama / NIM / Prodi..."
                            class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-1 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <select name="jurusan" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-600 focus:bg-white focus:outline-none">
                            <option value="">Semua Jurusan</option>
                            @foreach ($daftarJurusan as $j)
                                <option value="{{ $j }}" @selected(request('jurusan') === $j)>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <select name="status" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-600 focus:bg-white focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="diajukan" @selected(request('status') === 'diajukan')>Diajukan</option>
                            <option value="diverifikasi" @selected(request('status') === 'diverifikasi')>Diverifikasi</option>
                            <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2 flex items-center gap-2">
                        <button type="submit" class="flex-1 px-3 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs transition">
                            Filter
                        </button>
                        @if (request()->hasAny(['q', 'jurusan', 'status']))
                            <a href="{{ route('admin.dashboard', array_filter(['dist_status' => $distStatus])) }}"
                                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-500 text-xs font-semibold transition" title="Reset Filter">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50/90 text-slate-600 font-semibold text-[13px] border-y border-slate-200/80">
                                <th class="py-3.5 px-3">Mahasiswa</th>
                                <th class="py-3.5 px-3">Jurusan & Prodi</th>
                                <th class="py-3.5 px-3 text-right">IPK & Semester</th>
                                <th class="py-3.5 px-3">Dokumen</th>
                                <th class="py-3.5 px-3">Status</th>
                                <th class="py-3.5 px-3 text-right">Aksi Tim</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $avatarColors = ['bg-blue-600', 'bg-emerald-700', 'bg-rose-600', 'bg-slate-700', 'bg-indigo-600'];
                            @endphp
                            @forelse ($applications as $idx => $a)
                                @php
                                    $nama        = $a->mahasiswa?->user?->name ?? 'Mahasiswa';
                                    $parts       = preg_split('/\s+/', trim($nama));
                                    $initials    = strtoupper(substr($parts[0] ?? 'M', 0, 1) . substr($parts[1] ?? ($parts[0] ?? ''), 0, 1));
                                    $avatarBg    = $avatarColors[$idx % count($avatarColors)];

                                    $docs        = $a->documents;
                                    $totalDocs   = $docs->count();
                                    $validDocs   = $docs->where('status_verifikasi', 'valid')->count();
                                    $invalidDocs = $docs->where('status_verifikasi', 'tidak_valid')->count();
                                    $pendingDocs = $docs->where('status_verifikasi', 'menunggu')->count();
                                    $docNames    = $docs->pluck('jenis')->map(fn ($j) => strtoupper($j))->implode(', ');
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition">
                                    <!-- Mahasiswa -->
                                    <td class="py-3.5 px-3">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full {{ $avatarBg }} text-white font-semibold flex items-center justify-center text-xs shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900 text-sm">{{ $nama }}</p>
                                                <p class="text-[13px] text-slate-500 font-mono">{{ $a->mahasiswa_nim }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Jurusan & Prodi -->
                                    <td class="py-3.5 px-3">
                                        <p class="font-medium text-slate-800 text-sm">{{ $a->mahasiswa?->program_studi ?? '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $a->mahasiswa?->jurusan ?? '-' }}</p>
                                    </td>

                                    <!-- Akademik (rata kanan untuk angka) -->
                                    <td class="py-3.5 px-3 text-right">
                                        <p class="font-mono font-semibold text-slate-900 text-sm">
                                            {{ number_format((float) $a->ipk, 2) }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            Semester <span class="font-mono">{{ $a->semester }}</span>
                                        </p>
                                    </td>

                                    <!-- Dokumen -->
                                    <td class="py-3.5 px-3">
                                        @if ($invalidDocs > 0)
                                            <p class="font-semibold text-rose-600 flex items-center gap-1 text-[13px]">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <span class="font-mono">{{ $validDocs }}/{{ $totalDocs }}</span> Valid
                                            </p>
                                            <p class="text-xs text-rose-500">{{ $invalidDocs }} berkas perlu revisi</p>
                                        @elseif ($totalDocs >= 3 && $validDocs === $totalDocs)
                                            <p class="font-semibold text-slate-800 flex items-center gap-1 text-[13px]">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                <span class="font-mono">{{ $validDocs }}/{{ $totalDocs }}</span> Valid
                                            </p>
                                            <p class="text-xs text-slate-500">{{ $docNames }}</p>
                                        @elseif ($totalDocs > 0)
                                            <p class="font-semibold text-slate-800 text-[13px]">
                                                <span class="font-mono">{{ $validDocs }}/{{ $totalDocs }}</span> Valid
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $pendingDocs > 0 ? $pendingDocs . ' menunggu • ' : '' }}{{ $docNames }}
                                            </p>
                                        @else
                                            <p class="font-medium text-slate-400 text-[13px]"><span class="font-mono">0</span> Berkas</p>
                                            <p class="text-xs text-slate-400">Belum unggah dokumen</p>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3.5 px-3">
                                        @if ($a->status === 'diverifikasi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ✓ Diverifikasi
                                            </span>
                                        @elseif ($a->status === 'diajukan')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                ⏳ Diajukan
                                            </span>
                                        @elseif ($a->status === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                ✕ Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Draft
                                            </span>
                                        @endif

                                        @if ($a->hasil_akhir)
                                            <p class="text-xs font-semibold mt-1 {{ $a->hasil_akhir === 'diterima' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                Hasil: {{ ucfirst($a->hasil_akhir) }}
                                            </p>
                                        @endif
                                    </td>

                                    <!-- Aksi Tim -->
                                    <td class="py-3.5 px-3 text-right">
                                        <a href="{{ route('admin.pelamar.show', $a) }}"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg {{ $a->status === 'diajukan' ? 'bg-blue-700 hover:bg-blue-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} font-semibold text-xs transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>{{ $a->status === 'diajukan' ? 'Periksa' : 'Detail' }}</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400">
                                        <p class="font-semibold text-slate-600 text-sm">Belum ada data pendaftar yang cocok.</p>
                                        <p class="text-xs mt-1">Data akan muncul otomatis saat mahasiswa mengisi pendaftaran beasiswa.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <span>
                        Menampilkan baris {{ $applications->firstItem() ?? 0 }} s/d {{ $applications->lastItem() ?? 0 }} dari total {{ number_format($applications->total()) }} pendaftar
                    </span>
                    <div>
                        {{ $applications->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
