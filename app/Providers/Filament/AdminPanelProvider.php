<?php
namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('HR Rekruitmen')
            ->brandLogo(fn () => file_exists(public_path('images/logo.png')) ? asset('images/logo.png') : null)
            ->brandLogoHeight('2rem')
            ->favicon(fn () => file_exists(public_path('images/logo.png')) ? asset('images/logo.png') : null)
            ->colors(['primary' => Color::Orange])
            ->globalSearch(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([Dashboard::class])
            ->widgets([])
            ->navigationGroups([
                NavigationGroup::make('Pipeline')->collapsible(false),
                NavigationGroup::make('Tracking Join')->collapsible(false),
                NavigationGroup::make('Surat & Dokumen')->collapsible(false),
                NavigationGroup::make('Man Power OS')->collapsible(false),
                NavigationGroup::make('Import & Export')->collapsible(false),
                NavigationGroup::make('Master Data')->collapsible(false),
            ])
            ->navigationItems([
                NavigationItem::make('Import Excel')
                    ->url('/import')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->group('Import & Export')
                    ->sort(1),
                NavigationItem::make('Export Excel')
                    ->url('/export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->group('Import & Export')
                    ->sort(2),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
