<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TrackingJadwal extends Model
{
    protected $fillable = [
        'posisi','tanggal','jam','tipe_kegiatan',
        'sourcing','pic_hrd','link_gmeet','status',
    ];
    protected $casts = ['tanggal' => 'date'];
}
