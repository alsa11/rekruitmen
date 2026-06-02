<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\AllSheetsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcel extends Command
{
    protected $signature = 'import:excel {file}';
    protected $description = 'Import Excel rekruitmen';

    public function handle()
    {
        ini_set('memory_limit', '2G');
        set_time_limit(0);

        $file = $this->argument('file');
        $this->info('Mulai import...');

        Excel::import(new AllSheetsImport(), $file);

        $this->info('JOIN: ' . \App\Models\Join::count());
        $this->info('Onboard: ' . \App\Models\Onboard::count());
        $this->info('Surat PG: ' . \App\Models\SuratPg::count());
        $this->info('OS: ' . \App\Models\Os::count());
        $this->info('SELESAI!');
    }
}
