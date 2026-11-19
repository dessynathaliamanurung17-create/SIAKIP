<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Verifikasi Dokumen</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Mahasiswa</th><th class="p-2">Jenis</th><th class="p-2">File</th><th class="p-2"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($documents as $d)
                    <tr class="border-b">
                        <td class="p-2">{{ $d->application->mahasiswa->user->name }}</td>
                        <td class="p-2">{{ $d->jenis }}</td>
                        <td class="p-2">{{ $d->nama_asli }}</td>
                        <td class="p-2"><a class="underline text-indigo-600" href="{{ route('admin.pelamar.show', $d->application_id) }}">Periksa</a></td>
                    </tr>
                @empty
                    <tr><td class="p-2" colspan="4">Tidak ada dokumen yang menunggu verifikasi.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $documents->links() }}</div>
        </div>
    </div>
</x-app-layout>