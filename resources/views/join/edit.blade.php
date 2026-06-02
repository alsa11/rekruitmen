@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Edit JOIN — {{ $join->nama }}</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('join.update', $join) }}">
      @csrf @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required value="{{ $join->nama }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Posisi *</label><input name="posisi" required value="{{ $join->posisi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Divisi</label><input name="divisi" value="{{ $join->divisi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Join Date</label><input type="date" name="join_date" value="{{ $join->join_date?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Pilih --</option>
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected($join->pic==$p)>{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">User / Atasan</label><input name="user_pic" value="{{ $join->user_pic }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Penempatan</label><input name="penempatan" value="{{ $join->penempatan }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Laptop Needs</label><input name="laptop_needs" value="{{ $join->laptop_needs }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Laptop Memo</label><input name="laptop_memo" value="{{ $join->laptop_memo }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Rek. Danamon</label><input name="rek_danamon" value="{{ $join->rek_danamon }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Status Kontrak</label>
          <select name="status_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['probation','kontrak','tetap'] as $s)<option value="{{ $s }}" @selected($join->status_kontrak==$s)>{{ ucfirst($s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Akhir Kontrak</label><input type="date" name="tgl_akhir_kontrak" value="{{ $join->tgl_akhir_kontrak?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Catatan</label><textarea name="catatan" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">{{ $join->catatan }}</textarea></div>
      </div>
      <div class="flex justify-between mt-5">
        <div class="flex gap-3">
          <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Update</button>
          <a href="{{ route('join.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
        </div>
        <form method="POST" action="{{ route('join.destroy',$join) }}" onsubmit="return confirm('Hapus?')">
          @csrf @method('DELETE')
          <button class="bg-red-500 text-white px-6 py-2.5 rounded-lg text-sm">Hapus</button>
        </form>
      </div>
    </form>
  </div>
</div>
@endsection
