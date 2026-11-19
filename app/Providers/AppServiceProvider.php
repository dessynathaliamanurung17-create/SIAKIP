<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Application, Document, Mahasiswa};
use App\Observers\AuditObserver;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\{Login, Logout, Failed};
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Application::observe(AuditObserver::class);
    Document::observe(AuditObserver::class);
    Mahasiswa::observe(AuditObserver::class);

    Event::listen(Login::class,  fn ($e) => AuditLogger::record('login'));
    Event::listen(Logout::class, fn ($e) => AuditLogger::record('logout'));
    Event::listen(Failed::class, fn ($e) => AuditLogger::record(
        'login_gagal', null, null, ['email' => $e->credentials['email'] ?? null]
    ));
}
}
