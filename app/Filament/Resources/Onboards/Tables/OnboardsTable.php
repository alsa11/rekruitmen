<?php

namespace App\Filament\Resources\Onboards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OnboardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()->sortable()->weight('bold'),
                TextColumn::make('nik_ktp')
                    ->searchable(),
                TextColumn::make('onboarding_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('join_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('job_title')
                    ->searchable()->sortable(),
                TextColumn::make('level')
                    ->badge()->sortable(),
                TextColumn::make('departemen')
                    ->searchable()->sortable(),
                TextColumn::make('divisi')
                    ->searchable()->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->searchable(),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('status_kontrak')
                    ->badge()->sortable(),
                TextColumn::make('lama_kontrak')
                    ->searchable()->sortable(),
                TextColumn::make('pic')
                    ->searchable()->sortable()->badge(),
                TextColumn::make('lokasi')
                    ->searchable()->sortable(),
                TextColumn::make('status_makan')
                    ->searchable()->sortable(),
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
                SelectFilter::make('departemen')->label('Departemen')
                    ->options(\App\Models\Onboard::distinct()->pluck('departemen','departemen')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('divisi')->label('Divisi')
                    ->options(\App\Models\Onboard::distinct()->pluck('divisi','divisi')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('level')->label('Level')
                    ->options(\App\Models\Onboard::distinct()->pluck('level','level')->filter()->toArray()),
                SelectFilter::make('status_kontrak')->label('Status Kontrak')
                    ->options(\App\Models\Onboard::distinct()->pluck('status_kontrak','status_kontrak')->filter()->toArray()),
                SelectFilter::make('pic')->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('status_makan')->label('Status Makan')
                    ->options(\App\Models\Onboard::distinct()->pluck('status_makan','status_makan')->filter()->toArray()),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id','desc');
    }
}
