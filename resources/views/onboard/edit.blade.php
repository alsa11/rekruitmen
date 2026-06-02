@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Edit Onboard — {{ $onboard->nama }}</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('onboard.update', $onboard) }}">
      @csrf @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required value="{{ $onboard->nama }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">NIK KTP</label><input name="nik_ktp" value="{{ $onboard->nik_ktp }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Job Title</label><input name="job_title" value="{{ $onboard->job_title }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Level</label>
          <select name="level" class="w-full border rounded-lg px-3 py-2 text-sm">
            <option value="staff" @selected($onboard->level=='staff')>Staff</option>
            <option value="operator" @selected($onboard->level=='operator')>Operator</option>
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Departemen</label><input name="departemen" value="{{ $onboard->departemen }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Divisi</label><input name="divisi" value="{{ $onboard->divisi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Onboarding Date</label><input type="date" name="onboarding_date" value="{{ $onboard->onboarding_date?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Join Date</label><input type="date" name="join_date" value="{{ $onboard->join_date?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Email</label><input name="email" value="{{ $onboard->email }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">No HP</label><input name="no_hp" value="{{ $onboard->no_hp }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Alamat</label><textarea name="alamat" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">{{ $onboard->alamat }}</textarea></div>
        <div><label class="block text-sm font-medium mb-1">Status Kontrak</label>
          <select name="status_kontrak" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['kontrak','tetap','magang'] as $s)<option value="{{ $s }}" @selected($onboard->status_kontrak==$s)>{{ ucfirst($s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Lama Kontrak</label><input name="lama_kontrak" value="{{ $onboard->lama_kontrak }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected($onboard->pic==$p)>{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Lokasi</label><input name="lokasi" value="{{ $onboard->lokasi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Status Makan</label><input name="status_makan" value="{{ $onboard->status_makan }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">{{ $onboard->keterangan }}</textarea></div>
      </div>
      <div class="flex justify-between mt-5">
        <div class="flex gap-3">
          <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Update</button>
          <a href="{{ route('onboard.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
        </div>
        <form method="POST" action="{{ route('onboard.destroy',$onboard) }}" onsubmit="return confirm('Hapus?')">
          @csrf @method('DELETE')
          <button class="bg-red-500 text-white px-6 py-2.5 rounded-lg text-sm">Hapus</button>
        </form>
      </div>
    </form>
  </div>
</div>
@endsection
