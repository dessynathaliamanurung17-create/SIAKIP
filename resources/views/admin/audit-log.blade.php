<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Log</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-4 shadow-sm sm:rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Waktu</th><th class="p-2">User ID</th><th class="p-2">Aksi</th>
                        <th class="p-2">Tabel</th><th class="p-2">Record</th><th class="p-2">Lama</th>
                        <th class="p-2">Baru</th><th class="p-2">IP</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($logs as $log)
                    <tr class="border-b align-top">
                        <td class="p-2">{{ $log->created_at }}</td>
                        <td class="p-2">{{ $log->user_id ?? '-' }}</td>
                        <td class="p-2 font-semibold">{{ $log->aksi }}</td>
                        <td class="p-2">{{ $log->tabel }}</td>
                        <td class="p-2">{{ $log->record_id }}</td>
                        <td class="p-2"><pre class="text-xs">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT) }}</pre></td>
                        <td class="p-2"><pre class="text-xs">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT) }}</pre></td>
                        <td class="p-2">{{ $log->ip_address }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>