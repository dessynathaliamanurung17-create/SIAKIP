<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = ['data_lama' => 'array', 'data_baru' => 'array'];

    protected static function booted(): void
    {
        static::updating(fn () => throw new \LogicException('Audit log bersifat append-only.'));
        static::deleting(fn () => throw new \LogicException('Audit log tidak boleh dihapus.'));
    }
}