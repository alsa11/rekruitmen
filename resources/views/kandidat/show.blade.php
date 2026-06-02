@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">{{ $kandidat->nama }}</h2>
    <div class="flex gap-2">
      <a href="{{ route('kandidat.edit',$kandidat) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
      <a href="{{ route('kandidat.index') }}" class="border px-4 py-2 rounded-lg text-sm text-slate-600">Kembali</a>
    </div>
  </div>
  <div class="bg-white rounded-xl border p-6 space-y-4">
    <div class="grid grid-cols-2 gap-4 text-sm">
      <div><span class="text-slate-500">Posisi</span><div class="font-medium mt-1">{{ $kandidat->posisi }}</div></div>
      <div><span class="text-slate-500">PIC</span><div class="font-medium mt-1">{{ $kandidat->pic }}</div></div>
      <div><span class="text-slate-500">No WA</span><div class="font-medium mt-1">{{ $kandidat->no_wa ?: '-' }}</div></div>
      <div><span class="text-slate-500">Tgl Interview</span><div class="font-medium mt-1">{{ $kandidat->tanggal_interview?->format('d/m/Y') ?: '-' }}</div></div>
    </div>
    <hr>
    <div class="grid grid-cols-2 gap-4 text-sm">
      <div><span class="text-slate-500">Interview Online</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->interview_online])</div></div>
      <div><span class="text-slate-500">App Form</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->app_form])</div></div>
      <div><span class="text-slate-500">Interview Offline</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->interview_offline])</div></div>
      <div><span class="text-slate-500">Hasil Offline</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->hasil_offline])</div></div>
      <div><span class="text-slate-500">Psikotest</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->psikotest])</div></div>
      <div><span class="text-slate-500">Status Akhir</span><div class="mt-1">@include('kandidat._badge',['v'=>$kandidat->status_akhir])</div></div>
    </div>
    @if($kandidat->tanggal_join)
    <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-800">
      ✅ Join tanggal: <strong>{{ $kandidat->tanggal_join->format('d M Y') }}</strong>
    </div>
    @endif
    @if($kandidat->catatan)
    <div><span class="text-slate-500 text-sm">Catatan</span><p class="mt-1 text-sm">{{ $kandidat->catatan }}</p></div>
    @endif
  </div>
</div>
@endsection
