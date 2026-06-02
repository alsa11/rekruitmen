<?php
namespace App\Filament\Resources\Joins;
use App\Filament\Resources\Joins\Pages\CreateJoin;
use App\Filament\Resources\Joins\Pages\EditJoin;
use App\Filament\Resources\Joins\Pages\ListJoins;
use App\Filament\Resources\Joins\Schemas\JoinForm;
use App\Filament\Resources\Joins\Tables\JoinsTable;
use App\Models\Join;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class JoinResource extends Resource
{
    protected static ?string $model = Join::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $recordTitleAttribute = 'nama';
    public static function getNavigationGroup(): ?string { return 'Tracking Join'; }
    protected static ?string $navigationLabel = 'Data JOIN';
    protected static ?string $modelLabel = 'Data JOIN';
    protected static ?string $pluralModelLabel = 'Data JOIN';
    protected static ?int $navigationSort = 1;
    public static function form(Schema $schema): Schema { return JoinForm::configure($schema); }
    public static function table(Table $table): Table { return JoinsTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => ListJoins::route('/'),
            'create' => CreateJoin::route('/create'),
            'edit' => EditJoin::route('/{record}/edit'),
        ];
    }
}
