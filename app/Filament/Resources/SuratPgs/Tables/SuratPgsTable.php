<?php
namespace App\Filament\Resources\SuratPgs\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
class SuratPgsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_surat')->label('No Surat')->searchable()->sortable(),
                TextColumn::make('nama_karyawan')->label('Nama')->searchable()->sortable()->weight('bold'),
                TextColumn::make('departemen')->label('Departemen')->searchable()->sortable(),
                TextColumn::make('posisi')->label('Posisi')->searchable()->sortable(),
                TextColumn::make('gaji_penawaran')
                    ->label('Gaji Penawaran')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('tanggal_join')->label('Tgl Join')->date('d/m/Y')->sortable(),
                TextColumn::make('pic')->label('PIC')->badge()->sortable(),
                TextColumn::make('status_ttd')->label('Status TTD')
                    ->badge()->sortable()
                    ->color(fn($state) => match($state) {
                        'sudah' => 'success',
                        'belum' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('departemen')->label('Departemen')
                    ->options(\App\Models\SuratPg::distinct()->pluck('departemen','departemen')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('posisi')->label('Posisi')
                    ->options(\App\Models\SuratPg::distinct()->pluck('posisi','posisi')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('pic')->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('status_ttd')->label('Status TTD')
                    ->options(['belum'=>'Belum','sudah'=>'Sudah']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at','desc');
    }
}
