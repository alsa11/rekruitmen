<?php

namespace App\Filament\Resources\Posisis\Pages;

use App\Filament\Resources\Posisis\PosisiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPosisis extends ListRecords
{
    protected static string $resource = PosisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
