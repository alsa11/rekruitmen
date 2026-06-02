<?php
namespace App\Imports;
use App\Models\Onboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class OnboardImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'OnBoard Operator' => new OnboardSheetImport('operator'),
            'OnBoard Staff'    => new OnboardSheetImport('staff'),
        ];
    }
}

class OnboardSheetImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function __construct(private string $level) {}
    public function headingRow(): int { return 2; }

    public function model(array $row): ?Onboard
    {
        $nama = $row['applicant_name'] ?? null;
        if (!$nama) return null;
        return new Onboard([
            'nama'            => $nama,
            'nik_ktp'         => $row['applicant_nik_ktp'] ?? null,
            'onboarding_date' => $this->parseDate($row['onboarding_date'] ?? null),
            'join_date'       => $this->parseDate($row['join_date'] ?? null),
            'job_title'       => $row['job_title'] ?? null,
            'level'           => $this->level,
            'departemen'      => $row['department'] ?? null,
            'divisi'          => $row['division'] ?? null,
            'email'           => $row['email'] ?? null,
            'no_hp'           => $row['nohp'] ?? null,
            'status'          => $row['status'] ?? null,
            'pic'             => $row['pic'] ?? null,
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
