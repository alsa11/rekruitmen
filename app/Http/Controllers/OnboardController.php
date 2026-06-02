<?php
namespace App\Http\Controllers;
use App\Models\Onboard;
use Illuminate\Http\Request;

class OnboardController extends Controller
{
    public function index(Request $request)
    {
        $level = $request->level ?? 'staff';
        $sort  = $request->sort ?? 'created_at';
        $query = Onboard::where('level',$level)
            ->when($request->pic,        fn($q) => $q->where('pic',$request->pic))
            ->when($request->departemen, fn($q) => $q->where('departemen',$request->departemen))
            ->when($request->cari,       fn($q) => $q->where('nama','like',"%{$request->cari}%"))
            ->orderBy($sort, $sort=='nama'||$sort=='departemen' ? 'asc' : 'desc')
            ->paginate(25)->withQueryString();
        return view('onboard.index', compact('query','level'));
    }

    public function create() { return view('onboard.create'); }
    public function store(Request $request)
    {
        $request->validate(['nama'=>'required']);
        Onboard::create($request->all());
        return redirect()->route('onboard.index')->with('success','Data onboard ditambah.');
    }
    public function edit(Onboard $onboard) { return view('onboard.edit', compact('onboard')); }
    public function update(Request $request, Onboard $onboard)
    {
        $onboard->update($request->all());
        return redirect()->route('onboard.index')->with('success','Data onboard diupdate.');
    }
    public function destroy(Onboard $onboard)
    {
        $onboard->delete();
        return back()->with('success','Data onboard dihapus.');
    }
}
