<?php
namespace App\Filament\Resources\Os\Pages;
use App\Filament\Resources\Os\OsResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListOsNisa extends ListRecords
{
    protected static string $resource = OsResource::class;
    public function getTitle(): string { return 'OS — Nisa'; }
    protected function getTableQuery(): Builder { return parent::getTableQuery()->where('pic','Nisa'); }
}
