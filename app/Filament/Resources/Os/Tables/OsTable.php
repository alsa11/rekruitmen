<?php
namespace App\Filament\Resources\Os\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('posisi')
                    ->label('Posisi')
                    ->searchable(),
                TextColumn::make('placement')
                    ->label('Penempatan')
                    ->searchable(),
                TextColumn::make('qty')
                    ->label('Qty')
                    ->sortable(),
                TextColumn::make('pic')
                    ->label('PIC')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'Ghisna' => 'info',
                        'Nisa'   => 'success',
                        'Wiwit'  => 'warning',
                        default  => 'gray',
                    }),
                TextColumn::make('tanggal_join')
                    ->label('Tgl Join')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->badge()
                    ->color(fn($state) => match(strtolower($state ?? '')) {
                        'pengganti' => 'warning',
                        'baru'      => 'success',
                        default     => 'gray',
                    }),
                TextColumn::make('status_akhir')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'diterima' => 'success',
                        'keluar'   => 'danger',
                        default    => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('pic')
                    ->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('keterangan')
                    ->label('Keterangan')
                    ->options(['Pengganti'=>'Pengganti','Baru'=>'Baru']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at','desc');
    }
}
