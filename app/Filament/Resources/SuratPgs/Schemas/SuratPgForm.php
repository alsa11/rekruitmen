<?php
namespace App\Filament\Resources\SuratPgs\Schemas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
class SuratPgForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nomor_surat')->label('Nomor Surat'),
            TextInput::make('nama_karyawan')->label('Nama Karyawan')->required(),
            TextInput::make('departemen')->label('Departemen'),
            TextInput::make('posisi')->label('Posisi'),
            TextInput::make('gaji_penawaran')
                ->label('Gaji Penawaran')
                ->numeric()
                ->prefix('Rp')
                ->placeholder('contoh: 5000000'),
            DatePicker::make('tanggal_join')->label('Tanggal Join'),
            TextInput::make('pic')->label('PIC'),
            Select::make('status_ttd')
                ->label('Status TTD')
                ->options(['belum'=>'Belum','sudah'=>'Sudah'])
                ->default('belum')
                ->required(),
            Textarea::make('keterangan')->label('Keterangan')->columnSpanFull(),
        ]);
    }
}
