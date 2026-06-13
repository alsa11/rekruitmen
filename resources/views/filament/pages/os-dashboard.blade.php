<x-filament-panels::page>
<div style="padding:0 0 24px">
@php $pics = ['Wiwit','Nisa','Ghisna']; @endphp
@foreach($pics as $pic)
@php
$data = \App\Models\Os::where('pic',$pic)->orderBy('posisi')->get();
$grouped = $data->groupBy('posisi');
$totalQty = $grouped->sum(fn($g) => $g->first()->qty ?? 0);
$totalTerisi = $grouped->sum(fn($g) => $g->first()->os_filled ?? 0);
$totalOs = $totalQty - $totalTerisi;
@endphp
<div style="margin-bottom:28px;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
  <div style="background:#111827;color:#fff;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px">
    <div style="font-size:16px;font-weight:700">📋 Man Power — {{ $pic }}</div>
    <div style="display:flex;gap:10px;font-size:12px">
      <span style="background:#374151;padding:3px 10px;border-radius:20px">Qty: <b>{{ $totalQty }}</b></span>
      <span style="background:#065f46;padding:3px 10px;border-radius:20px">Terisi: <b>{{ $totalTerisi }}</b></span>
      <span style="background:{{ $totalOs > 0 ? '#7f1d1d' : '#065f46' }};padding:3px 10px;border-radius:20px">Outstanding: <b>{{ $totalOs }}</b></span>
    </div>
  </div>
  <table style="width:100%;border-collapse:collapse;font-size:13px">
    <thead>
      <tr style="background:#f9fafb;border-bottom:2px solid #e5e7eb">
        <th style="padding:10px 14px;text-align:left;color:#374151;font-weight:600;width:200px">Position</th>
        <th style="padding:10px 14px;text-align:left;color:#374151;font-weight:600;width:120px">Placement</th>
        <th style="padding:10px 8px;text-align:center;color:#374151;font-weight:600;width:60px">Qty</th>
        <th style="padding:10px 8px;text-align:center;color:#374151;font-weight:600;width:60px">OS</th>
        <th style="padding:10px 8px;text-align:center;color:#374151;font-weight:600;width:80px">Outstanding</th>
        <th style="padding:10px 14px;text-align:left;color:#374151;font-weight:600">Name</th>
        <th style="padding:10px 14px;text-align:left;color:#374151;font-weight:600;width:100px">Joined</th>
        <th style="padding:10px 14px;text-align:left;color:#374151;font-weight:600;width:100px">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($grouped as $posisi => $items)
      @php
        $first = $items->first();
        $qty = $first->qty ?? 0;
        $os = $first->os_filled ?? 0;
        $outstanding = max(0, $qty - $os);
        $rowCount = $items->count();
        $isFirst = true;
      @endphp
      @foreach($items as $item)
      <tr style="border-bottom:1px solid #f3f4f6">
        @if($isFirst)
        <td rowspan="{{ $rowCount }}" style="padding:10px 14px;font-weight:600;color:#111827;vertical-align:top;border-right:1px solid #e5e7eb;background:#fafafa">{{ $posisi }}</td>
        <td rowspan="{{ $rowCount }}" style="padding:10px 14px;color:#6b7280;vertical-align:top;border-right:1px solid #e5e7eb;background:#fafafa">{{ $first->placement ?? '-' }}</td>
        <td rowspan="{{ $rowCount }}" style="padding:10px 8px;text-align:center;vertical-align:top;border-right:1px solid #e5e7eb;background:#fafafa">
          <span style="background:#f3f4f6;padding:2px 8px;border-radius:20px;font-weight:700">{{ $qty }}</span>
        </td>
        <td rowspan="{{ $rowCount }}" style="padding:10px 8px;text-align:center;vertical-align:top;border-right:1px solid #e5e7eb;background:#fafafa">
          <span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:20px;font-weight:700">{{ $os }}</span>
        </td>
        <td rowspan="{{ $rowCount }}" style="padding:10px 8px;text-align:center;vertical-align:top;border-right:1px solid #e5e7eb;background:#fafafa">
          <span style="background:{{ $outstanding > 0 ? '#fee2e2' : '#dcfce7' }};color:{{ $outstanding > 0 ? '#991b1b' : '#166534' }};padding:2px 8px;border-radius:20px;font-weight:700">{{ $outstanding }}</span>
        </td>
        @php $isFirst = false; @endphp
        @endif
        <td style="padding:8px 14px;color:#374151">{{ $item->nama ?? '-' }}</td>
        <td style="padding:8px 14px;color:#6b7280;white-space:nowrap">
          {{ $item->tanggal_join ? $item->tanggal_join->format('d/m/Y') : '-' }}
        </td>
        <td style="padding:8px 14px">
          @if($item->keterangan)
          <span style="background:#fef3c7;color:#92400e;padding:2px 6px;border-radius:20px;font-size:11px">{{ $item->keterangan }}</span>
          @endif
        </td>
      </tr>
      @endforeach
      @endforeach
    </tbody>
  </table>
</div>
@endforeach
</div>
</x-filament-panels::page>
