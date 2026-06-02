<?php

namespace App\Filament\Resources\Onboards\Pages;

use App\Filament\Resources\Onboards\OnboardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOnboard extends EditRecord
{
    protected static string $resource = OnboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
