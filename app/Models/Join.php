<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Join extends Model
{
    protected $table = "joins";
    protected $fillable = [
        "nama","divisi","posisi","join_date","user_pic",
        "penempatan","laptop_needs","laptop_memo","rek_danamon",
        "status_kontrak","tgl_akhir_kontrak","pic","catatan",
    ];
    protected $casts = [
        "join_date" => "date",
        "tgl_akhir_kontrak" => "date",
    ];
    public function getHariKontrakAttribute(): ?int
    {
        return $this->tgl_akhir_kontrak ? (int)now()->diffInDays($this->tgl_akhir_kontrak, false) : null;
    }
    protected static function booted(): void
    {
        static::retrieved(function ($join) {
            if ($join->tgl_akhir_kontrak && $join->tgl_akhir_kontrak < now() && $join->status_kontrak !== "selesai") {
                $join->updateQuietly(["status_kontrak" => "selesai"]);
            }
        });
    }
}