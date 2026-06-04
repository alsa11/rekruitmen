<?php
namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
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
            ->renderHook(
                'panels::topbar.end.before',
                fn () => '<a href="/" style="display:flex;align-items:center;gap:5px;padding:5px 12px;border-radius:8px;font-size:13px;font-weight:500;color:#6b7280;text-decoration:none;margin-right:6px;border:1px solid #e5e7eb" onmouseover="this.style.background=\'#f9fafb\'" onmouseout="this.style.background=\'transparent\'"><svg xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Dashboard</a>'
            )
            ->userMenuItems([
                MenuItem::make()
                    ->label('Dashboard Analitik')
                    ->url('/')
                    ->icon('heroicon-o-chart-bar'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([ \App\Filament\Widgets\RecruitmentStatsWidget::class, \App\Filament\Widgets\KontrakWidget::class])
            ->navigationGroups([
                NavigationGroup::make('Pipeline')->collapsible(false),
                NavigationGroup::make('Tracking Join')->collapsible(false),
                NavigationGroup::make('Surat & Dokumen')->collapsible(false),
                NavigationGroup::make('Man Power OS')->collapsible(false),
                NavigationGroup::make('Import & Export')->collapsible(false),
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
