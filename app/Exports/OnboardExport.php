<?php
namespace App\Exports;
use App\Models\Onboard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class OnboardExport implements FromCollection, WithHeadings
{
    public function collection() { return Onboard::all(); }
    public function headings(): array {
        return ['ID','Nama','NIK KTP','Onboarding Date','Join Date','Job Title','Level','Departemen','Divisi','Status','PIC'];
    }
}
