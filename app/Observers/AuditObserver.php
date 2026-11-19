<?php

namespace App\Observers;

use App\Services\AuditLogger;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    public function created(Model $model): void
    {
        AuditLogger::record('created', $model, null, AuditLogger::mask($model->getAttributes()));
    }

    public function updated(Model $model): void
    {
        $baru = $model->getChanges();
        unset($baru['updated_at']);
        if (! $baru) return;

        $lama = [];
        foreach (array_keys($baru) as $kolom) {
            $lama[$kolom] = $model->getRawOriginal($kolom); // nilai mentah (tetap terenkripsi jika kolom sensitif)
        }

        AuditLogger::record('updated', $model, AuditLogger::mask($lama, true), AuditLogger::mask($baru, true));
    }

    public function deleted(Model $model): void
    {
        AuditLogger::record('deleted', $model, AuditLogger::mask($model->getAttributes()), null);
    }
}