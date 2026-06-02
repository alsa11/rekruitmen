<?php
namespace App\Filament\Resources\Onboards\Pages;
use App\Filament\Resources\Onboards\OnboardResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListOnboardsOperator extends ListRecords
{
    protected static string $resource = OnboardResource::class;
    public function getTitle(): string { return 'OnBoard Operator'; }
    protected function getTableQuery(): Builder { return parent::getTableQuery()->where('level','operator'); }
}
