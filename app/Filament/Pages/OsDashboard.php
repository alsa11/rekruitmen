<?php
namespace App\Filament\Pages;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class OsDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static ?string $navigationLabel = 'Rekap Man Power OS';
    protected static ?string $slug = 'os-dashboard';
    protected static ?string $title = 'Rekap Man Power OS';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string { return 'Man Power OS'; }
    public function getView(): string { return 'filament.pages.os-dashboard'; }
}
