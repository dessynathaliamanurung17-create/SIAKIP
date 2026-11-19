<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Pelamar</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg">

            <form method="GET" class="mb-4 flex gap-2 items-center">
                <select name="status" class="border-gray-300 rounded text-sm">
                    <option value="">Semua status</option>
                    @foreach (['draft','diajukan','diverifikasi','ditolak'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <x-primary-button>Filter</x-primary-button>
            </form>

            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Nama</th><th class="p-2">NIM</th><th class="p-2">Prodi</th>
                        <th class="p-2">Status</th><th class="p-2">Skor</th><th class="p-2">Hasil</th><th class="p-2"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($applications as $a)
                    <tr class="border-b">
                        <td class="p-2">{{ $a->mahasiswa->user->name }}</td>
                        <td class="p-2">{{ $a->mahasiswa_nim }}</td>
                        <td class="p-2">{{ $a->mahasiswa->program_studi }}</td>
                        <td class="p-2">{{ $a->status }}</td>
                        <td class="p-2">{{ $a->skor ?? '-' }}</td>
                        <td class="p-2">{{ $a->hasil_akhir ?? '-' }}</td>
                        <td class="p-2"><a class="underline text-indigo-600" href="{{ route('admin.pelamar.show', $a) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td class="p-2" colspan="7">Belum ada pelamar.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $applications->links() }}</div>
        </div>
    </div>
</x-app-layout>