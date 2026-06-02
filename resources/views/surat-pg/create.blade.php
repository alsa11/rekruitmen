@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Tambah Surat PG</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('surat-pg.store') }}">
      @csrf
      <div class="space-y-3">
        <div><label class="block text-sm font-medium mb-1">Nomor Surat</label><input name="nomor_surat" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Nama Karyawan *</label><input name="nama_karyawan" required class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Posisi</label><input name="posisi" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Departemen</label><input name="departemen" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Tanggal Join</label><input type="date" name="tanggal_join" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Pilih --</option>
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Status TTD</label>
          <select name="status_ttd" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="belum">Belum</option>
            <option value="sudah">Sudah</option>
          </select>
        </div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Simpan</button>
        <a href="{{ route('surat-pg.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
