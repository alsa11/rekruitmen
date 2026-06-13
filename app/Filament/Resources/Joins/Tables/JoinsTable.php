<?php
namespace App\Filament\Resources\Joins\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
class JoinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable()->sortable()->weight('bold'),
                TextColumn::make('divisi')->label('Divisi')->searchable()->sortable(),
                TextColumn::make('posisi')->label('Posisi')->searchable()->sortable(),
                TextColumn::make('join_date')->label('Tgl Join')->date('d/m/Y')->sortable(),
                TextColumn::make('tgl_akhir_kontrak')->label('Akhir Kontrak')->date('d/m/Y')->sortable()
                    ->color(fn($state) => $state && $state < now()->addDays(30) ? 'danger' : null),
                TextColumn::make('status_kontrak')->label('Status Kontrak')->badge()->sortable()
                    ->color(fn($state) => match($state) {
                        'probation' => 'warning',
                        'kontrak'   => 'info',
                        'selesai'   => 'danger',
                        default     => 'gray',
                    }),
                TextColumn::make('pic')->label('PIC')->searchable()->sortable()->badge()
                    ->color(fn($state) => match($state) {
                        'Ghisna'=>'info','Nisa'=>'success','Wiwit'=>'warning',default=>'gray'
                    }),
                TextColumn::make('user_pic')->label('User PIC')->searchable()->sortable(),
                TextColumn::make('penempatan')->label('Penempatan')->searchable()->toggleable(),
                TextColumn::make('laptop_needs')->label('Laptop')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('rek_danamon')->label('Rek. Danamon')->searchable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('divisi')->label('Divisi')
                    ->options(\App\Models\Join::distinct()->pluck('divisi','divisi')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('posisi')->label('Posisi')
                    ->options(\App\Models\Join::distinct()->pluck('posisi','posisi')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('pic')->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('status_kontrak')->label('Status Kontrak')
                    ->options(['probation'=>'Probation','kontrak'=>'Kontrak','selesai'=>'Selesai']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('join_date','desc');
    }
}
