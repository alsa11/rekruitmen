<?php
namespace App\Filament\Widgets;
use App\Models\Join;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KontrakWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $kritis = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(7)])->count();
        $segera = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(14)])->count();
        $total = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(30)])->count();

        return [
            Stat::make('Kontrak Kritis', $kritis)
                ->description('Habis < 7 hari')
                ->color('danger'),
            Stat::make('Segera Habis', $segera)
                ->description('Habis < 14 hari')
                ->color('warning'),
            Stat::make('Total Monitoring', $total)
                ->description('Habis < 30 hari')
                ->color('info'),
        ];
    }
}
