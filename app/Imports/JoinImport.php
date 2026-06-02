<?php
namespace App\Imports;
use App\Models\Join;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Carbon\Carbon;

class JoinImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return ['JOIN' => new JoinSheetImport()];
    }
}

class JoinSheetImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function headingRow(): int { return 2; }

    public function model(array $row): ?Join
    {
        $nama = $row['name'] ?? $row['nama'] ?? null;
        if (!$nama) return null;

        $joinDate = $this->parseDate($row['join_date'] ?? null);
        $statusRaw = strtolower($row['probation_kontrak'] ?? '');
        $akhir = null;

        // Hitung tgl_akhir_kontrak dari join_date + durasi
        if ($joinDate) {
            $dt = Carbon::parse($joinDate);
            if (str_contains($statusRaw, '3')) $akhir = (clone $dt)->addMonths(3)->format('Y-m-d');
            elseif (str_contains($statusRaw, '6')) $akhir = (clone $dt)->addMonths(6)->format('Y-m-d');
            elseif (str_contains($statusRaw, '12')) $akhir = (clone $dt)->addMonths(12)->format('Y-m-d');
            elseif (str_contains($statusRaw, 'probation')) $akhir = (clone $dt)->addMonths(3)->format('Y-m-d');
            elseif (str_contains($statusRaw, 'kontrak')) $akhir = (clone $dt)->addMonths(6)->format('Y-m-d');
        }

        // Normalize status_kontrak jadi enum-safe
        $status = null;
        if (str_contains($statusRaw, 'probation')) $status = 'probation';
        elseif (str_contains($statusRaw, 'kontrak')) $status = 'kontrak';
        elseif (str_contains($statusRaw, 'tetap')) $status = 'tetap';

        return new Join([
            'nama'              => substr($nama, 0, 255),
            'divisi'            => substr($row['division'] ?? '', 0, 255),
            'posisi'            => substr($row['position'] ?? '', 0, 255),
            'join_date'         => $joinDate,
            'user_pic'          => substr($row['user'] ?? '', 0, 255),
            'penempatan'        => substr($row['placement'] ?? '', 0, 255),
            'laptop_needs'      => $row['laptop_needs'] ?? null,
            'laptop_memo'       => substr($row['leptop_memo'] ?? '', 0, 255),
            'pic'               => substr($row['pic'] ?? '', 0, 255),
            'status_kontrak'    => $status,
            'tgl_akhir_kontrak' => $akhir,
            'rek_danamon'       => substr($row['rek_danamon'] ?? '', 0, 255),
        ]);
    }

    private function parseDate($val): ?string
    {
        if (!$val) return null;
        try {
            if (is_numeric($val)) return Carbon::createFromFormat('Y-m-d','1899-12-30')->addDays((int)$val)->format('Y-m-d');
            return Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }
}
