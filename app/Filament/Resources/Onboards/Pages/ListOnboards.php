<?php

namespace App\Filament\Resources\Onboards\Pages;

use App\Filament\Resources\Onboards\OnboardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOnboards extends ListRecords
{
    protected static string $resource = OnboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
