<?php
namespace App\Observers;
use App\Models\Kandidat;
use App\Models\Join;

class KandidatObserver
{
    public function updated(Kandidat $kandidat): void
    {
        // Kalau status berubah jadi diterima dan belum ada di JOIN
        if ($kandidat->isDirty('status_akhir') && $kandidat->status_akhir === 'diterima') {
            $sudahAda = Join::where('nama', $kandidat->nama)->exists();
            if (!$sudahAda) {
                Join::create([
                    'nama'           => $kandidat->nama,
                    'posisi'         => $kandidat->posisi,
                    'divisi'         => $kandidat->departemen,
                    'join_date'      => $kandidat->tanggal_join ?? now(),
                    'pic'            => $kandidat->pic,
                    'status_kontrak' => 'kontrak',
                ]);
            }
        }
    }
}
