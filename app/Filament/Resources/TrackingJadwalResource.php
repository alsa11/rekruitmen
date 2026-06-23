<?php
namespace App\Filament\Resources;

use App\Models\TrackingJadwal;
use App\Filament\Resources\TrackingJadwalResource\Pages;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class TrackingJadwalResource extends Resource
{
    protected static ?string $model = TrackingJadwal::class;
    protected static ?string $modelLabel = 'Jadwal Wawancara';
    protected static ?string $pluralModelLabel = 'Main Tracking — Jadwal Wawancara';
    protected static ?int $navigationSort = 0;

    public static function getNavigationIcon(): string|\BackedEnum|null { return 'heroicon-o-calendar-days'; }
    public static function getNavigationLabel(): string { return 'Main Tracking — Jadwal Wawancara'; }
    public static function getNavigationGroup(): ?string { return 'Pipeline'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('posisi')->label('Kebutuhan Posisi')->required()->placeholder('contoh: Leader Warehouse'),
                DatePicker::make('tanggal')->label('Tanggal Wawancara')->required()->default(today()),
                TextInput::make('jam')->label('Jam Wawancara')->placeholder('09.00 - 11.30 & 13.30 s/d 15.00'),
                Select::make('tipe_kegiatan')->label('Metode Wawancara')
                    ->options([
                        'online'      => 'Wawancara Online (Gmeet/Zoom)',
                        'test_onsite' => 'Wawancara Offline / Onsite',
                        'intvw_user'  => 'Interview User (Onsite)',
                    ])
                    ->default('online')->required(),
                TextInput::make('sourcing')->label('Sourcing'),
                Select::make('pic_pewawancara')->label('Pewawancara')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit','Fanny'=>'Fanny'])
                    ->helperText('PIC yang akan mewawancarai kandidat secara langsung')
                    ->required(),
                TextInput::make('link_gmeet')->label('Link Gmeet')->placeholder('https://meet.google.com/...')->columnSpan(2),
                Select::make('status')->label('Notes / Status')
                    ->options(['pending'=>'Pending','done'=>'Done','cancel'=>'Cancel','reschedule'=>'Reschedule'])
                    ->default('pending'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('posisi')->label('Kebutuhan Posisi')->searchable()->sortable()->weight('bold'),
                TextColumn::make('tanggal')->label('Tanggal')->date('d M Y')->sortable()
                    ->color(fn(TrackingJadwal $r): ?string => $r->tanggal->isToday() ? 'warning' : null),
                TextColumn::make('jam')->label('Jam'),
                TextColumn::make('tipe_kegiatan')->label('Metode')->badge()
                    ->formatStateUsing(fn(string $state): string => match($state) {
                        'online' => 'Online', 'test_onsite' => 'Offline / Onsite', 'intvw_user' => 'Intvw User', default => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match($state) {
                        'online' => 'info', 'test_onsite' => 'warning', 'intvw_user' => 'success', default => 'gray',
                    }),
                TextColumn::make('sourcing')->label('Sourcing')->color('gray'),
                TextColumn::make('pic_pewawancara')->label('Pewawancara')->badge()->sortable()
                    ->color(fn(?string $state): string => match($state) {
                        'Ghisna' => 'primary', 'Nisa' => 'info', 'Wiwit' => 'danger', default => 'gray',
                    }),
                TextColumn::make('pic_hrd')->label('PIC HRD')->badge()
                    ->color(fn(?string $state): string => match($state) {
                        'Ghisna' => 'primary', 'Nisa' => 'info', 'Wiwit' => 'danger', default => 'gray',
                    }),
                TextColumn::make('link_gmeet')->label('Link Gmeet')
                    ->url(fn($record) => $record->link_gmeet)->openUrlInNewTab()->limit(25)->color('info'),
                TextColumn::make('status')->label('Notes')->badge()
                    ->color(fn(string $state): string => match($state) {
                        'done' => 'success', 'cancel' => 'danger', 'reschedule' => 'warning', default => 'gray',
                    }),
            ])
            ->defaultSort('tanggal','asc')
            ->filters([
                SelectFilter::make('pic_pewawancara')->label('Pewawancara')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit','Fanny'=>'Fanny']),
                SelectFilter::make('tipe_kegiatan')->label('Metode')
                    ->options(['online'=>'Online','test_onsite'=>'Offline / Onsite','intvw_user'=>'Intvw User']),
                SelectFilter::make('status')
                    ->options(['pending'=>'Pending','done'=>'Done','cancel'=>'Cancel','reschedule'=>'Reschedule']),
                Filter::make('hari_ini')->label('Hari Ini')
                    ->query(fn($query) => $query->whereDate('tanggal', today()))->toggle(),
                Filter::make('minggu_ini')->label('Minggu Ini')
                    ->query(fn($query) => $query->whereBetween('tanggal',[now()->startOfWeek(),now()->endOfWeek()]))->toggle(),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTrackingJadwals::route('/'),
            'create' => Pages\CreateTrackingJadwal::route('/create'),
            'edit'   => Pages\EditTrackingJadwal::route('/{record}/edit'),
        ];
    }
}
