<?php
namespace App\Filament\Resources\Onboards\Pages;
use App\Filament\Resources\Onboards\OnboardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
class ListOnboardsStaff extends ListRecords
{
    protected static string $resource = OnboardResource::class;
    public function getTitle(): string { return 'OnBoard Staff'; }
    protected function getTableQuery(): Builder { return parent::getTableQuery()->where('level','staff'); }
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
