<?php
namespace App\Filament\Resources\Kandidats\Pages;
use App\Filament\Resources\Kandidats\KandidatResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListKandidatsDipertimbangkan extends ListRecords
{
    protected static string $resource = KandidatResource::class;
    public function getTitle(): string { return 'Kandidat Dipertimbangkan'; }
    protected function getTableQuery(): Builder {
        return parent::getTableQuery()->where('status_akhir','dipertimbangkan');
    }
}
