<?php
namespace App\Http\Controllers;
use App\Imports\KandidatImport;
use App\Imports\JoinImport;
use App\Imports\SuratPgImport;
use App\Imports\OnboardImport;
use App\Imports\OsImport;
use App\Exports\KandidatExport;
use App\Exports\JoinExport;
use App\Exports\OnboardExport;
use App\Exports\OsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index() { return view('import.index'); }

    public function import(Request $request)
    {
        $request->validate(['file'=>'required|mimes:xlsx,xls','type'=>'required']);
        try {
            match($request->type) {
                'kandidat' => Excel::import(new KandidatImport, $request->file('file')),
                'join'     => Excel::import(new JoinImport,     $request->file('file')),
                'surat_pg' => Excel::import(new SuratPgImport,  $request->file('file')),
                'onboard'  => Excel::import(new OnboardImport,  $request->file('file')),
                'os'       => Excel::import(new OsImport,       $request->file('file')),
            };
            return back()->with('success', 'Import berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import gagal: '.$e->getMessage());
        }
    }

    public function export(string $type)
    {
        return match($type) {
            'kandidat' => Excel::download(new KandidatExport, 'kandidat.xlsx'),
            'join'     => Excel::download(new JoinExport,     'join.xlsx'),
            'onboard'  => Excel::download(new OnboardExport,  'onboard.xlsx'),
            'os'       => Excel::download(new OsExport,       'os.xlsx'),
            'surat_pg' => Excel::download(new \App\Exports\SuratPgExport, 'surat_pg.xlsx'),
            default    => back(),
        };
    }
}
