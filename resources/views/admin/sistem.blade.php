<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Status Sistem</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                <table class="min-w-full text-sm">
                    @foreach ($cek as $nama => $r)
                        <tr class="border-b">
                            <td class="p-2 font-semibold capitalize">{{ $nama }}</td>
                            <td class="p-2">
                                <span class="px-2 py-0.5 rounded text-white {{ $r['ok'] ? 'bg-green-600' : 'bg-red-600' }}">
                                    {{ $r['ok'] ? 'OK' : 'BERMASALAH' }}
                                </span>
                            </td>
                            <td class="p-2 text-gray-600">{{ $r['info'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <form method="POST" action="{{ route('admin.sistem.backup') }}">
                @csrf
                <x-primary-button>Backup Sekarang</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>