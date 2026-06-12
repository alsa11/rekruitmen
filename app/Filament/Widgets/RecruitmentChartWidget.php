<?php
namespace App\Filament\Widgets;
use App\Models\Kandidat;
use Filament\Widgets\ChartWidget;

class RecruitmentChartWidget extends ChartWidget
{
    protected ?string $heading = 'Rekrutmen per Bulan (6 Bulan Terakhir)';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = [];
        $total = [];
        $diterima = [];
        $ditolak = [];

        for ($i = 5; $i >= 0; $i--) {
            $bln = now()->subMonths($i);
            $months[] = $bln->format('M Y');
            $total[] = Kandidat::whereMonth('created_at', $bln->month)->whereYear('created_at', $bln->year)->count();
            $diterima[] = Kandidat::where('status_akhir','diterima')->whereMonth('updated_at', $bln->month)->whereYear('updated_at', $bln->year)->count();
            $ditolak[] = Kandidat::where('status_akhir','ditolak')->whereMonth('updated_at', $bln->month)->whereYear('updated_at', $bln->year)->count();
        }

        return [
            'datasets' => [
                ['label'=>'Total','data'=>$total,'backgroundColor'=>'rgba(17,24,39,0.7)','borderRadius'=>4],
                ['label'=>'Diterima','data'=>$diterima,'backgroundColor'=>'rgba(22,163,74,0.7)','borderRadius'=>4],
                ['label'=>'Ditolak','data'=>$ditolak,'backgroundColor'=>'rgba(220,38,38,0.7)','borderRadius'=>4],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string { return 'bar'; }
}
