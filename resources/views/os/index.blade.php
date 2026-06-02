@extends('layouts.app')
@section('content')

<div class="flex justify-between items-center mb-5">
  <div>
    <h2 class="text-xl font-bold text-slate-800">Man Power OS</h2>
    <p class="text-slate-400 text-sm mt-0.5">Data tenaga kerja outsourcing PT Arisamandiri Pratama</p>
  </div>
  <a href="{{ route('os.create') }}"
     class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Tambah OS</a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-5 gap-3 mb-5">
  @foreach([
    ['Total OS',  $stats['total'],    '#0f1117', '#f5f3ef'],
    ['Ghisna',    $stats['ghisna'],   '#4338ca', '#eef2ff'],
    ['Nisa',      $stats['nisa'],     '#0369a1', '#eff6ff'],
    ['Wiwit',     $stats['wiwit'],    '#be185d', '#fdf2f8'],
    ['Diterima',  $stats['diterima'], '#1a7a4a', '#f0fdf4'],
  ] as [$label,$val,$tc,$bg])
  <div style="background:white; border:1px solid #e8e6e1; border-radius:12px; padding:16px 20px;">
    <div style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:#8a8a8a; margin-bottom:6px">{{ $label }}</div>
    <div style="font-size:2rem; font-weight:800; color:{{ $tc }}; font-family:'Plus Jakarta Sans',sans-serif">{{ $val }}</div>
  </div>
  @endforeach
</div>

{{-- Filter --}}
<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; padding:14px 16px; margin-bottom:16px">
  <form method="GET" style="display:flex; gap:10px; align-items:center">
    <input name="cari" placeholder="Cari nama karyawan OS..." value="{{ request('cari') }}"
           style="flex:1; border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px; outline:none">
    <select name="pic" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua PIC</option>
      @foreach(['Ghisna','Nisa','Wiwit'] as $p)
      <option value="{{ $p }}" @selected(request('pic')==$p)>{{ $p }}</option>
      @endforeach
    </select>
    <select name="status_akhir" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua Status</option>
      @foreach(['proses','diterima','ditolak','dipertimbangkan','mundur'] as $s)
      <option value="{{ $s }}" @selected(request('status_akhir')==$s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <button style="background:#0f1117; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer">Filter</button>
  </form>
</div>

{{-- Table --}}
<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; overflow:hidden">
  <table style="width:100%; border-collapse:collapse">
    <thead>
      <tr style="background:#0f1117">
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">Nama</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">Posisi</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">PIC</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">Tgl Join</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">Status</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($query as $o)
      @php
        $statusStyle = match($o->status_akhir) {
          'diterima'        => 'background:#f0fdf4;color:#1a7a4a',
          'ditolak'         => 'background:#fef2f2;color:#b91c1c',
          'dipertimbangkan' => 'background:#fffbeb;color:#92400e',
          'mundur'          => 'background:#f5f3ef;color:#6b7280',
          default           => 'background:#eef2ff;color:#4338ca',
        };
      @endphp
      <tr style="border-top:1px solid #f5f3ef" onmouseover="this.style.background='#faf9f7'" onmouseout="this.style.background='transparent'">
        <td style="padding:12px 16px; font-weight:600; font-size:13px">{{ $o->nama }}</td>
        <td style="padding:12px 16px; font-size:12px; color:#6b7280">{{ $o->posisi }}</td>
        <td style="padding:12px 16px; text-align:center">
          <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; background:#f5f3ef; color:#444">{{ $o->pic }}</span>
        </td>
        <td style="padding:12px 16px; text-align:center; font-size:12px; color:#6b7280">
          {{ $o->tanggal_join?->format('d/m/Y') ?? '—' }}
        </td>
        <td style="padding:12px 16px; text-align:center">
          <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; {{ $statusStyle }}">
            {{ ucfirst($o->status_akhir) }}
          </span>
        </td>
        <td style="padding:12px 16px; text-align:center">
          <div style="display:flex; gap:10px; justify-content:center">
            <a href="{{ route('os.edit',$o) }}" style="font-size:12px; color:#1d4ed8; text-decoration:none; font-weight:500">Edit</a>
            <form method="POST" action="{{ route('os.destroy',$o) }}" onsubmit="return confirm('Hapus data OS {{ $o->nama }}?')" style="display:inline">
              @csrf @method('DELETE')
              <button style="font-size:12px; color:#b91c1c; background:none; border:none; cursor:pointer; font-weight:500; font-family:inherit">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="padding:48px; text-align:center; color:#9ca3af">
          <div style="font-size:32px; margin-bottom:10px; opacity:.3"></div>
          <div style="font-size:13px">Belum ada data Man Power OS</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:14px 16px; border-top:1px solid #f5f3ef">
    {{ $query->links() }}
  </div>
</div>

@endsection
