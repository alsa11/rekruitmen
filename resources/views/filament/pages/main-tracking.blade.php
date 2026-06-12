<x-filament-panels::page>

{{-- Filter bar --}}
<div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;align-items:center">

  {{-- Filter tanggal --}}
  <div style="display:flex;gap:6px">
    @foreach([
      'hari_ini'   => 'Hari Ini',
      'minggu_ini' => 'Minggu Ini',
      'bulan_ini'  => 'Bulan Ini',
      'bulan_lalu' => 'Bulan Lalu',
      'semua'      => 'Semua',
    ] as $val => $label)
    <a href="?tanggal={{ $val }}&pic={{ $filter_pic }}"
       style="padding:6px 14px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid #e5e7eb;
       background:{{ $filter_date==$val?'#ea580c':'white' }};color:{{ $filter_date==$val?'white':'#374151' }}">
      {{ $label }}
    </a>
    @endforeach
  </div>

  {{-- Filter PIC --}}
  <div style="display:flex;gap:6px;margin-left:auto">
    <a href="?tanggal={{ $filter_date }}&pic="
       style="padding:6px 14px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid #e5e7eb;
       background:{{ !$filter_pic?'#0f1117':'white' }};color:{{ !$filter_pic?'white':'#374151' }}">
      Semua PIC
    </a>
    @foreach(['Ghisna','Nisa','Wiwit'] as $p)
    <a href="?tanggal={{ $filter_date }}&pic={{ $p }}"
       style="padding:6px 14px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid #e5e7eb;
       background:{{ $filter_pic==$p?'#0f1117':'white' }};color:{{ $filter_pic==$p?'white':'#374151' }}">
      {{ $p }}
    </a>
    @endforeach
  </div>
</div>

{{-- Stats hari ini --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
  @foreach([
    ['Interview Hari Ini', $stats['total_hari_ini'], '#0f1117'],
    ['Ghisna', $stats['ghisna'], '#4338ca'],
    ['Nisa', $stats['nisa'], '#0369a1'],
    ['Wiwit', $stats['wiwit'], '#be185d'],
  ] as [$label,$n,$color])
  <div style="background:white;border:1px solid #e5e7eb;border-radius:10px;padding:16px 20px">
    <div style="font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af;margin-bottom:6px">{{ $label }}</div>
    <div style="font-size:1.8rem;font-weight:800;color:{{ $color }}">{{ $n }}</div>
  </div>
  @endforeach
</div>

@if($kandidats->isEmpty())
<div style="text-align:center;padding:48px;background:white;border-radius:12px;border:1px solid #e5e7eb;color:#9ca3af">
  <div style="font-size:32px;margin-bottom:8px;opacity:.3">📅</div>
  <div>Tidak ada jadwal interview untuk filter ini</div>
</div>
@else

{{-- Tabel per PIC --}}
@foreach($byPic as $pic => $list)
<div style="background:white;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:16px">
  <div style="padding:12px 20px;background:#f9fafb;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center">
    <div style="font-size:14px;font-weight:700;color:#111827">PIC: {{ $pic }}</div>
    <span style="background:#e5e7eb;color:#374151;font-size:11px;font-weight:600;padding:2px 10px;border-radius:999px">{{ $list->count() }} kandidat</span>
  </div>
  <table style="width:100%;border-collapse:collapse">
    <thead>
      <tr style="background:#f9fafb;border-bottom:2px solid #e5e7eb">
        <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Nama</th>
        <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Posisi</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Tgl Interview</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Jam</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Int. Online</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">App Form</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Int. Offline</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Status</th>
        <th style="padding:10px 16px;text-align:center;font-size:11px;font-weight:600;text-transform:uppercase;color:#9ca3af">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($list as $k)
      @php
        $isToday = $k->tanggal_interview?->isToday();
        $statusColor = match($k->status_akhir) {
          'diterima'        => '#16a34a',
          'ditolak'         => '#dc2626',
          'dipertimbangkan' => '#d97706',
          'mundur'          => '#6b7280',
          default           => '#4338ca',
        };
        $statusBg = match($k->status_akhir) {
          'diterima'        => '#f0fdf4',
          'ditolak'         => '#fef2f2',
          'dipertimbangkan' => '#fffbeb',
          'mundur'          => '#f3f4f6',
          default           => '#eef2ff',
        };
        $nextStep = match(true) {
          $k->interview_online === 'belum' => '⏳ Belum Int. Online',
          $k->app_form === 'belum'         => '📝 Belum App Form',
          $k->interview_offline === 'belum'=> '🏢 Belum Int. Offline',
          $k->psikotest === 'belum'        => '🧠 Belum Psikotest',
          default                          => '✓ Selesai',
        };
      @endphp
      <tr style="border-bottom:1px solid #f9fafb;background:{{ $isToday ? '#fffbeb' : 'transparent' }}">
        <td style="padding:10px 16px">
          <div style="font-weight:600;font-size:13px;color:#111827">{{ $k->nama }}</div>
          @if($k->no_wa)<div style="font-size:11px;color:#9ca3af">{{ $k->no_wa }}</div>@endif
          <div style="font-size:10px;color:#ea580c;margin-top:2px">{{ $nextStep }}</div>
        </td>
        <td style="padding:10px 16px;font-size:12px;color:#6b7280">{{ $k->posisi }}</td>
        <td style="padding:10px 16px;text-align:center;font-size:12px;{{ $isToday ? 'font-weight:700;color:#ea580c' : 'color:#6b7280' }}">
          {{ $k->tanggal_interview?->format('d/m/Y') ?? '—' }}
          @if($isToday)<div style="font-size:10px;color:#ea580c">Hari ini!</div>@endif
        </td>
        <td style="padding:10px 16px;text-align:center;font-size:12px;font-weight:600;color:#111827">{{ $k->jam_interview ?? '—' }}</td>
        <td style="padding:10px 16px;text-align:center">
          <span style="font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;background:{{ $k->interview_online==='hadir'?'#dcfce7':($k->interview_online==='tidak_hadir'?'#fee2e2':'#f3f4f6') }};color:{{ $k->interview_online==='hadir'?'#16a34a':($k->interview_online==='tidak_hadir'?'#dc2626':'#6b7280') }}">
            {{ str_replace('_',' ',ucfirst($k->interview_online ?? 'belum')) }}
          </span>
        </td>
        <td style="padding:10px 16px;text-align:center">
          <span style="font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;background:{{ $k->app_form==='terkirim'?'#dcfce7':'#f3f4f6' }};color:{{ $k->app_form==='terkirim'?'#16a34a':'#6b7280' }}">
            {{ str_replace('_',' ',ucfirst($k->app_form ?? 'belum')) }}
          </span>
        </td>
        <td style="padding:10px 16px;text-align:center">
          <span style="font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;background:{{ $k->interview_offline==='hadir'?'#dcfce7':($k->interview_offline==='tidak_hadir'?'#fee2e2':'#f3f4f6') }};color:{{ $k->interview_offline==='hadir'?'#16a34a':($k->interview_offline==='tidak_hadir'?'#dc2626':'#6b7280') }}">
            {{ str_replace('_',' ',ucfirst($k->interview_offline ?? 'belum')) }}
          </span>
        </td>
        <td style="padding:10px 16px;text-align:center">
          <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:999px;background:{{ $statusBg }};color:{{ $statusColor }}">
            {{ ucfirst($k->status_akhir) }}
          </span>
        </td>
        <td style="padding:10px 16px;text-align:center">
          <a href="/admin/kandidats/{{ $k->id }}/edit"
             style="font-size:12px;color:#2563eb;text-decoration:none;font-weight:500">Edit</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endforeach

@endif

</x-filament-panels::page>
