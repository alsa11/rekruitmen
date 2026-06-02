<?php
namespace App\Imports;
use App\Models\SuratPg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SuratPgImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function headingRow(): int { return 5; }

    public function model(array $row): ?SuratPg
    {
        $nama = trim($row['nama_karyawan'] ?? '');
        if (empty($nama) || is_numeric($nama)) return null;
        return new SuratPg([
            'nomor_surat'   => $row['nomor_surat'] ?? null,
            'nama_karyawan' => $nama,
            'departemen'    => $row['departemen'] ?? null,
            'posisi'        => $row['posisi'] ?? null,
            'tanggal_join'  => $this->parseDate($row['tanggal_join'] ?? null),
            'pic'           => $row['pic'] ?? null,
            'status_ttd'    => str_contains(strtolower($row['ttd'] ?? ''), 'approval') ? 'sudah' : 'belum',
            'keterangan'    => $row['keterangan'] ?? null,
        ]);
    }

    private function parseDate(mixed $v): ?string
    {
        if (empty($v)) return null;
        try {
            if (is_numeric($v)) return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$v))->format('Y-m-d');
            return \Carbon\Carbon::parse($v)->format('Y-m-d');
        } catch (\Exception) { return null; }
    }
}
