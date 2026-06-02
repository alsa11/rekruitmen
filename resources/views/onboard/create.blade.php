@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Tambah Data Onboard</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('onboard.store') }}">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">NIK KTP</label><input name="nik_ktp" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Job Title</label><input name="job_title" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Level</label>
          <select name="level" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="staff">Staff</option><option value="operator">Operator</option>
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Departemen</label><input name="departemen" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Divisi</label><input name="divisi" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Onboarding Date</label><input type="date" name="onboarding_date" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Join Date</label><input type="date" name="join_date" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Email</label><input name="email" type="email" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">No HP</label><input name="no_hp" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Alamat</label><textarea name="alamat" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea></div>
        <div><label class="block text-sm font-medium mb-1">Status Kontrak</label>
          <select name="status_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['kontrak','tetap','magang'] as $s)<option value="{{ $s }}">{{ ucfirst($s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Lama Kontrak</label><input name="lama_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="6 BULAN"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Lokasi</label><input name="lokasi" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Status Makan</label><input name="status_makan" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="MAKAN DALAM / UANG MAKAN"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea></div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Simpan</button>
        <a href="{{ route('onboard.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
