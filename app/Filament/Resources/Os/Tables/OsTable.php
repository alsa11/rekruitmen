<?php
namespace App\Filament\Resources\Os\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class OsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('posisi')->label('Position')->searchable()->sortable()->weight('bold'),
                TextColumn::make('placement')->label('Placement')->searchable()->sortable(),
                TextColumn::make('qty')->label('Qty')->sortable()->badge()->color('gray'),
                TextColumn::make('os_filled')->label('OS')->sortable()->badge()->color('success'),
                TextColumn::make('outstanding')
                    ->label('Outstanding')
                    ->state(fn($record) => $record->outstanding)
                    ->badge()
                    ->color(fn($state) => $state > 0 ? 'danger' : 'success'),
                TextColumn::make('nama')->label('Name')->searchable()->sortable()
                    ->color(fn($record) => match($record->status_akhir) {
                        'hold'    => 'warning',
                        'batal','keluar' => 'danger',
                        'selesai' => 'success',
                        default   => null,
                    }),
                TextColumn::make('tanggal_join')->label('Joined')->date('d/m/Y')->sortable()->placeholder('-'),
                TextColumn::make('pic')->label('PIC')->sortable()->badge()
                    ->color(fn($state) => match($state) {
                        'Ghisna'=>'info','Nisa'=>'success','Wiwit'=>'warning',default=>'gray'
                    }),
                TextColumn::make('keterangan')->label('Keterangan')->sortable()->badge()
                    ->color(fn($state) => match(strtoupper($state??'')) {
                        'HOLD'   => 'warning',
                        'FINISH','CLOSE','ON BOARDING' => 'success',
                        'RESIGN','BATAL' => 'danger',
                        default  => 'gray'
                    }),
                TextColumn::make('status_akhir')->label('Status')->sortable()->badge()
                    ->color(fn($state) => match($state) {
                        'diterima' => 'success',
                        'keluar','batal' => 'danger',
                        'hold'     => 'warning',
                        'selesai'  => 'info',
                        'proses'   => 'gray',
                        default    => 'gray'
                    }),
            ])
            ->groups([
                Group::make('pic')->label('PIC'),
                Group::make('posisi')->label('Posisi'),
            ])
            ->filters([
                SelectFilter::make('pic')->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('status_akhir')->label('Status')
                    ->options(['diterima'=>'Aktif','keluar'=>'Keluar','hold'=>'Hold','batal'=>'Batal','selesai'=>'Selesai']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultGroup('pic')
            ->defaultSort('posisi','asc');
    }
}
