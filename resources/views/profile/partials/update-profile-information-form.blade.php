@php
    $isMahasiswa = ! $user->isAdmin() && $user->mahasiswa;
    $mhs = $user->mahasiswa;
@endphp

<section>
    <header class="pb-4 border-b border-slate-100">
        <h2 class="text-base font-bold text-slate-900">
            {{ $isMahasiswa ? 'Biodata & Data Akademik Mahasiswa' : 'Informasi Profil' }}
        </h2>
        <p class="mt-0.5 text-xs text-slate-500">
            {{ $isMahasiswa
                ? 'Pastikan data identitas sesuai KTM dan pangkalan data akademik kampus.'
                : 'Perbarui nama dan alamat email akun Anda.' }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
        @csrf
        @method('patch')

        @if ($isMahasiswa)
            @php
                $fotoSaatIni = $mhs->foto_url;
                $nameParts = preg_split('/\s+/', trim($user->name ?? 'M'));
                $init = strtoupper(substr($nameParts[0] ?? 'M', 0, 1) . substr($nameParts[1] ?? ($nameParts[0] ?? ''), 0, 1));
            @endphp
            <div x-data="{ preview: @js($fotoSaatIni) }" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                <label for="foto_profil" class="block text-xs font-semibold text-slate-600">
                    Pas Foto / Foto Profil Formal
                </label>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-[#0c1f4a] to-blue-600 text-white font-bold text-xl flex items-center justify-center shrink-0 border-2 border-white shadow-sm">
                        <template x-if="preview">
                            <img :src="preview" alt="Preview Foto Profil" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <span>{{ $init }}</span>
                        </template>
                    </div>

                    <div class="flex-1 space-y-2">
                        <input id="foto_profil" name="foto_profil" type="file"
                               accept=".jpg,.jpeg,.png,.webp"
                               @change="if ($event.target.files[0]) { preview = URL.createObjectURL($event.target.files[0]); }"
                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl cursor-pointer bg-white focus:outline-none transition">
                        <p class="text-[11px] text-slate-500">
                            Gunakan pas foto formal terbaru (JPG, PNG, WEBP • Maks. 2 MB).
                        </p>

                        @if ($fotoSaatIni)
                            <label class="inline-flex items-center gap-2 text-xs text-rose-600 cursor-pointer select-none">
                                <input type="checkbox" name="hapus_foto" value="1"
                                       @change="if ($event.target.checked) { preview = null; } else { preview = @js($fotoSaatIni); }"
                                       class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <span>Hapus foto profil saat ini</span>
                            </label>
                        @endif
                    </div>
                </div>

                <x-input-error class="text-xs" :messages="$errors->get('foto_profil')" />
            </div>
        @endif

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-600 mb-1.5">
                Nama Lengkap {{ $isMahasiswa ? '(Sesuai KTM)' : '' }}
            </label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('name')" />
        </div>

        @if ($isMahasiswa)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nim_display" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Nomor Induk Mahasiswa (NIM)
                    </label>
                    <input id="nim_display" type="text"
                           value="{{ $mhs->nim }}"
                           disabled
                           class="w-full text-sm font-mono bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-500 cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">NIM tidak dapat diubah karena terikat dengan berkas seleksi.</p>
                </div>

                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        No. HP / WhatsApp Aktif
                    </label>
                    <input id="no_hp" name="no_hp" type="text"
                           value="{{ old('no_hp', $mhs->no_hp) }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full text-sm font-mono bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                    <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('no_hp')" />
                </div>
            </div>

            <div>
                <label for="asal_kampus" class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Asal Kampus / Perguruan Tinggi
                </label>
                <input id="asal_kampus" name="asal_kampus" type="text"
                       value="{{ old('asal_kampus', $mhs->asal_kampus) }}"
                       required
                       placeholder="Contoh: Universitas Sumatera Utara / Politeknik Negeri Medan"
                       class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('asal_kampus')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="jurusan" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Jurusan
                    </label>
                    <input id="jurusan" name="jurusan" type="text"
                           value="{{ old('jurusan', $mhs->jurusan) }}"
                           required
                           placeholder="Contoh: Teknik Komputer & Informatika"
                           class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                    <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('jurusan')" />
                </div>

                <div>
                    <label for="program_studi" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Program Studi
                    </label>
                    <input id="program_studi" name="program_studi" type="text"
                           value="{{ old('program_studi', $mhs->program_studi) }}"
                           required
                           placeholder="Contoh: D4 Rekayasa Perangkat Lunak"
                           class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                    <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('program_studi')" />
                </div>
            </div>
        @endif

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">
                Alamat Email
            </label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 space-y-1">
                    <p>
                        Alamat email Anda belum diverifikasi.
                        <button form="send-verification" class="underline font-semibold text-blue-700 hover:text-blue-900">
                            Klik di sini untuk mengirim ulang tautan verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="font-semibold text-emerald-700">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm transition shadow-sm shadow-blue-600/20">
                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Perubahan</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Profil berhasil disimpan.</span>
                </p>
            @endif
        </div>
    </form>
</section>
