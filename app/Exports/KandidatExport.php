<?php
namespace App\Exports;
use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class KandidatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() { return Kandidat::all(); }
    public function headings(): array {
        return ['ID','Nama','No WA','Posisi','Departemen','Tgl Interview','PIC','CV Status','Interview Online','App Form','Interview Offline','Psikotest','Status Akhir','Tgl Join'];
    }
    public function map($row): array {
        return [
            $row->id,
            $row->nama,
            $row->no_wa,
            $row->posisi,
            $row->departemen,
            $row->tanggal_interview ? $row->tanggal_interview->format('d/m/Y') : '',
            $row->pic,
            $row->cv_file ? 'Ada' : '-',
            $row->interview_online,
            $row->app_form,
            $row->interview_offline,
            $row->psikotest,
            $row->status_akhir,
            $row->tanggal_join ? $row->tanggal_join->format('d/m/Y') : '',
        ];
    }
}
