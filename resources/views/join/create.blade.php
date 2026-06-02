@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Tambah Data JOIN</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('join.store') }}">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Posisi *</label><input name="posisi" required class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Divisi</label><input name="divisi" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Join Date</label><input type="date" name="join_date" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Pilih --</option>
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">User / Atasan</label><input name="user_pic" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Penempatan</label><input name="penempatan" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Laptop Needs</label><input name="laptop_needs" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Laptop Memo</label><input name="laptop_memo" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Rek. Danamon</label><input name="rek_danamon" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Status Kontrak</label>
          <select name="status_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['probation','kontrak','tetap'] as $s)<option value="{{ $s }}">{{ ucfirst($s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Akhir Kontrak</label><input type="date" name="tgl_akhir_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Catatan</label><textarea name="catatan" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea></div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Simpan</button>
        <a href="{{ route('join.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
