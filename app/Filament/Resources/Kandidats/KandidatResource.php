<?php
namespace App\Filament\Resources\Kandidats;
use App\Filament\Resources\Kandidats\Pages\CreateKandidat;
use App\Filament\Resources\Kandidats\Pages\EditKandidat;
use App\Filament\Resources\Kandidats\Pages\ListKandidats;
use App\Filament\Resources\Kandidats\Pages\ListKandidatsGhisna;
use App\Filament\Resources\Kandidats\Pages\ListKandidatsNisa;
use App\Filament\Resources\Kandidats\Pages\ListKandidatsWiwit;
use App\Filament\Resources\Kandidats\Pages\ListKandidatsDipertimbangkan;
use App\Filament\Resources\Kandidats\Schemas\KandidatForm;
use App\Filament\Resources\Kandidats\Tables\KandidatsTable;
use App\Models\Kandidat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
class KandidatResource extends Resource
{
    protected static ?string $model = Kandidat::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Semua Kandidat';
    protected static ?string $modelLabel = 'Kandidat';
    protected static ?string $pluralModelLabel = 'Kandidat';
    protected static ?int $navigationSort = 1;
    public static function getNavigationGroup(): ?string { return 'Pipeline'; }
    public static function form(Schema $schema): Schema { return KandidatForm::configure($schema); }
    public static function table(Table $table): Table { return KandidatsTable::configure($table); }
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index'            => ListKandidats::route('/'),
            'ghisna'           => ListKandidatsGhisna::route('/ghisna'),
            'nisa'             => ListKandidatsNisa::route('/nisa'),
            'wiwit'            => ListKandidatsWiwit::route('/wiwit'),
            'dipertimbangkan'  => ListKandidatsDipertimbangkan::route('/dipertimbangkan'),
            'create'           => CreateKandidat::route('/create'),
            'edit'             => EditKandidat::route('/{record}/edit'),
        ];
    }
    public static function getNavigationItems(): array {
        return [
            \Filament\Navigation\NavigationItem::make('Semua Kandidat')
                ->icon('heroicon-o-users')
                ->url(static::getUrl('index'))
                ->sort(1)->group('Pipeline')
                ->badge(Kandidat::count()),
            \Filament\Navigation\NavigationItem::make('Ghisna')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('ghisna'))
                ->sort(2)->group('Pipeline')
                ->badge(Kandidat::where('pic','Ghisna')->count()),
            \Filament\Navigation\NavigationItem::make('Nisa')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('nisa'))
                ->sort(3)->group('Pipeline')
                ->badge(Kandidat::where('pic','Nisa')->count()),
            \Filament\Navigation\NavigationItem::make('Wiwit')
                ->icon('heroicon-o-user')
                ->url(static::getUrl('wiwit'))
                ->sort(4)->group('Pipeline')
                ->badge(Kandidat::where('pic','Wiwit')->count()),
            \Filament\Navigation\NavigationItem::make('Dipertimbangkan')
                ->icon('heroicon-o-clock')
                ->url(static::getUrl('dipertimbangkan'))
                ->sort(5)->group('Pipeline')
                ->badge(Kandidat::where('status_akhir','dipertimbangkan')->count())
        ];
    }
}
