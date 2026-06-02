<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportJoin extends Command
{
    protected $signature = 'import:join';
    protected $description = 'Import sheet JOIN, OnBoard, Surat PG, OS';

    public function handle()
    {
        $file = storage_path('app/Draft Tracking rekrutmen 2026.xlsx');

        $this->info('Import JOIN...');
        Excel::import(new \App\Imports\JoinImport(), $file);
        $this->info('JOIN: ' . \App\Models\Join::count());

        $this->info('Import OnBoard Staff...');
        Excel::import(new \App\Imports\OnboardImport('staff'), $file);

        $this->info('Import OnBoard Operator...');
        Excel::import(new \App\Imports\OnboardImport('operator'), $file);
        $this->info('Onboard: ' . \App\Models\Onboard::count());

        $this->info('Import Surat PG...');
        Excel::import(new \App\Imports\SuratPgImport(), $file);
        $this->info('Surat PG: ' . \App\Models\SuratPg::count());

        $this->info('Import OS...');
        Excel::import(new \App\Imports\OsImport(), $file);
        $this->info('OS: ' . \App\Models\Os::count());

        $this->info('SELESAI!');
    }
}
