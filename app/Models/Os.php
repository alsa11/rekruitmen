<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Os extends Model
{
    protected $table = 'os';
    protected $fillable = [
        'nama','posisi','posisi_group','divisi','placement',
        'qty','os_filled','keterangan','tgl_approval',
        'pic','status_akhir','tanggal_join',
    ];
    protected $casts = ['tgl_approval'=>'date','tanggal_join'=>'date'];
    public function getOutstandingAttribute(): int
    {
        return max(0, ($this->qty ?? 0) - ($this->os_filled ?? 0));
    }
}
