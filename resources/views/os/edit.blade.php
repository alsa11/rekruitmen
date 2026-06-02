@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Edit Data OS — {{ $os->nama }}</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('os.update', $os) }}">
      @csrf @method('PUT')
      <div class="space-y-3">
        <div><label class="block text-sm font-medium mb-1">Nama *</label><input name="nama" required value="{{ $os->nama }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">No WA</label><input name="no_wa" value="{{ $os->no_wa }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Posisi *</label><input name="posisi" required value="{{ $os->posisi }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">PIC</label>
          <select name="pic" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected($os->pic==$p)>{{ $p }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Interview Online</label>
          <select name="interview_online" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','hadir','tidak_hadir','reschedule'] as $s)<option value="{{ $s }}" @selected($os->interview_online==$s)>{{ str_replace('_',' ',$s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Interview Offline</label>
          <select name="interview_offline" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','hadir','tidak_hadir','reschedule'] as $s)<option value="{{ $s }}" @selected($os->interview_offline==$s)>{{ str_replace('_',' ',$s) }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Hasil</label>
          <select name="hasil" class="w-full border rounded-lg px-3 py-2 text-sm">
            @foreach(['belum','ok','ng','dipertimbangkan'] as $s)<option value="{{ $s }}" @selected($os->hasil==$s)>{{ $s }}</option>@endforeach
          </select>
        </div>
        <div><label class="block text-sm font-medium mb-1">Tanggal Join</label><input type="date" name="tanggal_join" value="{{ $os->tanggal_join?->format('Y-m-d') }}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm">Update</button>
        <a href="{{ route('os.index') }}" class="border px-6 py-2.5 rounded-lg text-sm text-slate-600">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
