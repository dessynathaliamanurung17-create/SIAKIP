<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $totalLogs         = AuditLog::count();
        $logsHariIni       = AuditLog::whereDate('created_at', today())->count();
        $penggunaAktif     = AuditLog::whereNotNull('user_id')->distinct('user_id')->count('user_id');
        $totalTabel        = AuditLog::whereNotNull('tabel')->distinct('tabel')->count('tabel');
        $aktivitasTerakhir = AuditLog::latest('id')->value('created_at');

        $daftarAksi = AuditLog::query()
            ->whereNotNull('aksi')
            ->distinct()
            ->orderBy('aksi')
            ->pluck('aksi');

        $daftarTabel = AuditLog::query()
            ->whereNotNull('tabel')
            ->where('tabel', '!=', '')
            ->distinct()
            ->orderBy('tabel')
            ->pluck('tabel');

        $query = AuditLog::with('user')->latest('id');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('aksi', 'like', "%{$search}%")
                    ->orWhere('tabel', 'like', "%{$search}%")
                    ->orWhere('record_id', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->input('aksi'));
        }

        if ($request->filled('tabel')) {
            $query->where('tabel', $request->input('tabel'));
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('admin.audit-log', compact(
            'logs',
            'totalLogs',
            'logsHariIni',
            'penggunaAktif',
            'totalTabel',
            'aktivitasTerakhir',
            'daftarAksi',
            'daftarTabel'
        ));
    }
}
