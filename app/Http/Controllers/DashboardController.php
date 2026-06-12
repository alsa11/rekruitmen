<?php
namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Join;
use App\Models\Onboard;
use App\Models\SuratPg;
use App\Models\Os;

class DashboardController extends Controller
{
    public function index()
    {
        $pics = ['Ghisna','Nisa','Wiwit'];

        $total    = Kandidat::count();
        $diterima = Kandidat::where('status_akhir','diterima')->count();
        $ditolak  = Kandidat::where('status_akhir','ditolak')->count();
        $proses   = Kandidat::where('status_akhir','proses')->count();

        $stats = [
            'total_kandidat' => $total,
            'diterima'       => $diterima,
            'ditolak'        => $ditolak,
            'proses'         => $proses,
            'konversi'       => $total > 0 ? round($diterima/$total*100,1) : 0,
            'join'           => Join::count(),
            'onboard_op'     => Onboard::where('level','operator')->count(),
            'onboard_staff'  => Onboard::where('level','staff')->count(),
            'onboard_bulan'  => Onboard::whereMonth('join_date', now()->month)->count(),
            'surat_pg'       => SuratPg::count(),
            'os_total'       => Os::count(),
        ];

        $funnel = [
            'interview_online'  => Kandidat::where('interview_online','hadir')->count(),
            'interview_offline' => Kandidat::where('interview_offline','hadir')->count(),
            'diterima'          => $diterima,
        ];

        $perPic = [];
        foreach ($pics as $pic) {
            $t = Kandidat::where('pic',$pic)->count();
            $d = Kandidat::where('pic',$pic)->where('status_akhir','diterima')->count();
            $perPic[$pic] = [
                'total'    => $t,
                'online'   => Kandidat::where('pic',$pic)->where('interview_online','hadir')->count(),
                'offline'  => Kandidat::where('pic',$pic)->where('interview_offline','hadir')->count(),
                'diterima' => $d,
                'ditolak'  => Kandidat::where('pic',$pic)->where('status_akhir','ditolak')->count(),
                'pct'      => $t > 0 ? round($d/$t*100,1) : 0,
            ];
        }

        $trendJoin = [];
        for ($i = 5; $i >= 0; $i--) {
            $bln = now()->subMonths($i);
            $trendJoin[] = [
                'label' => $bln->format('M Y'),
                'count' => Join::whereMonth('join_date',$bln->month)->whereYear('join_date',$bln->year)->count(),
            ];
        }

        $reminders = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(30)])
            ->orderBy('tgl_akhir_kontrak')->get();

        $reminderCount = $reminders->count();

        return view('dashboard', compact(
            'stats','funnel','pics','perPic','trendJoin','reminders','reminderCount'
        ));
    }
}
