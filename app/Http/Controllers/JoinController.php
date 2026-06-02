<?php
namespace App\Http\Controllers;
use App\Models\Join;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort ?? 'created_at';
        $query = Join::query()
            ->when($request->pic,            fn($q) => $q->where('pic', $request->pic))
            ->when($request->status_kontrak, fn($q) => $q->where('status_kontrak', $request->status_kontrak))
            ->when($request->cari,           fn($q) => $q->where('nama','like',"%{$request->cari}%"))
            ->when($request->reminder,       fn($q) => $q->whereNotNull('tgl_akhir_kontrak')
                ->whereBetween('tgl_akhir_kontrak',[now(), now()->addDays((int)$request->reminder)]))
            ->orderBy($sort, $sort=='nama' ? 'asc' : 'desc')
            ->paginate(25)->withQueryString();

        $reminders = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak',[now(), now()->addDays(30)])
            ->orderBy('tgl_akhir_kontrak')->get();

        return view('join.index', compact('query','reminders'));
    }

    public function create() { return view('join.create'); }

    public function store(Request $request)
    {
        $request->validate(['nama'=>'required','posisi'=>'required']);
        Join::create($request->all());
        return redirect()->route('join.index')->with('success','Data join berhasil ditambah.');
    }

    public function edit(Join $join) { return view('join.edit', compact('join')); }

    public function update(Request $request, Join $join)
    {
        $join->update($request->all());
        return redirect()->route('join.index')->with('success','Data join diupdate.');
    }

    public function destroy(Join $join)
    {
        $join->delete();
        return back()->with('success','Data join dihapus.');
    }

    public function reminder(Request $request)
    {
        $hari = (int)($request->hari ?? 60);
        $reminders = Join::whereNotNull('tgl_akhir_kontrak')
            ->whereBetween('tgl_akhir_kontrak', [now(), now()->addDays($hari)])
            ->orderBy('tgl_akhir_kontrak')->get();
        return view('join.reminder', compact('reminders','hari'));
    }
}
