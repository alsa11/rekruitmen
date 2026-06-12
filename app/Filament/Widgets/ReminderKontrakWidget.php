<?php
namespace App\Filament\Widgets;
use App\Models\Join;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReminderKontrakWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Reminder Kontrak Habis (30 Hari)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Join::whereNotNull('tgl_akhir_kontrak')
                    ->whereBetween('tgl_akhir_kontrak', [now(), now()->addDays(30)])
                    ->orderBy('tgl_akhir_kontrak')
            )
            ->columns([
                TextColumn::make('nama')->label('Nama')->weight('bold')->searchable(),
                TextColumn::make('posisi')->label('Posisi')->color('gray'),
                TextColumn::make('divisi')->label('Divisi')->color('gray'),
                TextColumn::make('pic')->label('PIC')->badge()->color(fn($state) => match($state) {
                    'Ghisna' => 'info', 'Nisa' => 'success', 'Wiwit' => 'warning', default => 'gray'
                }),
                TextColumn::make('tgl_akhir_kontrak')->label('Akhir Kontrak')->date('d M Y')->sortable(),
                TextColumn::make('tgl_akhir_kontrak')->label('Sisa')->formatStateUsing(fn($state) => (int)now()->diffInDays($state, false).' hari')
                    ->badge()->color(fn($state) => now()->diffInDays($state,false) <= 7 ? 'danger' : (now()->diffInDays($state,false) <= 14 ? 'warning' : 'success')),
            ]);
    }
}
