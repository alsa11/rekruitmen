<?php
namespace App\Filament\Resources\Os\Pages;
use App\Filament\Resources\Os\OsResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListOsWiwit extends ListRecords
{
    protected static string $resource = OsResource::class;
    public function getTitle(): string { return 'OS — Wiwit'; }
    protected function getTableQuery(): Builder { return parent::getTableQuery()->where('pic','Wiwit'); }
}
