<?php
namespace App\Exports;
use App\Models\Join;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class JoinExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() { return Join::all(); }
    public function headings(): array {
        return ['ID','Nama','Divisi','Posisi','Join Date','PIC','Status Kontrak','Tgl Akhir Kontrak'];
    }
    public function map($row): array {
        return [
            $row->id,
            $row->nama,
            $row->divisi,
            $row->posisi,
            $row->join_date ? $row->join_date->format('d/m/Y') : '',
            $row->pic,
            $row->status_kontrak,
            $row->tgl_akhir_kontrak ? $row->tgl_akhir_kontrak->format('d/m/Y') : '',
        ];
    }
}
