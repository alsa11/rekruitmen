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
            TextInput::make('posisi')->label('Position')->required(),
            TextInput::make('placement')->label('Placement'),
            TextInput::make('qty')->label('Qty')->numeric()->default(0)->helperText('Total kebutuhan'),
            TextInput::make('nama')->label('Name')->helperText('Nama karyawan OS yang sudah join'),
            DatePicker::make('tanggal_join')->label('Joined'),
            TextInput::make('os_filled')->label('OS')->numeric()->default(0)->helperText('Jumlah yang sudah terisi'),
            Select::make('pic')->label('PIC')
                ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
            TextInput::make('keterangan')->label('Keterangan'),
            DatePicker::make('tgl_approval')->label('Tgl Approval'),
            Select::make('status_akhir')->label('Status')
                ->options(['diterima'=>'Aktif','keluar'=>'Keluar','hold'=>'Hold','batal'=>'Batal','selesai'=>'Selesai','proses'=>'Proses'])
                ->default('diterima'),
        ]);
    }
}
