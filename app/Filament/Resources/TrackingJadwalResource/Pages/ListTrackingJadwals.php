<?php
namespace App\Filament\Resources\TrackingJadwalResource\Pages;
use App\Filament\Resources\TrackingJadwalResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListTrackingJadwals extends ListRecords {
    protected static string $resource = TrackingJadwalResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()->label('+ Tambah Jadwal')]; }
}
