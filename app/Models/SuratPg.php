<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SuratPg extends Model
{
    protected $fillable = [
        'nomor_surat','nama_karyawan','departemen','posisi',
        'tanggal_join','pic','status_ttd','keterangan','gaji_penawaran',
    ];
    protected $casts = ['tanggal_join' => 'date'];
}