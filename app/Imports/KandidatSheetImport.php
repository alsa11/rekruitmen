<?php
namespace App\Imports;

use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class KandidatSheetImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithChunkReading
{
    private string $sheetName;
    private array $results;

    public function __construct(string $sheetName, array &$results)
    {
        $this->sheetName = $sheetName;
        $this->results = &$results;
    }

    public function model(array $row): ?Kandidat
    {
        $nama = trim($row['nama'] ?? '');
        if (empty($nama) || is_numeric($nama)) return null;

        $this->results[$this->sheetName] = ($this->results[$this->sheetName] ?? 0) + 1;

        $hasilOff  = $this->normalizeHasil($row['keterangan_3'] ?? null);
        $psikotest = $this->normalizeHasil($row['psikotest'] ?? null);
        $joinDate  = $this->parseDate($row['join'] ?? null);

        Kandidat::updateOrCreate(
            [
                'nama'  => $nama,
                'no_wa' => (string)($row['wa'] ?? ''),
            ],
            [
                'posisi'               => $row['posisi'] ?? '',
                'tanggal_interview'    => $this->parseDate($row['tanggal'] ?? null),
                'jam_interview'        => $row['jam'] ?? null,
                'cv_link'              => $row['resume_cv'] ?? $row['cv'] ?? null,
                'interview_online'     => $this->normalizeOnline($row['interview_online'] ?? null),
                'ket_interview_online' => $row['keterangan'] ?? null,
                'app_form'             => $this->normalizeAppForm($row['application_form'] ?? null),
                'ket_app_form'         => $row['keterangan_2'] ?? null,
                'interview_offline'    => $this->normalizeOffline($row['interview_offline'] ?? $row['interview_offline_0'] ?? null),
                'hasil_offline'        => $hasilOff,
                'ket_offline'          => $row['keterangan_3'] ?? null,
                'psikotest'            => $psikotest,
                'ket_psikotest'        => $row['keterangan_4'] ?? null,
                'user_interviewer'     => $row['user'] ?? null,
                'tanggal_join'         => $joinDate,
                'status_akhir'         => $this->deriveStatus($joinDate, $hasilOff, $psikotest),
                'pic'                  => $this->sheetName,
                'sumber_sheet'         => $this->sheetName,
            ]
        );

        return null;
    }

    private function normalizeOnline(?string $v): string
    {
        $v = strtolower(trim((string)$v));
        return match(true) {
            str_contains($v,'tidak hadir') => 'tidak_hadir',
            str_contains($v,'hadir')       => 'hadir',
            str_contains($v,'reschedule'), str_contains($v,'reschadul') => 'reschedule',
            str_contains($v,'proses')      => 'sudah_dalam_proses',
            str_contains($v,'belum lolos') => 'belum_lolos',
            default                        => 'belum',
        };
    }

    private function normalizeOffline(?string $v): string
    {
        $v = strtolower(trim((string)$v));
        return match(true) {
            str_contains($v,'tidak hadir') => 'tidak_hadir',
            str_contains($v,'hadir')       => 'hadir',
            str_contains($v,'reschedule')  => 'reschedule',
            str_contains($v,'respon')      => 'tidak_respon',
            default                        => 'belum',
        };
    }

    private function normalizeHasil(?string $v): string
    {
        $v = strtolower(trim((string)$v));
        return match(true) {
            str_contains($v,'dipertimb')        => 'dipertimbangkan',
            $v==='ok', str_contains($v,'lolos') => 'ok',
            $v==='ng', str_contains($v,'not ok'), str_contains($v,'nok') => 'ng',
            str_contains($v,'mundur')           => 'mundur',
            default                             => 'belum',
        };
    }

    private function normalizeAppForm(?string $v): string
    {
        $v = strtolower(trim((string)$v));
        return match(true) {
            str_contains($v,'terkirim'), str_contains($v,'kirim') => 'terkirim',
            str_contains($v,'offline')  => 'lanjut_offline',
            str_contains($v,'user')     => 'lanjut_user',
            str_contains($v,'alih')     => 'dialihkan',
            str_contains($v,'mundur')   => 'mundur',
            default                     => 'belum',
        };
    }

    private function deriveStatus(?string $join, string $hasil, string $psiko): string
    {
        if ($join) return 'diterima';
        if (in_array($hasil,['ng']) || in_array($psiko,['ng'])) return 'ditolak';
        if ($hasil==='dipertimbangkan' || $psiko==='dipertimbangkan') return 'dipertimbangkan';
        if ($hasil==='mundur' || $psiko==='mundur') return 'mundur';
        return 'proses';
    }

    private function parseDate(mixed $v): ?string
    {
        if (empty($v)) return null;
        try {
            if (is_numeric($v)) {
                return \Carbon\Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$v)
                )->format('Y-m-d');
            }
            return \Carbon\Carbon::parse($v)->format('Y-m-d');
        } catch (\Exception) { return null; }
    }

    public function chunkSize(): int { return 200; }
}