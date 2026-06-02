<?php
namespace App\Exports;
use App\Models\Join;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class JoinExport implements FromCollection, WithHeadings
{
    public function collection() { return Join::all(); }
    public function headings(): array {
        return ['ID','Nama','Divisi','Posisi','Join Date','PIC','Status Kontrak','Tgl Akhir Kontrak'];
    }
}
