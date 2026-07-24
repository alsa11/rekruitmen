<?php
namespace App\Exports;
use App\Models\Onboard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OnboardExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() { return Onboard::all(); }
    public function headings(): array {
        return ['ID','Nama','NIK KTP','Onboarding Date','Join Date','Job Title','Level','Departemen','Divisi','Status','PIC'];
    }
    public function map($row): array {
        return [
            $row->id,
            $row->nama,
            $row->nik_ktp,
            $row->onboarding_date ? $row->onboarding_date->format('d/m/Y') : '',
            $row->join_date ? $row->join_date->format('d/m/Y') : '',
            $row->job_title,
            $row->level,
            $row->departemen,
            $row->divisi,
            $row->status ?? '',
            $row->pic ?? '',
        ];
    }
}
