@php($terkunci = $application && $application->status !== 'draft')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pendaftaran Beasiswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded text-sm">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif
            @if ($terkunci)
                <div class="p-3 bg-yellow-100 text-yellow-800 rounded text-sm">
                    Pendaftaran sudah diajukan dan dikunci. Data tidak dapat diubah lagi.
                </div>
            @endif

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-1">
                <div class="font-semibold mb-2">Identitas (dari profil)</div>
                <p>Nama: {{ auth()->user()->name }} · NIM: {{ $mhs->nim }}</p>
                <p>Jurusan / Prodi: {{ $mhs->jurusan }} / {{ $mhs->program_studi }}</p>
            </div>

            <form method="POST" action="{{ route('mahasiswa.pendaftaran.store') }}" class="bg-white p-4 shadow-sm sm:rounded-lg space-y-3 text-sm">
                @csrf
                <fieldset @disabled($terkunci) class="space-y-3">
                    <div class="font-semibold">Data Akademik</div>

                    <div>
                        <label>IPK (0-4)</label>
                        <input type="number" step="0.01" name="ipk" value="{{ old('ipk', $application->ipk ?? '') }}" class="block w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label>Semester</label>
                        <input type="number" name="semester" value="{{ old('semester', $application->semester ?? '') }}" class="block w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label>Riwayat prestasi</label>
                        <textarea name="riwayat_prestasi" rows="2" class="block w-full border-gray-300 rounded">{{ old('riwayat_prestasi', $application->riwayat_prestasi ?? '') }}</textarea>
                    </div>
                    <div>
                        <label>Riwayat penerimaan beasiswa</label>
                        <textarea name="riwayat_beasiswa" rows="2" class="block w-full border-gray-300 rounded">{{ old('riwayat_beasiswa', $application->riwayat_beasiswa ?? '') }}</textarea>
                    </div>

                    <div class="font-semibold pt-2">Kondisi Ekonomi <span class="text-xs text-gray-500">(disimpan terenkripsi)</span></div>

                    <div>
                        <label>Penghasilan orang tua per bulan (Rp)</label>
                        <input type="number" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', $application->penghasilan_ortu ?? '') }}" class="block w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label>Pekerjaan orang tua</label>
                        <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu', $application->pekerjaan_ortu ?? '') }}" class="block w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label>Jumlah tanggungan keluarga</label>
                        <input type="number" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $application->jumlah_tanggungan ?? '') }}" class="block w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label>Kondisi ekonomi keluarga</label>
                        <textarea name="kondisi_ekonomi" rows="2" class="block w-full border-gray-300 rounded" required>{{ old('kondisi_ekonomi', $application->kondisi_ekonomi ?? '') }}</textarea>
                    </div>

                    @unless ($terkunci)
                        <div class="flex gap-2 pt-2">
                            <x-secondary-button type="submit" name="aksi" value="draft">Simpan Draft</x-secondary-button>
                            <x-primary-button name="aksi" value="ajukan" onclick="return confirm('Setelah diajukan, data tidak bisa diubah. Lanjutkan?')">Ajukan</x-primary-button>
                        </div>
                        <p class="text-xs text-gray-500">Sebelum mengajukan, unggah dokumen KK, KTM/KTP, dan surat penghasilan di menu Dokumen.</p>
                    @endunless
                </fieldset>
            </form>
        </div>
    </div>
</x-app-layout>