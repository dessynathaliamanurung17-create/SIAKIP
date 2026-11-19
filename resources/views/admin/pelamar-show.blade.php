<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pelamar</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-1">
                <div class="font-semibold mb-2">Identitas</div>
                <p>Nama: {{ $application->mahasiswa->user->name }}</p>
                <p>Email: {{ $application->mahasiswa->user->email }}</p>
                <p>NIM: {{ $application->mahasiswa_nim }}</p>
                <p>Jurusan / Prodi: {{ $application->mahasiswa->jurusan }} / {{ $application->mahasiswa->program_studi }}</p>
                <p>No. HP: {{ $application->mahasiswa->no_hp }}</p>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-1">
                <div class="font-semibold mb-2">Data Akademik</div>
                <p>IPK: {{ $application->ipk }} · Semester: {{ $application->semester }}</p>
                <p>Riwayat prestasi: {{ $application->riwayat_prestasi ?? '-' }}</p>
                <p>Riwayat beasiswa: {{ $application->riwayat_beasiswa ?? '-' }}</p>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-1">
                <div class="font-semibold mb-2">Kondisi Ekonomi <span class="text-xs text-gray-500">(didekripsi, akses ini tercatat)</span></div>
                <p>Penghasilan orang tua: {{ $application->penghasilan_ortu }}</p>
                <p>Pekerjaan orang tua: {{ $application->pekerjaan_ortu }}</p>
                <p>Jumlah tanggungan: {{ $application->jumlah_tanggungan }}</p>
                <p>Kondisi ekonomi: {{ $application->kondisi_ekonomi }}</p>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm">
                <div class="font-semibold mb-2">Dokumen</div>
                @forelse ($application->documents as $doc)
                    <div class="border-b py-2">
                        <div>
                            <b>{{ strtoupper($doc->jenis) }}</b> · {{ $doc->nama_asli }} ·
                            <a class="underline text-indigo-600" href="{{ route('dokumen.unduh', $doc) }}">Unduh</a>
                            · status: <b>{{ $doc->status_verifikasi }}</b>
                        </div>
                        <div class="text-xs text-gray-500">SHA-256: {{ $doc->sha256 }}</div>
                        <form method="POST" action="{{ route('admin.dokumen.verifikasi', $doc) }}" class="mt-1 flex gap-2 items-center">
                            @csrf @method('PUT')
                            <select name="status_verifikasi" class="border-gray-300 rounded text-sm">
                                <option value="valid" @selected($doc->status_verifikasi === 'valid')>valid</option>
                                <option value="tidak_valid" @selected($doc->status_verifikasi === 'tidak_valid')>tidak_valid</option>
                            </select>
                            <input type="text" name="catatan" value="{{ $doc->catatan }}" placeholder="Catatan" class="border-gray-300 rounded text-sm">
                            <x-primary-button>Simpan</x-primary-button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada dokumen.</p>
                @endforelse
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm">
                <div class="font-semibold mb-2">Proses Seleksi (hanya admin)</div>
                <form method="POST" action="{{ route('admin.pelamar.seleksi', $application) }}" class="space-y-3">
                    @csrf @method('PUT')

                    <div>
                        <label>Status</label>
                        <select name="status" class="border-gray-300 rounded text-sm">
                            @foreach (['draft','diajukan','diverifikasi','ditolak'] as $s)
                                <option value="{{ $s }}" @selected($application->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Hasil verifikasi</label>
                        <textarea name="hasil_verifikasi" rows="2" class="block w-full border-gray-300 rounded text-sm">{{ old('hasil_verifikasi', $application->hasil_verifikasi) }}</textarea>
                    </div>

                    <div>
                        <label>Skor (0-100)</label>
                        <input type="number" step="0.01" name="skor" value="{{ old('skor', $application->skor) }}" class="border-gray-300 rounded text-sm">
                    </div>

                    <div>
                        <label>Hasil akhir</label>
                        <select name="hasil_akhir" class="border-gray-300 rounded text-sm">
                            <option value="">(belum ditetapkan)</option>
                            @foreach (['diterima','ditolak'] as $h)
                                <option value="{{ $h }}" @selected(old('hasil_akhir', $application->hasil_akhir) === $h)>{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button>Simpan Seleksi</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>