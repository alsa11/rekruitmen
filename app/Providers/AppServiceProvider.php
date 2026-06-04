<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Fix Filament route name mismatch
        $this->callAfterResolving('router', function () {
            if (!Route::has('filament.admin.auth.login') && Route::has('filament.admin.pages.login')) {
                Route::get('/admin/auth/login-redirect', function () {
                    return redirect()->route('filament.admin.pages.login');
                })->name('filament.admin.auth.login');
            }
        });
    }
}
