@extends('layouts.app')
@section('content')

<div style="max-width:700px; margin:0 auto">
  <h2 style="font-size:1.4rem; font-weight:700; color:var(--text); margin-bottom:20px">Import & Export Data</h2>

  {{-- Import --}}
  <div style="background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:24px; margin-bottom:20px">
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px">
      <div style="width:32px; height:32px; background:#eff6ff; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px">↑</div>
      <div style="font-size:15px; font-weight:600; color:var(--text)">Import dari Excel</div>
    </div>
    <form method="POST" action="{{ route('kandidat.import.post') }}" enctype="multipart/form-data">
      @csrf
      <div style="margin-bottom:16px">
        <label style="display:block; font-size:13px; font-weight:500; color:var(--text); margin-bottom:6px">Jenis Data</label>
        <select name="jenis" style="width:100%; border:1px solid var(--border); border-radius:8px; padding:9px 14px; font-size:13px; background:var(--surface); color:var(--text)">
          <option value="kandidat">Kandidat (Sheet: Ghisna, Nisa, Wiwit)</option>
          <option value="join">Data JOIN</option>
          <option value="onboard">OnBoard (Operator & Staff)</option>
          <option value="os">Man Power OS</option>
          <option value="surat_pg">Surat PG</option>
        </select>
      </div>
      <div style="border:2px dashed var(--border); border-radius:10px; padding:28px; text-align:center; margin-bottom:16px">
        <div style="font-size:28px; margin-bottom:8px">📊</div>
        <div style="font-size:13px; color:var(--muted); margin-bottom:12px">Upload file Excel rekruitmen kamu</div>
        <input type="file" name="file_excel" accept=".xlsx,.xls" required
               style="display:block; margin:0 auto; font-size:13px">
        <div style="font-size:11px; color:var(--muted); margin-top:8px">Sheet yang akan diimport: Ghisna · Nisa · Wiwit</div>
      </div>
      <button type="submit" style="width:100%; background:#0f1117; color:white; padding:12px; border-radius:8px; font-size:14px; font-weight:600; border:none; cursor:pointer">
        📥 Import Sekarang
      </button>
    </form>
  </div>

  {{-- Export --}}
  <div style="background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:24px">
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px">
      <div style="width:32px; height:32px; background:#f0fdf4; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px">↓</div>
      <div style="font-size:15px; font-weight:600; color:var(--text)">Export ke Excel</div>
    </div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px">
      @foreach([
        ['Kandidat',     route('kandidat.export',['type'=>'kandidat'])],
        ['Data JOIN',    route('kandidat.export',['type'=>'join'])],
        ['OnBoard',      route('kandidat.export',['type'=>'onboard'])],
        ['Man Power OS', route('kandidat.export',['type'=>'os'])],
        ['Surat PG',     route('kandidat.export',['type'=>'surat_pg'])],
      ] as [$label,$url])
      <a href="{{ $url }}" style="display:flex; align-items:center; gap:8px; padding:12px 16px; border:1px solid var(--border); border-radius:8px; font-size:13px; font-weight:500; color:var(--text); text-decoration:none; background:var(--bg)">
        <span style="color:#16a34a; font-size:16px">↓</span> {{ $label }}
      </a>
      @endforeach
    </div>
  </div>

</div>
@endsection
