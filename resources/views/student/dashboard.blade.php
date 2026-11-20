<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Mahasiswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-1">
                <p>Nama: {{ auth()->user()->name }}</p>
                <p>NIM: {{ $mhs?->nim }}</p>
                <p>Jurusan / Prodi: {{ $mhs?->jurusan }} / {{ $mhs?->program_studi }}</p>
            </div>

            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-2">
                <div class="font-semibold">Status Pendaftaran Beasiswa</div>
                <p>
                    @if ($application)
                        Status: <b>{{ $application->status }}</b> · Dokumen terunggah: <b>{{ $jumlahDokumen }}</b>
                    @else
                        Belum mendaftar.
                    @endif
                </p>
                <a class="underline text-indigo-600" href="{{ route('mahasiswa.pendaftaran') }}">
                    {{ $application ? 'Lihat / ubah pendaftaran' : 'Isi pendaftaran beasiswa' }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>