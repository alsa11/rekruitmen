<?php
namespace App\Exports;
use App\Models\Os;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class OsExport implements FromCollection, WithHeadings
{
    public function collection() { return Os::all(); }
    public function headings(): array {
        return ['ID','Nama','Posisi','PIC','Status'];
    }
}
