<?php
namespace App\Filament\Resources\TrackingJadwalResource\Pages;
use App\Filament\Resources\TrackingJadwalResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditTrackingJadwal extends EditRecord {
    protected static string $resource = TrackingJadwalResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
