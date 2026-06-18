<?php

namespace App\Filament\Resources\Joins\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JoinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('divisi'),
                TextInput::make('posisi'),
                DatePicker::make('join_date'),
                TextInput::make('user_pic'),
                TextInput::make('penempatan'),
                TextInput::make('laptop_needs'),
                FileUpload::make('laptop_memo')
                    ->label('Upload Memo Laptop (PDF/Word)')
                    ->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->disk('public')->directory('memo-laptop')->preserveFilenames()
                    ->downloadable()
                    ->columnSpanFull(),
                TextInput::make('rek_danamon'),
                Select::make('status_kontrak')
                    ->options(['probation' => 'Probation', 'kontrak' => 'Kontrak', 'tetap' => 'Tetap'])
                    ->default('probation')
                    ->required(),
                DatePicker::make('tgl_akhir_kontrak'),
                TextInput::make('pic'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
