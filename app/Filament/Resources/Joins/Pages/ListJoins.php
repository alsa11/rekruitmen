<?php

namespace App\Filament\Resources\Joins\Pages;

use App\Filament\Resources\Joins\JoinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJoins extends ListRecords
{
    protected static string $resource = JoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
