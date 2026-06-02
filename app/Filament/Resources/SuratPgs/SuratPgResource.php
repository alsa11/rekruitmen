<?php
namespace App\Filament\Resources\SuratPgs;
use App\Filament\Resources\SuratPgs\Pages\CreateSuratPg;
use App\Filament\Resources\SuratPgs\Pages\EditSuratPg;
use App\Filament\Resources\SuratPgs\Pages\ListSuratPgs;
use App\Filament\Resources\SuratPgs\Schemas\SuratPgForm;
use App\Filament\Resources\SuratPgs\Tables\SuratPgsTable;
use App\Models\SuratPg;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class SuratPgResource extends Resource
{
    protected static ?string $model = SuratPg::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?string $recordTitleAttribute = 'nama';
    public static function getNavigationGroup(): ?string { return 'Surat & Dokumen'; }
    protected static ?string $navigationLabel = 'Surat PG';
    protected static ?string $modelLabel = 'Surat PG';
    protected static ?string $pluralModelLabel = 'Surat PG';
    protected static ?int $navigationSort = 1;
    public static function form(Schema $schema): Schema { return SuratPgForm::configure($schema); }
    public static function table(Table $table): Table { return SuratPgsTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => ListSuratPgs::route('/'),
            'create' => CreateSuratPg::route('/create'),
            'edit' => EditSuratPg::route('/{record}/edit'),
        ];
    }
}
