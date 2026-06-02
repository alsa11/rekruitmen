<?php

namespace App\Filament\Resources\Os\Pages;

use App\Filament\Resources\Os\OsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOs extends ListRecords
{
    protected static string $resource = OsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
