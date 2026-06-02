<?php
namespace App\Filament\Resources\Posisis\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
class PosisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->label('Nama Posisi')->required()->unique(ignoreRecord: true),
            TextInput::make('departemen')->label('Departemen'),
        ]);
    }
}
