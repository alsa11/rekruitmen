<?php

namespace App\Filament\Resources\Joins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JoinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('divisi')
                    ->searchable(),
                TextColumn::make('posisi')
                    ->searchable(),
                TextColumn::make('join_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('user_pic')
                    ->searchable(),
                TextColumn::make('penempatan')
                    ->searchable(),
                TextColumn::make('laptop_needs')
                    ->searchable(),
                TextColumn::make('laptop_memo')
                    ->searchable(),
                TextColumn::make('rek_danamon')
                    ->searchable(),
                TextColumn::make('status_kontrak')
                    ->badge(),
                TextColumn::make('tgl_akhir_kontrak')
                    ->date()
                    ->sortable(),
                TextColumn::make('pic')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
