<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllSheetsImport implements WithMultipleSheets
{
    private array $results = [];

    public function sheets(): array
    {
        return [
            'Ghisna'           => new KandidatSheetImport('Ghisna', $this->results),
            'Nisa'             => new KandidatSheetImport('Nisa',   $this->results),
            'Wiwit'            => new KandidatSheetImport('Wiwit',  $this->results),
            'JOIN'             => new JoinImport(),
            'OnBoard Staff'    => new OnboardImport('staff'),
            'OnBoard Operator' => new OnboardImport('operator'),
            'No Surat PG'      => new SuratPgImport(),
            'OS'               => new OsImport(),
        ];
    }

    public function getResults(): array { return $this->results; }
}
