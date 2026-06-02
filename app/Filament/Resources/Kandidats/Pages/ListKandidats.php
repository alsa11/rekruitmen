<?php

namespace App\Filament\Resources\Kandidats\Pages;

use App\Filament\Resources\Kandidats\KandidatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKandidats extends ListRecords
{
    protected static string $resource = KandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
