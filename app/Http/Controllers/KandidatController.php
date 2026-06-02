<?php
namespace App\Http\Controllers;

use App\Imports\AllSheetsImport;
use App\Exports\KandidatExport;
use App\Models\Kandidat;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    public function index(Request $request)
    {
        $query = Kandidat::query()
            ->when($request->status_akhir, fn($q) => $q->where('status_akhir', $request->status_akhir))
            ->when($request->pic,          fn($q) => $q->where('pic', $request->pic))
            ->when($request->cari,         fn($q) => $q->where('nama','like',"%{$request->cari}%"))
            ->latest()->paginate(30)->withQueryString();

        $stats = [
            'total'           => Kandidat::count(),
            'proses'          => Kandidat::where('status_akhir','proses')->count(),
            'diterima'        => Kandidat::where('status_akhir','diterima')->count(),
            'ditolak'         => Kandidat::where('status_akhir','ditolak')->count(),
            'dipertimbangkan' => Kandidat::where('status_akhir','dipertimbangkan')->count(),
        ];

        return view('kandidat.index', compact('query','stats'));
    }

    public function show(Kandidat $kandidat)
    {
        return view('kandidat.show', compact('kandidat'));
    }

    public function importForm()
    {
        return view('kandidat.import');
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $request->validate(['file_excel' => 'required|mimes:xlsx,xls|max:20480']);

        $import = new AllSheetsImport();
        Excel::import($import, $request->file('file_excel'));

        $results = $import->getResults();
        $total   = array_sum($results);
        $detail  = collect($results)->map(fn($n,$s) => "$s: $n")->implode(' · ');

        return redirect()->route('kandidat.index')
            ->with('success', "Import selesai! $total kandidat · $detail");
    }

    public function export(Request $request)
    {
        ini_set('max_execution_time', 0);
        return Excel::download(
            new KandidatExport($request->status_akhir, $request->pic),
            'kandidat_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function updateStatus(Request $request, Kandidat $kandidat)
    {
        $data = $request->validate([
            'tahap'   => 'required|string',
            'status'  => 'required|string',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Field yang boleh diupdate langsung
        $allowedFields = [
            'cv_status','interview_online','app_form',
            'interview_offline','hasil_offline','psikotest',
            'status_akhir','tanggal_join',
        ];

        if (!in_array($data['tahap'], $allowedFields)) {
            return response()->json(['error' => 'Field tidak valid'], 422);
        }

        // Simpan riwayat (skip untuk cv_status karena bukan tahap utama)
        if ($data['tahap'] !== 'cv_status') {
            try {
                $kandidat->riwayat()->create([
                    'tahap'       => $data['tahap'],
                    'status_lama' => $kandidat->{$data['tahap']},
                    'status_baru' => $data['status'],
                    'catatan'     => $data['catatan'] ?? null,
                    'user_id'     => auth()->id(),
                ]);
            } catch (\Exception $e) {}
        }

        $kandidat->update([$data['tahap'] => $data['status']]);
        $kandidat->syncStatusAkhir();

        if ($request->wantsJson()) {
            return response()->json([
                'status_akhir' => $kandidat->fresh()->status_akhir,
                'message'      => 'Status berhasil diperbarui',
            ]);
        }

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function pipeline(Request $request, string $pic)
    {
        $kandidats = Kandidat::where('pic', $pic)
            ->when($request->status_akhir, fn($q) => $q->where('status_akhir', $request->status_akhir))
            ->when($request->cari, fn($q) => $q->where('nama','like',"%{$request->cari}%"))
            ->latest()->paginate(30)->withQueryString();

        $total = Kandidat::where('pic', $pic)->count();

        $stages = [
            'screening' => Kandidat::where('pic',$pic)->where(fn($q) => $q->whereNotNull('cv_link')->orWhere('cv_status','ada'))->count(),
            'online'    => Kandidat::where('pic',$pic)->where('interview_online','hadir')->count(),
            'appform'   => Kandidat::where('pic',$pic)->where('app_form','terkirim')->count(),
            'offline'   => Kandidat::where('pic',$pic)->where('interview_offline','hadir')->count(),
            'psikotest' => Kandidat::where('pic',$pic)->whereIn('psikotest',['ok','dipertimbangkan'])->count(),
            'diterima'  => Kandidat::where('pic',$pic)->where('status_akhir','diterima')->count(),
        ];

        return view('kandidat.pipeline', compact('kandidats','pic','total','stages'));
    }
}
