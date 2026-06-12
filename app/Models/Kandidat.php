<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Join;

class Kandidat extends Model
{
    protected $fillable = [
        'nama','no_wa','posisi','departemen','tanggal_interview',
        'jam_interview','pic','user_interviewer','cv_link','cv_file','cv_status',
        'interview_online','ket_interview_online',
        'app_form','ket_app_form',
        'interview_offline','hasil_offline','ket_offline',
        'psikotest','ket_psikotest',
        'status_akhir','tanggal_join','catatan','cv_file','app_form_file','sumber_sheet',
    ];

    protected $casts = [
        'tanggal_interview' => 'date',
        'tanggal_join'      => 'date',
    ];

    // Auto sembunyikan kandidat ditolak > 90 hari
    protected static function booted(): void
    {
        static::addGlobalScope('hide_old_rejected', function (Builder $q) {
            $q->where(function ($q) {
                $q->where('status_akhir', '!=', 'ditolak')
                  ->orWhere('updated_at', '>=', now()->subDays(90));
            });
        });
    }

    public function syncStatusAkhir(): void
    {
        $status = match(true) {
            !empty($this->tanggal_join)
                => 'diterima',
            in_array($this->hasil_offline, ['ng']) || in_array($this->psikotest, ['ng'])
                => 'ditolak',
            $this->hasil_offline === 'dipertimbangkan' || $this->psikotest === 'dipertimbangkan'
                => 'dipertimbangkan',
            $this->psikotest === 'mundur' ||
            $this->hasil_offline === 'mundur' ||
            $this->app_form === 'mundur' ||
            $this->interview_online === 'tidak_hadir'
                => 'mundur',
            default => 'proses',
        };

        $this->update(['status_akhir' => $status]);

        if ($status === 'diterima' && $this->tanggal_join) {
            Join::updateOrCreate(
                ['nama' => $this->nama],
                [
                    'posisi'         => $this->posisi,
                    'join_date'      => $this->tanggal_join,
                    'pic'            => $this->pic,
                    'user_pic'       => $this->user_interviewer,
                    'status_kontrak' => 'probation',
                ]
            );
        }
    }
}
