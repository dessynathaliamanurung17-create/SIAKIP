<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $mode === 'enroll' ? 'Daftarkan Wajah' : 'Verifikasi Wajah' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div id="face-root" data-mode="{{ $mode }}" data-url="{{ $url }}"
                 class="bg-white p-6 shadow-sm sm:rounded-lg text-center space-y-4">

                <p class="text-sm text-gray-600">
                    @if ($mode === 'enroll')
                        Wajah belum terdaftar. Hadapkan wajah ke kamera. Sistem hanya menyimpan data numerik (terenkripsi), bukan foto.
                    @else
                        Login berhasil. Lakukan verifikasi wajah untuk melanjutkan.
                    @endif
                </p>

                <video id="video" class="mx-auto rounded border" width="480" height="360" autoplay muted playsinline></video>

                <div id="status" class="text-sm text-gray-700">Memulai...</div>

                <x-primary-button id="btn" type="button" disabled>
                    {{ $mode === 'enroll' ? 'Daftarkan Wajah' : 'Verifikasi' }}
                </x-primary-button>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button class="underline text-sm text-gray-600">Keluar</button>
            </form>
        </div>
    </div>

    @vite('resources/js/face.js')
</x-app-layout>