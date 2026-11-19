<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    const UPDATED_AT = null;
    protected $guarded = [];
    protected $casts = ['data_lama' => 'array', 'data_baru' => 'array'];
}
