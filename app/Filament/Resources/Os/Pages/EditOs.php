<?php

namespace App\Filament\Resources\Os\Pages;

use App\Filament\Resources\Os\OsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOs extends EditRecord
{
    protected static string $resource = OsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
