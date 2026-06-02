<?php

namespace App\Filament\Resources\Joins\Pages;

use App\Filament\Resources\Joins\JoinResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJoin extends EditRecord
{
    protected static string $resource = JoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
