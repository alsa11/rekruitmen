<?php
namespace App\Filament\Resources\KandidatResource\Pages;
use App\Filament\Resources\KandidatResource;
use Filament\Resources\Pages\EditRecord;

class EditKandidat extends EditRecord
{
    protected static string $resource = KandidatResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\DeleteAction::make()];
    }
}
