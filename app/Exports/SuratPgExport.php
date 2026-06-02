<?php
namespace App\Exports;
use App\Models\SuratPg;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SuratPgExport implements FromCollection, WithHeadings
{
    public function collection() { return SuratPg::all(); }
    public function headings(): array {
        return ['ID','Nomor Surat','Nama Karyawan','Departemen','Posisi','Tanggal Join','PIC','Status TTD','Keterangan'];
    }
}
