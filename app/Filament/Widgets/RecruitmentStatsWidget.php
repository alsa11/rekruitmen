<?php
namespace App\Filament\Widgets;
use App\Models\Kandidat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecruitmentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = Kandidat::count();
        $diterima = Kandidat::where('status_akhir','diterima')->count();
        $ditolak = Kandidat::where('status_akhir','ditolak')->count();
        $proses = Kandidat::where('status_akhir','proses')->count();
        $konversi = $total > 0 ? round($diterima/$total*100,1) : 0;

        return [
            Stat::make('Total Kandidat', number_format($total))
                ->description('Ghisna · Nisa · Wiwit')->color('gray'),
            Stat::make('Diterima', number_format($diterima))
                ->description('Konversi '.$konversi.'%')->color('success'),
            Stat::make('Ditolak / NG', number_format($ditolak))
                ->description('Rejection '.($total>0?round($ditolak/$total*100,1):0).'%')->color('danger'),
            Stat::make('Sedang Proses', number_format($proses))
                ->description('Dipertimbangkan: '.Kandidat::where('status_akhir','dipertimbangkan')->count())
                ->color('warning'),
        ];
    }
}
