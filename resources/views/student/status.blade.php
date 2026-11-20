<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Status Seleksi</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow-sm sm:rounded-lg text-sm space-y-2">
                @if (session('status'))
                    <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
                @endif

                @if (! $application)
                    <p>Anda belum mendaftar.</p>
                @else
                    <p>Status pendaftaran: <b>{{ $application->status }}</b></p>
                    <p>Hasil verifikasi: {{ $application->hasil_verifikasi ?? 'Belum ada' }}</p>
                    <p>Hasil akhir:
                        <b>{{ $application->hasil_akhir ?? 'Belum ditetapkan' }}</b>
                    </p>
                    {{-- skor sengaja tidak ditampilkan ke mahasiswa --}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>