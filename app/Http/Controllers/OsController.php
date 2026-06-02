<?php

namespace App\Http\Controllers;

use App\Models\Os;
use Illuminate\Http\Request;

class OsController extends Controller
{
    public function index(Request $request)
    {
        $query = Os::query()
            ->when($request->pic,          fn($q) => $q->where('pic',$request->pic))
            ->when($request->status_akhir, fn($q) => $q->where('status_akhir',$request->status_akhir))
            ->when($request->cari,         fn($q) => $q->where('nama','like',"%{$request->cari}%"))
            ->latest()->paginate(25)->withQueryString();

        $stats = [
            'total'    => Os::count(),
            'ghisna'   => Os::where('pic','Ghisna')->count(),
            'nisa'     => Os::where('pic','Nisa')->count(),
            'wiwit'    => Os::where('pic','Wiwit')->count(),
            'diterima' => Os::where('status_akhir','diterima')->count(),
        ];

        return view('os.index', compact('query','stats'));
    }

    public function create() { return view('os.create'); }

    public function store(Request $request)
    {
        $request->validate(['nama'=>'required','posisi'=>'required']);
        Os::create($request->all());
        return redirect()->route('os.index')->with('success','Data OS ditambah.');
    }

    public function edit(Os $os) { return view('os.edit', compact('os')); }

    public function update(Request $request, Os $os)
    {
        $os->update($request->all());
        return redirect()->route('os.index')->with('success','Data OS diupdate.');
    }

    public function destroy(Os $os)
    {
        $os->delete();
        return back()->with('success','Data OS dihapus.');
    }
}
