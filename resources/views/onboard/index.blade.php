@extends('layouts.app')
@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
  <div>
    <h2 style="font-size:1.3rem; font-weight:700; color:var(--text)">OnBoard {{ ucfirst($level) }}</h2>
    <p style="font-size:13px; color:var(--sb-muted); margin-top:2px">Data onboarding karyawan level {{ $level }}</p>
  </div>
  <a href="{{ route('onboard.create') }}" style="background:#0f1117; color:white; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none">+ Tambah</a>
</div>

<div style="display:flex; gap:8px; margin-bottom:16px">
  <a href="{{ route('onboard.index',['level'=>'staff']) }}"
     style="padding:7px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; {{ $level=='staff' ? 'background:#0f1117;color:white' : 'background:var(--card);border:1px solid var(--border);color:var(--sb-text)' }}">Staff</a>
  <a href="{{ route('onboard.index',['level'=>'operator']) }}"
     style="padding:7px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; {{ $level=='operator' ? 'background:#0f1117;color:white' : 'background:var(--card);border:1px solid var(--border);color:var(--sb-text)' }}">Operator</a>
</div>

<div style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:14px 16px; margin-bottom:16px">
  <form method="GET" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap">
    <input type="hidden" name="level" value="{{ $level }}">
    <input name="cari" placeholder="Cari nama..." value="{{ request('cari') }}"
           style="flex:1; min-width:180px; border:1px solid var(--border); border-radius:8px; padding:8px 14px; font-size:13px; background:var(--bg); color:var(--text); outline:none">
    <select name="pic" style="border:1px solid var(--border); border-radius:8px; padding:8px 14px; font-size:13px; background:var(--bg); color:var(--text)">
      <option value="">Semua PIC</option>
      @foreach(['Ghisna','Nisa','Wiwit'] as $p)<option value="{{ $p }}" @selected(request('pic')==$p)>{{ $p }}</option>@endforeach
    </select>
    <select name="departemen" style="border:1px solid var(--border); border-radius:8px; padding:8px 14px; font-size:13px; background:var(--bg); color:var(--text)">
      <option value="">Semua Dept</option>
      @foreach(\App\Models\Onboard::where('level',$level)->distinct()->orderBy('departemen')->pluck('departemen')->filter() as $d)
      <option value="{{ $d }}" @selected(request('departemen')==$d)>{{ $d }}</option>
      @endforeach
    </select>
    <select name="sort" style="border:1px solid var(--border); border-radius:8px; padding:8px 14px; font-size:13px; background:var(--bg); color:var(--text)">
      <option value="">Urutan Terbaru</option>
      <option value="nama" @selected(request('sort')=='nama')>Nama A-Z</option>
      <option value="join_date" @selected(request('sort')=='join_date')>Join Date</option>
    </select>
    <button style="background:#0f1117; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer">Filter</button>
    <a href="{{ route('onboard.index',['level'=>$level]) }}" style="font-size:13px; color:var(--sb-muted); text-decoration:none">Reset</a>
  </form>
</div>

<div style="background:var(--card); border:1px solid var(--border); border-radius:12px; overflow:hidden">
  <div style="overflow-x:auto">
  <table style="width:100%; border-collapse:collapse; min-width:1200px">
    <thead>
      <tr style="background:#0f1117">
        @foreach(['Nama / NIK','Job Title','Dept / Divisi','Onboard','Join','Email / HP','Alamat','Kontrak / Lama','PIC','Lokasi','Status Makan','Ket.','Aksi'] as $h)
        <th style="padding:11px 12px; text-align:left; font-size:10px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">{{ $h }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse($query as $o)
      <tr style="border-top:1px solid var(--border)"
          onmouseover="this.style.background='rgba(0,0,0,.02)'" onmouseout="this.style.background='transparent'">
        <td style="padding:10px 12px; min-width:140px">
          <div style="font-weight:600; font-size:13px; color:var(--text)">{{ $o->nama }}</div>
          @if($o->nik_ktp)<div style="font-size:10px; color:var(--sb-muted)">{{ $o->nik_ktp }}</div>@endif
        </td>
        <td style="padding:10px 12px; font-size:12px; color:var(--sb-text); min-width:120px">{{ $o->job_title ?? '—' }}</td>
        <td style="padding:10px 12px; min-width:120px">
          <div style="font-size:12px; color:var(--text)">{{ $o->departemen ?? '—' }}</div>
          <div style="font-size:11px; color:var(--sb-muted)">{{ $o->divisi }}</div>
        </td>
        <td style="padding:10px 12px; font-size:12px; color:var(--sb-muted); white-space:nowrap">{{ $o->onboarding_date?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:12px; color:var(--sb-muted); white-space:nowrap">{{ $o->join_date?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:10px 12px; min-width:160px">
          <div style="font-size:11px; color:var(--text)">{{ $o->email ?? '—' }}</div>
          <div style="font-size:11px; color:var(--sb-muted)">{{ $o->no_hp ?? '' }}</div>
        </td>
        <td style="padding:10px 12px; font-size:11px; color:var(--sb-muted); max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $o->alamat ?? '—' }}</td>
        <td style="padding:10px 12px; min-width:100px">
          <span style="font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px; {{ $o->status_kontrak=='tetap' ? 'background:#f0fdf4;color:#1a7a4a' : 'background:#f5f3ef;color:#444' }}">
            {{ ucfirst($o->status_kontrak) }}
          </span>
          <div style="font-size:10px; color:var(--sb-muted); margin-top:2px">{{ $o->lama_kontrak }}</div>
        </td>
        <td style="padding:10px 12px; font-size:12px; color:var(--sb-text); white-space:nowrap">{{ $o->pic ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:12px; color:var(--sb-muted); white-space:nowrap">{{ $o->lokasi ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:11px; color:var(--sb-muted); white-space:nowrap">{{ $o->status_makan ?? '—' }}</td>
        <td style="padding:10px 12px; font-size:11px; color:var(--sb-muted); max-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $o->keterangan ?? '—' }}</td>
        <td style="padding:10px 12px; white-space:nowrap; min-width:100px">
          <a href="{{ route('onboard.edit',$o) }}" class="btn-edit">Edit</a>
          <span style="color:var(--border);margin:0 4px">|</span>
          <form method="POST" action="{{ route('onboard.destroy',$o) }}" onsubmit="return confirm('Hapus?')" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn-hapus">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="13" style="padding:48px; text-align:center; color:var(--sb-muted)">
          <div style="font-size:28px; margin-bottom:8px; opacity:.3">💼</div>
          <div>Belum ada data onboard {{ $level }}</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  </div>
  <div style="padding:14px 16px; border-top:1px solid var(--border)">{{ $query->links() }}</div>
</div>
@endsection
