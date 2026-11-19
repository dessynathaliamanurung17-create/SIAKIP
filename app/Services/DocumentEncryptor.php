<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentEncryptor
{
    private const DISK = 'local';      // storage/app/private (tidak bisa diakses via URL)
    private const DIR  = 'documents';

    public function store(UploadedFile $file): array
    {
        $plain = file_get_contents($file->getRealPath());
        $path  = self::DIR . '/' . Str::uuid() . '.enc';   // nama acak, bukan nama asli

        Storage::disk(self::DISK)->put($path, Crypt::encryptString($plain));

        return [
            'path'   => $path,
            'sha256' => hash('sha256', $plain),             // hash file asli
            'ukuran' => $file->getSize(),
            'mime'   => $file->getMimeType(),
        ];
    }

    public function read(string $path): string
    {
        return Crypt::decryptString(Storage::disk(self::DISK)->get($path));
    }

    public function delete(string $path): void
    {
        Storage::disk(self::DISK)->delete($path);
    }
}