<?php
namespace App\Filament\Resources\SuratPgs\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class SuratPgsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_surat')->label('No Surat')->searchable(),
                TextColumn::make('nama_karyawan')->label('Nama')->searchable()->weight('bold'),
                TextColumn::make('departemen')->label('Departemen')->searchable(),
                TextColumn::make('posisi')->label('Posisi')->searchable(),
                TextColumn::make('gaji_penawaran')
                    ->label('Gaji Penawaran')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('tanggal_join')->label('Tgl Join')->date('d/m/Y')->sortable(),
                TextColumn::make('pic')->label('PIC')->badge(),
                TextColumn::make('status_ttd')->label('Status TTD')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'sudah' => 'success',
                        'belum' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at','desc');
    }
}
