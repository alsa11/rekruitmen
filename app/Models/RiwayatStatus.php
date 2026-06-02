<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    protected $fillable = [
        'kandidat_id','tahap','status_lama',
        'status_baru','catatan','user_id',
    ];

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}
