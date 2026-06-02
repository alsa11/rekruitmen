<?php
namespace App\Http\Controllers;
use App\Models\Kandidat;
use App\Models\Join;
use App\Models\Onboard;
use App\Models\SuratPg;
use App\Models\Os;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        $dariTgl = $request->dari_tgl ? Carbon::parse($request->dari_tgl)->startOfDay() : null;
        $sampaiTgl = $request->sampai_tgl ? Carbon::parse($request->sampai_tgl)->endOfDay() : null;
        $bulan = $request->bulan; // format: 2026-01
        $tahun = $request->tahun;

        // Base query dengan filter
        $base = Kandidat::query();
        if ($dariTgl && $sampaiTgl) {
            $base->whereBetween('created_at', [$dariTgl, $sampaiTgl]);
        } elseif ($bulan) {
            $base->whereYear('created_at', substr($bulan,0,4))
                 ->whereMonth('created_at', substr($bulan,5,2));
        } elseif ($tahun) {
            $base->whereYear('created_at', $tahun);
        }

        $total = (clone $base)->count();

        $funnel = [
            'screening'         => (clone $base)->whereNotNull('cv_link')->count(),
            'interview_online'  => (clone $base)->where('interview_online','hadir')->count(),
            'interview_offline' => (clone $base)->where('interview_offline','hadir')->count(),
            'diterima'          => (clone $base)->where('status_akhir','diterima')->count(),
            'dipertimbangkan'   => (clone $base)->where('status_akhir','dipertimbangkan')->count(),
            'ditolak'           => (clone $base)->where('status_akhir','ditolak')->count(),
            'mundur'            => (clone $base)->where('status_akhir','mundur')->count(),
        ];

        $pics = ['Ghisna','Nisa','Wiwit'];
        $perPic = [];
        foreach ($pics as $pic) {
            $q = (clone $base)->where('pic',$pic);
            $t = $q->count();
            $perPic[$pic] = [
                'total'    => $t,
                'screening'=> (clone $base)->where('pic',$pic)->whereNotNull('cv_link')->count(),
                'online'   => (clone $base)->where('pic',$pic)->where('interview_online','hadir')->count(),
                'offline'  => (clone $base)->where('pic',$pic)->where('interview_offline','hadir')->count(),
                'diterima' => (clone $base)->where('pic',$pic)->where('status_akhir','diterima')->count(),
                'ditolak'  => (clone $base)->where('pic',$pic)->where('status_akhir','ditolak')->count(),
                'proses'   => (clone $base)->where('pic',$pic)->where('status_akhir','proses')->count(),
                'pct'      => $t > 0 ? round((clone $base)->where('pic',$pic)->where('status_akhir','diterima')->count() / $t * 100, 1) : 0,
            ];
        }

        $reminders = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak', [now(), now()->addDays(60)])
            ->orderBy('tgl_akhir_kontrak')->get();
        $reminderCount = $reminders->count();

        // Trend 6 bulan
        $trendJoin = [];
        for ($i = 5; $i >= 0; $i--) {
            $bln = now()->subMonths($i);
            $trendJoin[] = [
                'label' => $bln->format('M Y'),
                'count' => Kandidat::where('status_akhir','diterima')
                    ->whereMonth('updated_at', $bln->month)
                    ->whereYear('updated_at', $bln->year)->count(),
            ];
        }

        $stats = [
            'total_kandidat' => $total,
            'join'           => Join::count(),
            'onboard_op'     => Onboard::where('level','operator')->count(),
            'onboard_staff'  => Onboard::where('level','staff')->count(),
            'surat_pg'       => SuratPg::count(),
            'onboard_bulan'  => Onboard::whereMonth('join_date', now()->month)->count(),
            'os_total'       => Os::count(),
            'proses'         => (clone $base)->where('status_akhir','proses')->count(),
            'diterima'       => $funnel['diterima'],
            'ditolak'        => $funnel['ditolak'],
            'konversi'       => $total > 0 ? round($funnel['diterima'] / $total * 100, 1) : 0,
        ];

        // Tahun tersedia untuk filter
        $tahunList = Kandidat::withoutGlobalScopes()
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()->orderBy('tahun','desc')
            ->pluck('tahun');

        return view('dashboard', compact(
            'funnel','perPic','reminders','reminderCount',
            'stats','pics','trendJoin','total',
            'dariTgl','sampaiTgl','bulan','tahun','tahunList'
        ));
    }
}
