<x-filament-panels::page>

{{-- Filter tabs --}}
<div style="display:flex;gap:8px;margin-bottom:20px">
  @foreach([7=>'Kritis (7 hari)',14=>'Segera (14 hari)',30=>'Perhatian (30 hari)'] as $h=>$label)
  <a href="?hari={{ $h }}"
     style="padding:7px 16px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid {{ request('hari',$h)==$h&&(request('hari')==$h||(!request('hari')&&$h==30))?'transparent':'#e5e7eb' }};background:{{ request('hari')==$h?($h==7?'#dc2626':($h==14?'#d97706':'#16a34a')):'white' }};color:{{ request('hari')==$h?'white':'#374151' }}">
    {{ $label }}
  </a>
  @endforeach
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px">
  <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:18px 20px">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:#dc2626;margin-bottom:6px">Kritis &lt; 7 Hari</div>
    <div style="font-size:2rem;font-weight:800;color:#dc2626">{{ $kritis }}</div>
  </div>
  <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:18px 20px">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:#d97706;margin-bottom:6px">Segera &lt; 14 Hari</div>
    <div style="font-size:2rem;font-weight:800;color:#d97706">{{ $segera }}</div>
  </div>
  <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:18px 20px">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:#16a34a;margin-bottom:6px">Total Monitoring</div>
    <div style="font-size:2rem;font-weight:800;color:#16a34a">{{ $reminders->count() }}</div>
  </div>
</div>

{{-- Tabel --}}
<div style="background:white;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
  <table style="width:100%;border-collapse:collapse">
    <thead>
      <tr style="background:#f9fafb;border-bottom:2px solid #e5e7eb">
        @foreach(['Nama','Posisi','Divisi','Join Date','Akhir Kontrak','Sisa','Urgensi'] as $h)
        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#9ca3af">{{ $h }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse($reminders as $r)
      @php $sisa=(int)now()->diffInDays($r->tgl_akhir_kontrak,false); @endphp
      <tr style="border-bottom:1px solid #f9fafb;background:{{ $sisa<=7?'#fef2f2':($sisa<=14?'#fffbeb':'white') }}">
        <td style="padding:11px 14px;font-weight:600;font-size:13px">{{ $r->nama }}</td>
        <td style="padding:11px 14px;font-size:12px;color:#6b7280">{{ $r->posisi }}</td>
        <td style="padding:11px 14px;font-size:12px;color:#6b7280">{{ $r->divisi }}</td>
        <td style="padding:11px 14px;font-size:12px;color:#6b7280">{{ $r->join_date?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:11px 14px;font-size:12px;font-weight:500;color:#111827">{{ $r->tgl_akhir_kontrak->format('d M Y') }}</td>
        <td style="padding:11px 14px">
          <span style="font-size:12px;font-weight:700;padding:3px 10px;border-radius:999px;background:{{ $sisa<=7?'#fee2e2':($sisa<=14?'#fef3c7':'#dcfce7') }};color:{{ $sisa<=7?'#dc2626':($sisa<=14?'#d97706':'#16a34a') }}">{{ $sisa }} hari</span>
        </td>
        <td style="padding:11px 14px">
          <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:999px;background:{{ $sisa<=7?'#dc2626':($sisa<=14?'#d97706':'#16a34a') }};color:white">
            {{ $sisa<=7?'Kritis':($sisa<=14?'Segera':'Perhatian') }}
          </span>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="padding:48px;text-align:center;color:#9ca3af">
          <div style="font-size:28px;opacity:.3;margin-bottom:8px">✓</div>
          <div>Tidak ada kontrak habis dalam {{ $hari }} hari ke depan</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

</x-filament-panels::page>
