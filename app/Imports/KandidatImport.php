<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KandidatImport implements WithMultipleSheets
{
    private array $results = [];

    public function sheets(): array
    {
        return [
            'Ghisna' => new KandidatSheetImport('Ghisna', $this->results),
            'Nisa'   => new KandidatSheetImport('Nisa',   $this->results),
            'Wiwit'  => new KandidatSheetImport('Wiwit',  $this->results),
        ];
    }

    public function getResults(): array { return $this->results; }
}
