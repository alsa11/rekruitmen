@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Edit Kandidat — {{ $kandidat->nama }}</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('kandidat.update', $kandidat) }}">
      @csrf @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required value="{{ $kandidat->nama }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">No WA</label><input name="no_wa" value="{{ $kandidat->no_wa }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Posisi *</label><input name="posisi" required value="{{ $kandidat->posisi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected($kandidat->pic==$p)>{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Tgl Interview</label><input type="date" name="tanggal_interview" value="{{ $kandidat->tanggal_interview?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">User Interviewer</label><input name="user_interviewer" value="{{ $kandidat->user_interviewer }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Interview Online</label>
          <select name="interview_online" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','hadir','tidak_hadir','reschedule','sudah_dalam_proses','belum_lolos'] as $s)
            <option value="{{ $s }}" @selected($kandidat->interview_online==$s)>{{ str_replace('_',' ',$s) }}</option>
            @endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">App Form</label>
          <select name="app_form" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','terkirim','lanjut_offline','lanjut_user','dialihkan','mundur'] as $s)
            <option value="{{ $s }}" @selected($kandidat->app_form==$s)>{{ str_replace('_',' ',$s) }}</option>
            @endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Interview Offline</label>
          <select name="interview_offline" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','hadir','tidak_hadir','reschedule','tidak_respon'] as $s)
            <option value="{{ $s }}" @selected($kandidat->interview_offline==$s)>{{ str_replace('_',' ',$s) }}</option>
            @endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Hasil Offline</label>
          <select name="hasil_offline" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','ok','ng','dipertimbangkan'] as $s)
            <option value="{{ $s }}" @selected($kandidat->hasil_offline==$s)>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Psikotest</label>
          <select name="psikotest" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','ok','ng','dipertimbangkan','mundur'] as $s)
            <option value="{{ $s }}" @selected($kandidat->psikotest==$s)>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Tanggal Join</label><input type="date" name="tanggal_join" value="{{ $kandidat->tanggal_join?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div class="col-span-2"><label class="block text-sm font-medium mb-1">Catatan</label><textarea name="catatan" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ $kandidat->catatan }}</textarea></div>
      </div>
      <div class="flex justify-between mt-5">
        <div class="flex gap-3">
          <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Update</button>
          <a href="{{ route('kandidat.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
        </div>
        {{-- Form hapus terpisah dengan route yang benar --}}
        <form method="POST" action="{{ route('kandidat.destroy', $kandidat) }}"
              onsubmit="return confirm('Hapus kandidat {{ $kandidat->nama }}?')">
          @csrf @method('DELETE')
          <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-lg text-sm hover:bg-red-600">Hapus</button>
        </form>
      </div>
    </form>
  </div>
</div>
@endsection
