<?php
namespace App\Imports;
use App\Models\Os;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class OsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return ['OS' => new OsSheetImport()];
    }
}

class OsSheetImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function headingRow(): int { return 2; }

    public function model(array $row): ?Os
    {
        $nama = $row['name'] ?? null;
        if (!$nama || $nama === '-') return null;

        $joinRaw = $row['joined'] ?? null;
        $joinDate = null;
        $statusAkhir = 'diterima';

        if ($joinRaw) {
            if (str_contains(strtoupper((string)$joinRaw), 'KELUAR')) {
                $statusAkhir = 'diterima'; // keluar
                $joinRaw = str_replace([' KELUAR','KELUAR'], '', $joinRaw);
            }
            try {
                if (is_numeric($joinRaw)) {
                    $joinDate = Carbon::createFromFormat('Y-m-d','1899-12-30')->addDays((int)$joinRaw)->format('Y-m-d');
                } else {
                    $joinDate = Carbon::parse(trim($joinRaw))->format('Y-m-d');
                }
            } catch (\Exception $e) {}
        }

        return new Os([
            'nama'         => $nama,
            'posisi'       => $row['position'] ?? null,
            'placement'    => $row['placement'] ?? null,
            'qty'          => is_numeric($row['qty'] ?? null) ? (int)$row['qty'] : null,
            'pic'          => $row['pic'] ?? null,
            'tanggal_join' => $joinDate,
            'keterangan'   => $row['keterangan'] ?? null,
            'status_akhir' => $statusAkhir,
        ]);
    }
}
