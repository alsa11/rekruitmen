<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Os extends Model
{
    protected $table = 'os';
    protected $fillable = [
        'nama','no_wa','posisi','pic',
        'interview_online','ket_interview_online',
        'interview_offline','hasil','ket_hasil',
        'status_akhir','placement','qty','keterangan','tgl_approval','tanggal_join',
    ];
    protected $casts = ['tanggal_join' => 'date'];
}