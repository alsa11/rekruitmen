<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Onboard extends Model
{
    protected $fillable = [
        'nama','nik_ktp','onboarding_date','join_date','job_title',
        'level','departemen','divisi','email','no_hp','alamat',
        'status_kontrak','lama_kontrak','pic','lokasi','status_makan','keterangan',
    ];
    protected $casts = [
        'onboarding_date' => 'date',
        'join_date' => 'date',
    ];
}
