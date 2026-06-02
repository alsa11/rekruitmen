@extends('layouts.app')
@section('content')

<div class="flex justify-between items-center mb-5">
  <div>
    <h2 class="text-xl font-bold text-slate-800">Data JOIN</h2>
    <p class="text-slate-400 text-sm mt-0.5">Karyawan yang sudah bergabung PT Arisamandiri Pratama</p>
  </div>
  <a href="{{ route('join.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Tambah</a>
</div>

@if($reminders->count())
<div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:14px 18px; margin-bottom:16px">
  <div style="font-weight:600; color:#92400e; font-size:13px; margin-bottom:8px">⚠ {{ $reminders->count() }} kontrak akan habis dalam 30 hari</div>
  <div style="display:flex; gap:8px; flex-wrap:wrap">
    @foreach($reminders->take(5) as $r)
    @php $sisa = (int)now()->diffInDays($r->tgl_akhir_kontrak, false); @endphp
    <span style="background:white; border:1px solid {{ $sisa<=7?'#fca5a5':'#fde68a' }}; border-radius:8px; padding:4px 12px; font-size:12px; color:{{ $sisa<=7?'#b91c1c':'#92400e' }}">
      {{ $r->nama }} — <strong>{{ $sisa }}h</strong>
    </span>
    @endforeach
    @if($reminders->count()>5)<a href="{{ route('join.reminder') }}" style="font-size:12px; color:#b45309; text-decoration:none; padding:4px 0">+{{ $reminders->count()-5 }} lainnya →</a>@endif
  </div>
</div>
@endif

<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; padding:14px 16px; margin-bottom:16px">
  <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center">
    <input name="cari" placeholder="Cari nama..." value="{{ request('cari') }}"
           style="flex:1; min-width:180px; border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px; outline:none">
    <select name="pic" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua PIC</option>
      @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected(request('pic')==$p)>{{ $p }}</option>@endforeach
    </select>
    <select name="status_kontrak" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua Kontrak</option>
      @foreach(['probation','kontrak','tetap'] as $s)<option value="{{ $s }}" @selected(request('status_kontrak')==$s)>{{ ucfirst($s) }}</option>@endforeach
    </select>
    <select name="sort" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Terbaru</option>
      <option value="nama" @selected(request('sort')=='nama')>Nama A-Z</option>
      <option value="join_date" @selected(request('sort')=='join_date')>Join Date</option>
      <option value="tgl_akhir_kontrak" @selected(request('sort')=='tgl_akhir_kontrak')>Akhir Kontrak</option>
    </select>
    <select name="reminder" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua</option>
      <option value="7"  @selected(request('reminder')=='7')>Habis 7 hari</option>
      <option value="14" @selected(request('reminder')=='14')>Habis 14 hari</option>
      <option value="30" @selected(request('reminder')=='30')>Habis 30 hari</option>
    </select>
    <button style="background:#0f1117; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer">Filter</button>
    <a href="{{ route('join.index') }}" style="font-size:13px; color:#6b7280; text-decoration:none">Reset</a>
  </form>
</div>

<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; overflow:hidden">
  <div style="overflow-x:auto">
  <table style="width:100%; border-collapse:collapse; min-width:1200px">
    <thead>
      <tr style="background:#0f1117">
        @foreach(['Nama','Posisi / Divisi','Join Date','User / Atasan','Penempatan','Laptop','Rek. Danamon','PIC','Kontrak','Akhir Kontrak','Sisa','Aksi'] as $h)
        <th style="padding:11px 12px; text-align:left; font-size:10px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">{{ $h }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse($query as $j)
      @php $sisa = $j->tgl_akhir_kontrak ? (int)now()->diffInDays($j->tgl_akhir_kontrak, false) : null; @endphp
      <tr style="border-top:1px solid #f5f3ef; background:{{ $sisa!==null&&$sisa<=7?'#fff5f5':($sisa!==null&&$sisa<=30?'#fffdf0':'transparent') }}"
          onmouseover="this.style.background='#faf9f7'" onmouseout="this.style.background='{{ $sisa!==null&&$sisa<=7?'#fff5f5':($sisa!==null&&$sisa<=30?'#fffdf0':'transparent') }}'">
        <td style="padding:10px 12px; font-weight:600; font-size:13px">{{ $j->nama }}</td>
        <td style="padding:10px 12px">
          <div style="font-size:13px; color:#444">{{ $j->posisi }}</div>
          <div style="font-size:11px; color:#9ca3af">{{ $j->divisi }}</div>
        </td>
        <td style="padding:10px 12px; font-size:12px; color:#6b7280; white-space:nowrap">{{ $j->join_date?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:12px; color:#6b7280">{{ $j->user_pic ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:12px; color:#6b7280">{{ $j->penempatan ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:11px; color:#6b7280">
          <div>{{ $j->laptop_needs ?? '—' }}</div>
          @if($j->laptop_memo)<div style="color:#9ca3af">{{ $j->laptop_memo }}</div>@endif
        </td>
        <td style="padding:10px 12px; font-size:12px; color:#6b7280">{{ $j->rek_danamon ?? '—' }}</td>
        <td style="padding:10px 12px">
          <span style="font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px; background:#f5f3ef; color:#444">{{ $j->pic ?? '—' }}</span>
        </td>
        <td style="padding:10px 12px">
          <span style="font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px; {{ $j->status_kontrak=='tetap'?'background:#f0fdf4;color:#1a7a4a':($j->status_kontrak=='probation'?'background:#eef2ff;color:#4338ca':'background:#f5f3ef;color:#444') }}">
            {{ ucfirst($j->status_kontrak) }}
          </span>
        </td>
        <td style="padding:10px 12px; font-size:12px; color:#6b7280; white-space:nowrap">{{ $j->tgl_akhir_kontrak?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:10px 12px">
          @if($sisa!==null)
          <span style="font-size:11px; font-weight:700; padding:2px 8px; border-radius:999px; {{ $sisa<=7?'background:#fef2f2;color:#b91c1c':($sisa<=30?'background:#fffbeb;color:#92400e':'background:#f0fdf4;color:#1a7a4a') }}">{{ $sisa }}h</span>
          @else<span style="color:#d1d5db; font-size:12px">—</span>@endif
        </td>
        <td style="padding:10px 12px">
          <div style="display:flex; gap:8px">
            <a href="{{ route('join.edit',$j) }}" style="font-size:12px; color:#1d4ed8; text-decoration:none; font-weight:500">Edit</a>
            <form method="POST" action="{{ route('join.destroy',$j) }}" onsubmit="return confirm('Hapus {{ $j->nama }}?')" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn-hapus">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="12" style="padding:48px; text-align:center; color:#9ca3af">
        <div style="font-size:32px; margin-bottom:10px; opacity:.3"></div>
        <div>Belum ada data JOIN</div>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
  <div style="padding:14px 16px; border-top:1px solid #f5f3ef">{{ $query->links() }}</div>
</div>
@endsection
