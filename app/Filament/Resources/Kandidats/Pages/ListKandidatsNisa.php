<?php
namespace App\Filament\Resources\Kandidats\Pages;
use App\Filament\Resources\Kandidats\KandidatResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListKandidatsNisa extends ListRecords
{
    protected static string $resource = KandidatResource::class;
    public function getTitle(): string { return 'Kandidat — Nisa'; }
    protected function getTableQuery(): Builder { return parent::getTableQuery()->where('pic','Nisa'); }
}
