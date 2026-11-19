<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['application_id', 'jenis', 'path', 'nama_asli', 'mime', 'ukuran', 'sha256'];
    public function application() { return $this->belongsTo(Application::class); }
}