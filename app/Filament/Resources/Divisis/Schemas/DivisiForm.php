<?php
namespace App\Filament\Resources\Divisis\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
class DivisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->label('Nama Divisi')->required()->unique(ignoreRecord: true),
        ]);
    }
}
