<?php
namespace App\Filament\Resources\Posisis;
use App\Filament\Resources\Posisis\Pages\CreatePosisi;
use App\Filament\Resources\Posisis\Pages\EditPosisi;
use App\Filament\Resources\Posisis\Pages\ListPosisis;
use App\Filament\Resources\Posisis\Schemas\PosisiForm;
use App\Filament\Resources\Posisis\Tables\PosisisTable;
use App\Models\Posisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class PosisiResource extends Resource
{
    protected static ?string $model = Posisi::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Master Posisi';
    protected static ?string $modelLabel = 'Posisi';
    protected static ?string $pluralModelLabel = 'Posisi';
    public static function getNavigationGroup(): ?string { return 'Master Data'; }
    public static function form(Schema $schema): Schema { return PosisiForm::configure($schema); }
    public static function table(Table $table): Table { return PosisisTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index'  => ListPosisis::route('/'),
            'create' => CreatePosisi::route('/create'),
            'edit'   => EditPosisi::route('/{record}/edit'),
        ];
    }
}
