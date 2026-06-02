<?php

namespace App\Filament\Resources\SuratPgs\Pages;

use App\Filament\Resources\SuratPgs\SuratPgResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuratPgs extends ListRecords
{
    protected static string $resource = SuratPgResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
