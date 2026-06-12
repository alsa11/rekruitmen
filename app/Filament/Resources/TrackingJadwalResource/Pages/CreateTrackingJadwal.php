<?php
namespace App\Filament\Resources\TrackingJadwalResource\Pages;
use App\Filament\Resources\TrackingJadwalResource;
use Filament\Resources\Pages\CreateRecord;
class CreateTrackingJadwal extends CreateRecord {
    protected static string $resource = TrackingJadwalResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}
