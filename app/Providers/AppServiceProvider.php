<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\Kandidat;
use App\Observers\KandidatObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Kandidat::observe(KandidatObserver::class);
    }
}
