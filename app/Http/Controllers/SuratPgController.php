<?php
namespace App\Http\Controllers;
use App\Models\SuratPg;
use Illuminate\Http\Request;

class SuratPgController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratPg::query()
            ->when($request->cari,       fn($q) => $q->where('nama_karyawan','like',"%{$request->cari}%"))
            ->when($request->pic,        fn($q) => $q->where('pic',$request->pic))
            ->when($request->status_ttd, fn($q) => $q->where('status_ttd',$request->status_ttd))
            ->latest()->paginate(25)->withQueryString();
        return view('surat-pg.index', compact('query'));
    }

    public function create() { return view('surat-pg.create'); }

    public function store(Request $request)
    {
        $request->validate(['nama_karyawan'=>'required']);
        SuratPg::create($request->all());
        return redirect()->route('surat-pg.index')->with('success','Surat PG ditambah.');
    }

    public function edit(SuratPg $suratPg) { return view('surat-pg.edit', compact('suratPg')); }

    public function update(Request $request, SuratPg $suratPg)
    {
        $suratPg->update($request->all());
        return redirect()->route('surat-pg.index')->with('success','Surat PG diupdate.');
    }

    public function destroy(SuratPg $suratPg)
    {
        $suratPg->delete();
        return back()->with('success','Surat PG dihapus.');
    }
}