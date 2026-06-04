<?php
namespace App\Filament\Resources\Kandidats\Pages;
use App\Filament\Resources\Kandidats\KandidatResource;
use App\Models\Join;
use Filament\Resources\Pages\EditRecord;

class EditKandidat extends EditRecord
{
    protected static string $resource = KandidatResource::class;

    protected function afterSave(): void
    {
        $kandidat = $this->record;
        if ($kandidat->status_akhir === 'diterima') {
            Join::updateOrCreate(
                ['nama' => $kandidat->nama],
                [
                    'posisi'         => $kandidat->posisi,
                    'divisi'         => $kandidat->departemen,
                    'join_date'      => $kandidat->tanggal_join ?? now()->toDateString(),
                    'pic'            => $kandidat->pic,
                    'status_kontrak' => 'kontrak',
                ]
            );
        }
    }
}
