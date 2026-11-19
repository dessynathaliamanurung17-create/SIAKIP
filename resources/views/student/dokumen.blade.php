<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dokumen Persyaratan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            @php($jenisList = ['kk' => 'Kartu Keluarga', 'ktm' => 'KTM / KTP', 'penghasilan' => 'Surat Keterangan Penghasilan', 'lainnya' => 'Dokumen Pendukung'])

            @foreach ($jenisList as $kode => $label)
                @php($doc = $documents[$kode] ?? null)
                <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                    <div class="font-semibold">{{ $label }}</div>

                    @if ($doc)
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $doc->nama_asli }} · status: <b>{{ $doc->status_verifikasi }}</b>
                            @if ($doc->catatan) · catatan: {{ $doc->catatan }} @endif
                            · <a class="underline text-indigo-600" href="{{ route('dokumen.unduh', $doc) }}">Unduh</a>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 mt-1">Belum diunggah</div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.dokumen.store') }}" enctype="multipart/form-data" class="mt-2 flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ $kode }}">
                        <input type="file" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required class="text-sm">
                        <x-primary-button>{{ $doc ? 'Ganti' : 'Unggah' }}</x-primary-button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>