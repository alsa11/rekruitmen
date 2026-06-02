<?php
namespace App\Exports;
use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class KandidatExport implements FromCollection, WithHeadings
{
    public function collection() { return Kandidat::all(); }
    public function headings(): array {
        return ['ID','Nama','No WA','Posisi','Departemen','Tgl Interview','PIC','CV Status','Interview Online','App Form','Interview Offline','Psikotest','Status Akhir','Tgl Join'];
    }
}
