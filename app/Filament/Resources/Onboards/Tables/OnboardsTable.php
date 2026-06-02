<?php

namespace App\Filament\Resources\Onboards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OnboardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('nik_ktp')
                    ->searchable(),
                TextColumn::make('onboarding_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('join_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->searchable(),
                TextColumn::make('level')
                    ->badge(),
                TextColumn::make('departemen')
                    ->searchable(),
                TextColumn::make('divisi')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->searchable(),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('status_kontrak')
                    ->badge(),
                TextColumn::make('lama_kontrak')
                    ->searchable(),
                TextColumn::make('pic')
                    ->searchable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('status_makan')
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
