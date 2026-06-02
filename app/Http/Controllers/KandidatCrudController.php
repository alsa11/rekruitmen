<?php
namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;

class KandidatCrudController extends Controller
{
    public function create()
    {
        return view('kandidat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'              => 'required|string|max:255',
            'no_wa'             => 'nullable|string|max:20',
            'posisi'            => 'required|string|max:255',
            'pic'               => 'required|in:Ghisna,Nisa,Wiwit',
            'tanggal_interview' => 'nullable|date',
            'user_interviewer'  => 'nullable|string',
            'catatan'           => 'nullable|string',
        ]);
        Kandidat::create($data);
        return redirect()->route('kandidat.index')->with('success','Kandidat berhasil ditambahkan.');
    }

    public function edit(Kandidat $kandidat)
    {
        return view('kandidat.edit', compact('kandidat'));
    }

    public function update(Request $request, Kandidat $kandidat)
    {
        $data = $request->validate([
            'nama'              => 'required|string|max:255',
            'no_wa'             => 'nullable|string|max:20',
            'posisi'            => 'required|string|max:255',
            'pic'               => 'required|in:Ghisna,Nisa,Wiwit',
            'tanggal_interview' => 'nullable|date',
            'user_interviewer'  => 'nullable|string',
            'interview_online'  => 'nullable|string',
            'interview_offline' => 'nullable|string',
            'hasil_offline'     => 'nullable|string',
            'psikotest'         => 'nullable|string',
            'tanggal_join'      => 'nullable|date',
            'catatan'           => 'nullable|string',
        ]);
        $kandidat->update($data);
        $kandidat->syncStatusAkhir();
        return redirect()->route('kandidat.index')->with('success','Kandidat berhasil diupdate.');
    }

    public function destroy(Kandidat $kandidat)
    {
        $kandidat->delete();
        return redirect()->route('kandidat.index')->with('success','Kandidat berhasil dihapus.');
    }
}
