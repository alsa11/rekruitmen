<?php
namespace App\Filament\Resources\Os\Schemas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->label('Nama')->required(),
            TextInput::make('posisi')->label('Posisi'),
            TextInput::make('placement')->label('Penempatan'),
            TextInput::make('qty')->label('Qty')->numeric(),
            Select::make('pic')->label('PIC')
                ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
            DatePicker::make('tanggal_join')->label('Tgl Join'),
            Select::make('keterangan')->label('Keterangan')
                ->options(['Pengganti'=>'Pengganti','Baru'=>'Baru']),
            Select::make('status_akhir')->label('Status')
                ->options(['diterima'=>'Aktif','keluar'=>'Keluar'])
                ->default('diterima'),
            DatePicker::make('tgl_approval')->label('Tgl Approval'),
        ]);
    }
}
