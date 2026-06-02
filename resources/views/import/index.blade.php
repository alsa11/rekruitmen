@extends('layouts.app')
@section('content')
<style>
.imp-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px}
.imp-label{font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px}
.imp-select{width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;font-family:inherit;margin-bottom:16px}
.imp-file{width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;font-family:inherit;margin-bottom:20px}
.btn-import{width:100%;background:#111827;color:#fff;padding:10px;border-radius:8px;border:none;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit}
.btn-export{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid #e5e7eb;color:#374151;background:#fff}
.btn-export:hover{background:#f9fafb}
</style>

<div style="max-width:700px;margin:0 auto">
  <h1 style="font-size:20px;font-weight:800;color:#111827;margin-bottom:4px">Import & Export Data</h1>
  <p style="font-size:13px;color:#6b7280;margin-bottom:24px">Kelola data dari/ke file Excel PT Arisamandiri Pratama</p>

  @if(session('success'))
  <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px">✓ {{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px">✗ {{ session('error') }}</div>
  @endif

  {{-- IMPORT --}}
  <div class="imp-card" style="margin-bottom:16px">
    <h2 style="font-size:15px;font-weight:700;color:#111827;margin-bottom:16px;display:flex;align-items:center;gap:8px">
      <span style="background:#eff6ff;color:#2563eb;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:13px">↑</span>
      Import dari Excel
    </h2>
    <form method="POST" action="{{ route('import.post') }}" enctype="multipart/form-data">
      @csrf
      <label class="imp-label">Jenis Data</label>
      <select name="type" class="imp-select">
        <option value="kandidat">Kandidat (Sheet: Ghisna, Nisa, Wiwit)</option>
        <option value="join">Data JOIN</option>
        <option value="onboard">OnBoard (Operator & Staff)</option>
        <option value="os">Man Power OS</option>
        <option value="surat_pg">Surat PG</option>
      </select>
      <label class="imp-label">File Excel (.xlsx)</label>
      <input type="file" name="file" accept=".xlsx,.xls" class="imp-file">
      <button type="submit" class="btn-import">Import Sekarang</button>
    </form>
  </div>

  {{-- EXPORT --}}
  <div class="imp-card">
    <h2 style="font-size:15px;font-weight:700;color:#111827;margin-bottom:16px;display:flex;align-items:center;gap:8px">
      <span style="background:#f0fdf4;color:#16a34a;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:13px">↓</span>
      Export ke Excel
    </h2>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
      <a href="{{ route('export', 'kandidat') }}" class="btn-export">Kandidat</a>
      <a href="{{ route('export', 'join') }}" class="btn-export">Data JOIN</a>
      <a href="{{ route('export', 'onboard') }}" class="btn-export">OnBoard</a>
      <a href="{{ route('export', 'os') }}" class="btn-export">Man Power OS</a>
      <a href="{{ route('export', 'surat_pg') }}" class="btn-export">Surat PG</a>
    </div>
  </div>
</div>
@endsection
