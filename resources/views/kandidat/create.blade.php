@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Tambah Kandidat</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('kandidat.store') }}">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap *</label>
          <input name="nama" required value="{{ old('nama') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">No WA</label>
          <input name="no_wa" value="{{ old('no_wa') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Posisi *</label>
          <input name="posisi" required value="{{ old('posisi') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">PIC *</label>
          <select name="pic" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="">-- Pilih PIC --</option>
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)
            <option value="{{ $p }}" @selected(old('pic')==$p)>{{ $p }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Interview</label>
          <input type="date" name="tanggal_interview" value="{{ old('tanggal_interview') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">User Interviewer</label>
          <input name="user_interviewer" value="{{ old('user_interviewer') }}" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Bu Sum, Pak Purwanto...">
        </div>
        <div class="col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
          <textarea name="catatan" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('catatan') }}</textarea>
        </div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm font-medium">Simpan</button>
        <a href="{{ route('kandidat.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
