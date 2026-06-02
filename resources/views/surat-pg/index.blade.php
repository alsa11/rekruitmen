@extends('layouts.app')
@section('content')

<div class="flex justify-between items-center mb-5">
  <div>
    <h2 class="text-xl font-bold text-slate-800">Surat Penawaran Gaji</h2>
    <p class="text-slate-400 text-sm mt-0.5">Daftar surat penawaran gaji karyawan</p>
  </div>
  <a href="{{ route('surat-pg.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Tambah</a>
</div>

{{-- Filter --}}
<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; padding:14px 16px; margin-bottom:16px">
  <form method="GET" style="display:flex; gap:10px; align-items:center">
    <input name="cari" placeholder="Cari nama karyawan..." value="{{ request('cari') }}"
           style="flex:1; border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px; outline:none">
    <select name="pic" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua PIC</option>
      @foreach(['Ghisna','Nisa','Wiwit'] as $p)
      <option value="{{ $p }}" @selected(request('pic')==$p)>{{ $p }}</option>
      @endforeach
    </select>
    <select name="status_ttd" style="border:1px solid #e8e6e1; border-radius:8px; padding:8px 14px; font-size:13px">
      <option value="">Semua Status TTD</option>
      <option value="belum" @selected(request('status_ttd')=='belum')>Belum TTD</option>
      <option value="sudah" @selected(request('status_ttd')=='sudah')>Sudah TTD</option>
    </select>
    <button style="background:#0f1117; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer">Filter</button>
    <a href="{{ route('surat-pg.index') }}" style="font-size:13px; color:#6b7280; text-decoration:none">Reset</a>
  </form>
</div>

<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; overflow:hidden">
  <table style="width:100%; border-collapse:collapse">
    <thead>
      <tr style="background:#0f1117">
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">No. Surat</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">Nama Karyawan</th>
        <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">Posisi / Dept</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">Tgl Join</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">PIC</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">TTD</th>
        <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.06em">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($query as $s)
      <tr style="border-top:1px solid #f5f3ef"
          onmouseover="this.style.background='#faf9f7'" onmouseout="this.style.background='transparent'">
        <td style="padding:12px 16px; font-size:12px; font-family:monospace; color:#6b7280">{{ $s->nomor_surat ?? '—' }}</td>
        <td style="padding:12px 16px; font-weight:600; font-size:13px">{{ $s->nama_karyawan }}</td>
        <td style="padding:12px 16px">
          <div style="font-size:13px; color:#444">{{ $s->posisi }}</div>
          <div style="font-size:11px; color:#9ca3af">{{ $s->departemen }}</div>
        </td>
        <td style="padding:12px 16px; text-align:center; font-size:12px; color:#6b7280">{{ $s->tanggal_join?->format('d/m/Y') ?? '—' }}</td>
        <td style="padding:12px 16px; text-align:center">
          <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; background:#f5f3ef; color:#444">{{ $s->pic ?? '—' }}</span>
        </td>
        <td style="padding:12px 16px; text-align:center">
          <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;
            {{ $s->status_ttd=='sudah' ? 'background:#f0fdf4;color:#1a7a4a' : 'background:#fef2f2;color:#b91c1c' }}">
            {{ $s->status_ttd=='sudah' ? '✓ Sudah' : '✗ Belum' }}
          </span>
        </td>
        <td style="padding:12px 16px; text-align:center">
          <div style="display:flex; gap:10px; justify-content:center">
            <a href="{{ route('surat-pg.edit',$s) }}" style="font-size:12px; color:#1d4ed8; text-decoration:none; font-weight:500">Edit</a>
            <form method="POST" action="{{ route('surat-pg.destroy',$s) }}" onsubmit="return confirm('Hapus surat {{ $s->nama_karyawan }}?')" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn-hapus">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="padding:48px; text-align:center; color:#9ca3af">
          <div style="font-size:32px; margin-bottom:10px; opacity:.3"></div>
          <div>Belum ada data Surat PG</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:14px 16px; border-top:1px solid #f5f3ef">{{ $query->links() }}</div>
</div>
@endsection