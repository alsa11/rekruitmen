<?php
namespace App\Exports;
use App\Models\Os;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() { return Os::all(); }
    public function headings(): array {
        return ['ID','Posisi','Placement','Qty','OS','Nama','PIC','Keterangan','Tgl Join','Status'];
    }
    public function map($row): array {
        return [
            $row->id,
            $row->posisi,
            $row->placement,
            $row->qty,
            $row->os_filled,
            $row->nama,
            $row->pic,
            $row->keterangan,
            $row->tanggal_join ? $row->tanggal_join->format('d/m/Y') : '',
            $row->status_akhir,
        ];
    }
}
