<?php
namespace App\Filament\Resources\Onboards;
use App\Filament\Resources\Onboards\Pages\CreateOnboard;
use App\Filament\Resources\Onboards\Pages\EditOnboard;
use App\Filament\Resources\Onboards\Pages\ListOnboards;
use App\Filament\Resources\Onboards\Pages\ListOnboardsOperator;
use App\Filament\Resources\Onboards\Pages\ListOnboardsStaff;
use App\Filament\Resources\Onboards\Schemas\OnboardForm;
use App\Filament\Resources\Onboards\Tables\OnboardsTable;
use App\Models\Onboard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class OnboardResource extends Resource
{
    protected static ?string $model = Onboard::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'OnBoard';
    protected static ?string $modelLabel = 'OnBoard';
    protected static ?string $pluralModelLabel = 'OnBoard';
    protected static ?int $navigationSort = 2;
    public static function getNavigationGroup(): ?string { return 'Tracking Join'; }
    public static function form(Schema $schema): Schema { return OnboardForm::configure($schema); }
    public static function table(Table $table): Table { return OnboardsTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index'    => ListOnboards::route('/'),
            'operator' => ListOnboardsOperator::route('/operator'),
            'staff'    => ListOnboardsStaff::route('/staff'),
            'create'   => CreateOnboard::route('/create'),
            'edit'     => EditOnboard::route('/{record}/edit'),
        ];
    }
    public static function getNavigationItems(): array {
        return [
            \Filament\Navigation\NavigationItem::make('OnBoard Operator')
                ->icon('heroicon-o-user-plus')
                ->url(static::getUrl('operator'))
                ->sort(3)
                ->group('Tracking Join')
                ->badge(\App\Models\Onboard::where('level','operator')->count()),
            \Filament\Navigation\NavigationItem::make('OnBoard Staff')
                ->icon('heroicon-o-user-plus')
                ->url(static::getUrl('staff'))
                ->sort(4)
                ->group('Tracking Join')
                ->badge(\App\Models\Onboard::where('level','staff')->count()),
        ];
    }
}
