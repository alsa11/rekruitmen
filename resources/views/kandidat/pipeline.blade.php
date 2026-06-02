@extends('layouts.app')
@section('content')

<style>
.stage-dropdown {
  border: 1px solid #e8e6e1;
  border-radius: 6px;
  padding: 4px 8px;
  font-size: 11px;
  font-weight: 600;
  cursor: pointer;
  outline: none;
  transition: border-color 0.2s;
  background: white;
}
.stage-dropdown:focus { border-color: #0f1117; }
.saving { opacity: 0.5; pointer-events: none; }

/* Toast */
#toast-pip { position:fixed; bottom:24px; right:24px; z-index:999; display:flex; flex-direction:column; gap:8px; }
.tp { background:#0f1117; color:white; padding:10px 16px; border-radius:10px; font-size:12px; display:flex; align-items:center; gap:8px; animation: sin .3s ease; }
@keyframes sin { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }
</style>

<div id="toast-pip"></div>

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
  <div>
    <h2 style="font-size:1.3rem; font-weight:800; color:#0f1117">Pipeline — {{ $pic }}</h2>
    <p style="color:#9ca3af; font-size:13px; margin-top:2px">{{ $total }} kandidat total</p>
  </div>
  <div style="display:flex; gap:10px">
    <a href="{{ route('kandidat.export', ['pic'=>$pic]) }}"
       style="border:1px solid #e8e6e1; padding:8px 16px; border-radius:8px; font-size:13px; color:#444; text-decoration:none">
      ⬇ Export {{ $pic }}
    </a>
    <a href="{{ route('kandidat.index') }}"
       style="border:1px solid #e8e6e1; padding:8px 16px; border-radius:8px; font-size:13px; color:#444; text-decoration:none">
      ← Semua Kandidat
    </a>
  </div>
</div>

{{-- Stage Stats --}}
<div style="display:grid; grid-template-columns:repeat(6,1fr); gap:10px; margin-bottom:20px">
  @foreach([
    ['Screening',    $stages['screening'], '#1d4ed8', '#eff6ff', '#bfdbfe'],
    ['Int. Online',  $stages['online'],    '#4338ca', '#eef2ff', '#c7d2fe'],
    ['App Form',     $stages['appform'],   '#0369a1', '#e0f2fe', '#bae6fd'],
    ['Int. Offline', $stages['offline'],   '#b45309', '#fffbeb', '#fde68a'],
    ['Psikotest',    $stages['psikotest'], '#be185d', '#fdf2f8', '#fbcfe8'],
    ['Diterima',     $stages['diterima'],  '#1a7a4a', '#f0fdf4', '#bbf7d0'],
  ] as [$label,$val,$tc,$bg,$border])
  <div style="background:{{ $bg }}; border:1px solid {{ $border }}; border-radius:12px; padding:14px; text-align:center; cursor:pointer"
       onclick="filterStage('{{ strtolower(str_replace([' ','.'],['_',''],$label)) }}')">
    <div style="font-size:1.6rem; font-weight:800; color:{{ $tc }}">{{ $val }}</div>
    <div style="font-size:11px; font-weight:500; color:{{ $tc }}; margin-top:3px; opacity:.8">{{ $label }}</div>
  </div>
  @endforeach
</div>

{{-- Filter Bar --}}
<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; padding:12px 16px; margin-bottom:16px; display:flex; gap:10px; align-items:center; flex-wrap:wrap">
  @foreach([
    ''               => 'Semua',
    'proses'         => 'Proses',
    'diterima'       => 'Diterima ',
    'ditolak'        => 'Ditolak ',
    'dipertimbangkan'=> 'Pertimbangan',
    'mundur'         => 'Mundur',
  ] as $val => $label)
  <a href="{{ route('kandidat.pipeline', ['pic'=>$pic,'status_akhir'=>$val]) }}"
     style="padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500; text-decoration:none; transition:all .15s;
     {{ request('status_akhir')==$val ? 'background:#0f1117;color:white' : 'border:1px solid #e8e6e1;color:#444' }}">
    {{ $label }}
  </a>
  @endforeach
  <div style="flex:1"></div>
  <form method="GET" style="display:flex; gap:8px">
    <input type="hidden" name="pic" value="{{ $pic }}">
    <input type="hidden" name="status_akhir" value="{{ request('status_akhir') }}">
    <input name="cari" placeholder="Cari nama..." value="{{ request('cari') }}"
           style="border:1px solid #e8e6e1; border-radius:8px; padding:6px 12px; font-size:12px; width:180px; outline:none">
    <button style="background:#0f1117; color:white; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer">Cari</button>
  </form>
</div>

{{-- Tabel Pipeline --}}
<div style="background:white; border:1px solid #e8e6e1; border-radius:12px; overflow:hidden">
  <div style="overflow-x:auto">
  <table style="width:100%; border-collapse:collapse; min-width:900px">
    <thead>
      <tr style="background:#0f1117">
        <th style="padding:11px 14px; text-align:left; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">Nama / WA</th>
        <th style="padding:11px 14px; text-align:left; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em">Posisi</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">📋 Screening</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">💻 Int. Online</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">📝 App Form</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">🏢 Int. Offline</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap">🧠 Psikotest</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em">Status</th>
        <th style="padding:11px 14px; text-align:center; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($kandidats as $k)
      @php
        $statusColor = match($k->status_akhir) {
          'diterima'        => 'background:#f0fdf4;color:#1a7a4a',
          'ditolak'         => 'background:#fef2f2;color:#b91c1c',
          'dipertimbangkan' => 'background:#fffbeb;color:#92400e',
          'mundur'          => 'background:#f5f3ef;color:#6b7280',
          default           => 'background:#eef2ff;color:#4338ca',
        };
      @endphp
      <tr data-id="{{ $k->id }}" style="border-top:1px solid #f5f3ef"
          onmouseover="this.style.background='#fafaf9'" onmouseout="this.style.background='transparent'">

        {{-- Nama --}}
        <td style="padding:10px 14px">
          <div style="font-weight:600; font-size:13px; color:#0f1117">{{ $k->nama }}</div>
          @if($k->no_wa)
          <div style="font-size:11px; color:#9ca3af; margin-top:1px">{{ $k->no_wa }}</div>
          @endif
          @if($k->tanggal_interview)
          <div style="font-size:10px; color:#c4bfb5; margin-top:1px">{{ $k->tanggal_interview->format('d/m/Y') }}</div>
          @endif
        </td>

        {{-- Posisi --}}
        <td style="padding:10px 14px; font-size:12px; color:#6b7280; max-width:130px">{{ $k->posisi }}</td>

        {{-- Screening --}}
        <td style="padding:10px 14px; text-align:center">
          @if($k->cv_link)
            <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; background:#eff6ff; color:#1d4ed8">Ada CV</span>
          @else
            <select class="stage-dropdown" onchange="updateStage({{ $k->id }}, 'cv_status', this.value, this)">
              <option value="">— Screening —</option>
              <option value="ada" {{ $k->cv_status=='ada' ? 'selected' : '' }}>Ada CV</option>
              <option value="tidak_ada" {{ $k->cv_status=='tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
            </select>
          @endif
        </td>

        {{-- Interview Online --}}
        <td style="padding:10px 14px; text-align:center">
          <select class="stage-dropdown" onchange="updateStage({{ $k->id }}, 'interview_online', this.value, this)"
                  style="{{ getDropdownStyle($k->interview_online) }}">
            <option value="belum"             {{ $k->interview_online=='belum'             ? 'selected' : '' }}> Belum </option>
            <option value="hadir"             {{ $k->interview_online=='hadir'             ? 'selected' : '' }}> Hadir</option>
            <option value="tidak_hadir"       {{ $k->interview_online=='tidak_hadir'       ? 'selected' : '' }}>Tidak Hadir</option>
            <option value="reschedule"        {{ $k->interview_online=='reschedule'        ? 'selected' : '' }}>Reschedule</option>
            <option value="sudah_dalam_proses"{{ $k->interview_online=='sudah_dalam_proses'? 'selected' : '' }}>Dalam Proses</option>
            <option value="belum_lolos"       {{ $k->interview_online=='belum_lolos'       ? 'selected' : '' }}> Belum Lolos</option>
          </select>
        </td>

        {{-- App Form --}}
        <td style="padding:10px 14px; text-align:center">
          <select class="stage-dropdown" onchange="updateStage({{ $k->id }}, 'app_form', this.value, this)"
                  style="{{ getDropdownStyle($k->app_form) }}">
            <option value="belum"         {{ $k->app_form=='belum'         ? 'selected' : '' }}>Belum </option>
            <option value="terkirim"      {{ $k->app_form=='terkirim'      ? 'selected' : '' }}>Terkirim</option>
            <option value="lanjut_offline"{{ $k->app_form=='lanjut_offline'? 'selected' : '' }}>Lanjut Offline</option>
            <option value="lanjut_user"   {{ $k->app_form=='lanjut_user'   ? 'selected' : '' }}>Lanjut User</option>
            <option value="dialihkan"     {{ $k->app_form=='dialihkan'     ? 'selected' : '' }}>Dialihkan</option>
            <option value="mundur"        {{ $k->app_form=='mundur'        ? 'selected' : '' }}>Mundur</option>
          </select>
        </td>

        {{-- Interview Offline --}}
        <td style="padding:10px 14px; text-align:center">
          <select class="stage-dropdown" onchange="updateStage({{ $k->id }}, 'interview_offline', this.value, this)"
                  style="{{ getDropdownStyle($k->interview_offline) }}">
            <option value="belum"       {{ $k->interview_offline=='belum'       ? 'selected' : '' }}>Belum </option>
            <option value="hadir"       {{ $k->interview_offline=='hadir'       ? 'selected' : '' }}>Hadir</option>
            <option value="tidak_hadir" {{ $k->interview_offline=='tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
            <option value="reschedule"  {{ $k->interview_offline=='reschedule'  ? 'selected' : '' }}>Reschedule</option>
            <option value="tidak_respon"{{ $k->interview_offline=='tidak_respon'? 'selected' : '' }}>Tidak Respon</option>
          </select>
        </td>

        {{-- Psikotest --}}
        <td style="padding:10px 14px; text-align:center">
          <select class="stage-dropdown" onchange="updateStage({{ $k->id }}, 'psikotest', this.value, this)"
                  style="{{ getDropdownStyle($k->psikotest) }}">
            <option value="belum"           {{ $k->psikotest=='belum'           ? 'selected' : '' }}>Belum</option>
            <option value="ok"              {{ $k->psikotest=='ok'              ? 'selected' : '' }}>OK / Lolos</option>
            <option value="ng"              {{ $k->psikotest=='ng'              ? 'selected' : '' }}>NG</option>
            <option value="dipertimbangkan" {{ $k->psikotest=='dipertimbangkan' ? 'selected' : '' }}>Dipertimbangkan</option>
            <option value="mundur"          {{ $k->psikotest=='mundur'          ? 'selected' : '' }}>Mundur</option>
          </select>
        </td>

        {{-- Status Akhir --}}
        <td style="padding:10px 14px; text-align:center">
          <span id="status-{{ $k->id }}" style="font-size:11px; font-weight:600; padding:4px 12px; border-radius:999px; {{ $statusColor }}">
            {{ ucfirst(str_replace('_',' ',$k->status_akhir)) }}
          </span>
        </td>

        {{-- Aksi --}}
        <td style="padding:10px 14px; text-align:center">
          <div style="display:flex; gap:8px; justify-content:center">
            <a href="{{ route('kandidat.show',$k) }}" style="font-size:12px; color:#1d4ed8; text-decoration:none; font-weight:500">Detail</a>
            <a href="{{ route('kandidat.edit',$k) }}" style="font-size:12px; color:#b45309; text-decoration:none; font-weight:500">Edit</a>
            <form method="POST" action="{{ route('kandidat.destroy',$k) }}" onsubmit="return confirm('Hapus {{ $k->nama }}?')" style="display:inline">
              @csrf @method('DELETE')
              <button style="font-size:12px; color:#b91c1c; background:none; border:none; cursor:pointer; font-weight:500">Hapus</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" style="padding:56px; text-align:center; color:#9ca3af">
          <div style="font-size:36px; margin-bottom:12px; opacity:.25">👥</div>
          <div style="font-size:14px; font-weight:500">Belum ada kandidat</div>
          <div style="font-size:12px; margin-top:4px">Import Excel atau tambah manual</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  </div>
  <div style="padding:14px 16px; border-top:1px solid #f5f3ef">{{ $kandidats->links() }}</div>
</div>

@php
function getDropdownStyle(string $val): string {
  return match($val) {
    'hadir','ok','terkirim','lanjut_offline','lanjut_user' => 'border-color:#1a7a4a;color:#1a7a4a;background:#f0fdf4',
    'tidak_hadir','ng','mundur','belum_lolos'              => 'border-color:#b91c1c;color:#b91c1c;background:#fef2f2',
    'reschedule','tidak_respon'                            => 'border-color:#b45309;color:#b45309;background:#fffbeb',
    'dipertimbangkan'                                      => 'border-color:#92400e;color:#92400e;background:#fffbeb',
    'sudah_dalam_proses'                                   => 'border-color:#4338ca;color:#4338ca;background:#eef2ff',
    default                                                => 'color:#9ca3af',
  };
}
@endphp

<script>
const CSRF = '{{ csrf_token() }}';

function toast(msg, ok=true) {
  const t = document.createElement('div');
  t.className = 'tp';
  t.innerHTML = `<span>${ok?'✓':'✗'}</span><span>${msg}</span>`;
  document.getElementById('toast-pip').appendChild(t);
  setTimeout(() => t.remove(), 2500);
}

function updateStage(id, tahap, status, el) {
  el.classList.add('saving');

  fetch(`/kandidat/${id}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': CSRF,
      'Accept': 'application/json',
    },
    body: JSON.stringify({ tahap, status })
  })
  .then(r => r.json())
  .then(data => {
    el.classList.remove('saving');

    // Update warna dropdown
    const styles = {
      hadir:'border-color:#1a7a4a;color:#1a7a4a;background:#f0fdf4',
      ok:'border-color:#1a7a4a;color:#1a7a4a;background:#f0fdf4',
      terkirim:'border-color:#1a7a4a;color:#1a7a4a;background:#f0fdf4',
      lanjut_offline:'border-color:#1a7a4a;color:#1a7a4a;background:#f0fdf4',
      tidak_hadir:'border-color:#b91c1c;color:#b91c1c;background:#fef2f2',
      ng:'border-color:#b91c1c;color:#b91c1c;background:#fef2f2',
      mundur:'border-color:#b91c1c;color:#b91c1c;background:#fef2f2',
      reschedule:'border-color:#b45309;color:#b45309;background:#fffbeb',
      dipertimbangkan:'border-color:#92400e;color:#92400e;background:#fffbeb',
    };
    el.style.cssText = `border:1px solid; border-radius:6px; padding:4px 8px; font-size:11px; font-weight:600; cursor:pointer; outline:none; ${styles[status]||'color:#9ca3af'}`;

    // Update badge status akhir
    if (data.status_akhir) {
      const badge = document.getElementById(`status-${id}`);
      if (badge) {
        const colors = {
          diterima:        'background:#f0fdf4;color:#1a7a4a',
          ditolak:         'background:#fef2f2;color:#b91c1c',
          dipertimbangkan: 'background:#fffbeb;color:#92400e',
          mundur:          'background:#f5f3ef;color:#6b7280',
          proses:          'background:#eef2ff;color:#4338ca',
        };
        badge.style.cssText = `font-size:11px;font-weight:600;padding:4px 12px;border-radius:999px;${colors[data.status_akhir]||''}`;
        badge.textContent = data.status_akhir.replace('_',' ');
      }
    }

    toast('Status diperbarui');
  })
  .catch(() => {
    el.classList.remove('saving');
    toast('Gagal menyimpan', false);
  });
}
</script>
@endsection