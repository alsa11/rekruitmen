@extends('layouts.app')
@section('content')

<style>
.r-header { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fde68a; border-radius: 16px; padding: 24px 28px; margin-bottom: 24px; }
.stat-box { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px 20px; text-align: center; }
.stat-num { font-size: 2rem; font-weight: 800; line-height: 1; }
.stat-label { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #6b7280; margin-top: 4px; }
</style>

{{-- Header --}}
<div class="r-header">
  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px">
    <div>
      <h1 style="font-size:20px; font-weight:800; color:#92400e; margin:0">Monitoring Kontrak Karyawan</h1>
      <p style="font-size:13px; color:#b45309; margin-top:4px">Kontrak yang akan habis — PT Arisamandiri Pratama · {{ now()->format('d F Y') }}</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px; min-width:320px">
      @php
        $k7  = \App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(7)])->count();
        $k14 = \App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(14)])->count();
        $k30 = \App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(30)])->count();
      @endphp
      <div class="stat-box" style="border-color:#fecaca">
        <div class="stat-num" style="color:#b91c1c">{{ $k7 }}</div>
        <div class="stat-label" style="color:#b91c1c">Kritis &lt;7hr</div>
      </div>
      <div class="stat-box" style="border-color:#fde68a">
        <div class="stat-num" style="color:#92400e">{{ $k14 }}</div>
        <div class="stat-label" style="color:#92400e">Segera &lt;14hr</div>
      </div>
      <div class="stat-box" style="border-color:#fde68a">
        <div class="stat-num" style="color:#b45309">{{ $k30 }}</div>
        <div class="stat-label" style="color:#b45309">Total &lt;30hr</div>
      </div>
    </div>
  </div>
</div>

{{-- Filter tab --}}
<div style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap">
  @foreach([[7,'🔴 Kritis (7 hari)'],[14,'🟠 14 Hari'],[30,'🟡 30 Hari'],[null,'Semua']] as [$hari,$label])
  <a href="{{ route('join.reminder', $hari ? ['hari'=>$hari] : []) }}"
     style="font-size:12px; font-weight:600; padding:6px 14px; border-radius:8px; text-decoration:none; border:1px solid;
     {{ request('hari')==$hari ? 'background:#111827;color:#fff;border-color:#111827' : 'background:#fff;color:#374151;border-color:#e5e7eb' }}">
    {{ $label }}
    @if($hari)
      ({{ \App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays($hari)])->count() }})
    @endif
  </a>
  @endforeach
</div>

{{-- Table --}}
<div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden">
  <table style="width:100%; border-collapse:collapse; font-size:13px">
    <thead>
      <tr style="background:#111827; color:#fff">
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">#</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Nama Karyawan</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Posisi</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Divisi</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">PIC</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Tgl Mulai</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Akhir Kontrak</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Sisa Hari</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Status</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.05em; text-transform:uppercase">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reminders as $i => $r)
      @php
        $sisa = (int)now()->diffInDays($r->tgl_akhir_kontrak, false);
        $rowBg = $sisa <= 7 ? '#fef2f2' : ($sisa <= 14 ? '#fffbeb' : '#ffffff');
        $badgeCls = $sisa <= 7 ? 'background:#fecaca;color:#b91c1c' : ($sisa <= 14 ? 'background:#fde68a;color:#92400e' : 'background:#d1fae5;color:#065f46');
        $statusLabel = $sisa <= 7 ? '🔴 Kritis' : ($sisa <= 14 ? '🟠 Segera' : '🟡 Perhatian');
      @endphp
      <tr style="background:{{ $rowBg }}; border-top:1px solid #f3f4f6">
        <td style="padding:12px 16px; color:#9ca3af; font-size:12px">{{ $i+1 }}</td>
        <td style="padding:12px 16px; font-weight:600; color:#111827">{{ $r->nama }}</td>
        <td style="padding:12px 16px; color:#6b7280">{{ $r->posisi ?? '-' }}</td>
        <td style="padding:12px 16px; color:#6b7280">{{ $r->divisi ?? '-' }}</td>
        <td style="padding:12px 16px">
          <span style="background:#f3f4f6; color:#374151; font-size:11px; font-weight:600; padding:2px 8px; border-radius:6px">{{ $r->pic ?? '-' }}</span>
        </td>
        <td style="padding:12px 16px; color:#6b7280; font-size:12px">{{ $r->join_date?->format('d/m/Y') ?? '-' }}</td>
        <td style="padding:12px 16px; font-weight:600; color:#111827">{{ $r->tgl_akhir_kontrak->format('d M Y') }}</td>
        <td style="padding:12px 16px; text-align:center">
          <span style="font-size:13px; font-weight:800; padding:4px 12px; border-radius:999px; {{ $badgeCls }}">
            {{ $sisa }} hari
          </span>
        </td>
        <td style="padding:12px 16px; text-align:center; font-size:12px">{{ $statusLabel }}</td>
        <td style="padding:12px 16px; text-align:center">
          <a href="/admin/joins/{{ $r->id }}/edit"
             style="font-size:12px; color:#2563eb; font-weight:600; text-decoration:none; background:#eff6ff; padding:4px 10px; border-radius:6px; border:1px solid #bfdbfe">
            Perbarui
          </a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="10" style="text-align:center; padding:48px; color:#9ca3af">
          <div style="font-size:32px; margin-bottom:8px">✅</div>
          <div style="font-size:14px; font-weight:500">Tidak ada kontrak yang akan habis</div>
          <div style="font-size:12px; margin-top:4px">Semua kontrak masih aman</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
