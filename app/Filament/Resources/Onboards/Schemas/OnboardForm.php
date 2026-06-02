<?php

namespace App\Filament\Resources\Onboards\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OnboardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nik_ktp'),
                DatePicker::make('onboarding_date'),
                DatePicker::make('join_date'),
                TextInput::make('job_title'),
                Select::make('level')
                    ->options(['staff' => 'Staff', 'operator' => 'Operator'])
                    ->default('staff')
                    ->required(),
                TextInput::make('departemen'),
                TextInput::make('divisi'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('no_hp'),
                TextInput::make('alamat'),
                Select::make('status_kontrak')
                    ->options(['kontrak' => 'Kontrak', 'tetap' => 'Tetap', 'magang' => 'Magang'])
                    ->default('kontrak')
                    ->required(),
                TextInput::make('lama_kontrak'),
                TextInput::make('pic'),
                TextInput::make('lokasi'),
                TextInput::make('status_makan'),
            ]);
    }
}
