<?php
namespace App\Filament\Resources\Os;
use App\Filament\Resources\Os\Pages\CreateOs;
use App\Filament\Resources\Os\Pages\EditOs;
use App\Filament\Resources\Os\Pages\ListOs;
use App\Filament\Resources\Os\Pages\ListOsGhisna;
use App\Filament\Resources\Os\Pages\ListOsNisa;
use App\Filament\Resources\Os\Pages\ListOsWiwit;
use App\Filament\Resources\Os\Schemas\OsForm;
use App\Filament\Resources\Os\Tables\OsTable;
use App\Models\Os;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class OsResource extends Resource
{
    protected static ?string $model = Os::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Semua OS';
    protected static ?string $modelLabel = 'Man Power OS';
    protected static ?string $pluralModelLabel = 'Man Power OS';
    protected static ?int $navigationSort = 1;
    public static function getNavigationGroup(): ?string { return 'Man Power OS'; }
    public static function form(Schema $schema): Schema { return OsForm::configure($schema); }
    public static function table(Table $table): Table { return OsTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index'   => ListOs::route('/'),
            'ghisna'  => ListOsGhisna::route('/ghisna'),
            'nisa'    => ListOsNisa::route('/nisa'),
            'wiwit'   => ListOsWiwit::route('/wiwit'),
            'create'  => CreateOs::route('/create'),
            'edit'    => EditOs::route('/{record}/edit'),
        ];
    }
    public static function getNavigationItems(): array {
        return [
            \Filament\Navigation\NavigationItem::make('Semua OS')
                ->icon('heroicon-o-user-circle')
                ->url(static::getUrl('index'))
                ->sort(1)
                ->group('Man Power OS')
                ->badge(Os::count()),
            \Filament\Navigation\NavigationItem::make('OS — Ghisna')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('ghisna'))
                ->sort(2)
                ->group('Man Power OS'),
            \Filament\Navigation\NavigationItem::make('OS — Nisa')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('nisa'))
                ->sort(3)
                ->group('Man Power OS'),
            \Filament\Navigation\NavigationItem::make('OS — Wiwit')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('wiwit'))
                ->sort(4)
                ->group('Man Power OS'),
        ];
    }
}
