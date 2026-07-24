<?php
namespace App\Exports;
use App\Models\SuratPg;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class SuratPgExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() { return SuratPg::all(); }
    public function headings(): array {
        return ['ID','Nomor Surat','Nama Karyawan','Departemen','Posisi','Tanggal Join','PIC','Status TTD','Keterangan'];
    }
    public function map($row): array {
        return [
            $row->id,
            $row->nomor_surat,
            $row->nama_karyawan,
            $row->departemen ?? '',
            $row->posisi,
            $row->tanggal_join ? $row->tanggal_join->format('d/m/Y') : '',
            $row->pic,
            $row->status_ttd,
            $row->keterangan ?? '',
        ];
    }
}
