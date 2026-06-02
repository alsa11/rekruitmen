<?php

namespace App\Filament\Resources\SuratPgs\Pages;

use App\Filament\Resources\SuratPgs\SuratPgResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSuratPg extends EditRecord
{
    protected static string $resource = SuratPgResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
