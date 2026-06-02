@extends('layouts.app')
@section('content')

<div class="flex justify-between items-center mb-4">
  <h2 class="text-xl font-bold">Pipeline Kandidat</h2>
  <a href="{{ route('kandidat.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm">+ Tambah Kandidat</a>
</div>

<div class="grid grid-cols-5 gap-3 mb-5">
  @foreach([
    'total'           => ['Total Kandidat',    'bg-slate-800'],
    'proses'          => ['Sedang Proses',      'bg-blue-600'],
    'diterima'        => ['Diterima',           'bg-emerald-600'],
    'ditolak'         => ['Ditolak',            'bg-red-500'],
    'dipertimbangkan' => ['Dipertimbangkan',    'bg-yellow-500'],
  ] as $k => $info)
  <div class="rounded-xl {{ $info[1] }} text-white p-4 text-center">
    <div class="text-3xl font-black">{{ $stats[$k] }}</div>
    <div class="text-xs opacity-80 mt-1">{{ $info[0] }}</div>
  </div>
  @endforeach
</div>

<div class="bg-white rounded-xl border p-4 mb-4">
  <form method="GET" class="flex gap-2 flex-wrap">
    <input name="cari" placeholder="🔍 Cari nama..." value="{{ request('cari') }}"
           class="border rounded-lg px-3 py-2 text-sm flex-1 min-w-40">
    <select name="pic" class="border rounded-lg px-3 py-2 text-sm">
      <option value="">Semua PIC</option>
      @foreach(['Ghisna','Nisa','Wiwit'] as $p)
        <option value="{{ $p }}" @selected(request('pic')==$p)>{{ $p }}</option>
      @endforeach
    </select>
    <select name="status_akhir" class="border rounded-lg px-3 py-2 text-sm">
      <option value="">Semua Status</option>
      @foreach(['proses','diterima','ditolak','dipertimbangkan','mundur','dialihkan'] as $s)
        <option value="{{ $s }}" @selected(request('status_akhir')==$s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
    <a href="{{ route('kandidat.export', request()->all()) }}"
       class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm"> Export</a>
  </form>
</div>

<div class="bg-white rounded-xl border overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-900 text-white">
      <tr>
        <th class="px-4 py-3 text-left">Nama</th>
        <th class="px-4 py-3 text-left">Posisi</th>
        <th class="px-4 py-3 text-left">PIC</th>
        <th class="px-4 py-3 text-left">Int. Online</th>
        <th class="px-4 py-3 text-left">Int. Offline</th>
        <th class="px-4 py-3 text-left">Hasil</th>
        <th class="px-4 py-3 text-left">Status</th>
        <th class="px-4 py-3 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($query as $k)
      <tr class="border-t hover:bg-slate-50">
        <td class="px-4 py-2.5 font-medium">{{ $k->nama }}</td>
        <td class="px-4 py-2.5 text-slate-500 text-xs">{{ $k->posisi }}</td>
        <td class="px-4 py-2.5 text-xs">{{ $k->pic }}</td>
        <td class="px-4 py-2.5">@include('kandidat._badge',['v'=>$k->interview_online])</td>
        <td class="px-4 py-2.5">@include('kandidat._badge',['v'=>$k->interview_offline])</td>
        <td class="px-4 py-2.5">@include('kandidat._badge',['v'=>$k->hasil_offline])</td>
        <td class="px-4 py-2.5">@include('kandidat._badge',['v'=>$k->status_akhir])</td>
        <td class="px-4 py-2.5">
          <div class="flex gap-2 justify-center">
            <a href="{{ route('kandidat.show',$k) }}"
               class="text-blue-600 hover:underline text-xs">Detail</a>
            <a href="{{ route('kandidat.edit',$k) }}"
               class="text-orange-500 hover:underline text-xs">Edit</a>
            <form method="POST" action="{{ route('kandidat.destroy',$k) }}"
                  onsubmit="return confirm('Hapus kandidat ini?')">
              @csrf @method('DELETE')
              <button class="text-red-500 hover:underline text-xs">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" class="text-center py-10 text-slate-400">
          Belum ada data. <a href="{{ route('kandidat.import') }}" class="text-blue-600 underline">
            Import Excel</a> atau <a href="{{ route('kandidat.create') }}" class="text-blue-600 underline">tambah manual</a>.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div class="p-4">{{ $query->links() }}</div>
</div>
@endsection