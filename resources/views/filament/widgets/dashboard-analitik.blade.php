<div>


<style>
:root{
  --fi-primary:#f97316;
  --fi-primary-light:#fff7ed;
  --fi-gray-50:#f9fafb;
  --fi-gray-100:#f3f4f6;
  --fi-gray-200:#e5e7eb;
  --fi-gray-400:#9ca3af;
  --fi-gray-500:#6b7280;
  --fi-gray-700:#374151;
  --fi-gray-900:#111827;
  --fi-green:#16a34a;
  --fi-green-light:#f0fdf4;
  --fi-red:#dc2626;
  --fi-red-light:#fef2f2;
  --fi-blue:#2563eb;
  --fi-blue-light:#eff6ff;
  --fi-purple:#7c3aed;
  --fi-purple-light:#f5f3ff;
}
*{font-family:ui-sans-serif,system-ui,-apple-system,sans-serif;box-sizing:border-box}
body{background:#f9fafb}

/* Stats */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px}
.stat-card{background:#fff;border:1px solid var(--fi-gray-200);border-radius:12px;padding:20px 22px}
.stat-label{font-size:11px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--fi-gray-500);margin-bottom:8px}
.stat-value{font-size:2rem;font-weight:800;line-height:1;margin-bottom:4px}
.stat-sub{font-size:12px;color:var(--fi-gray-400)}
.stat-bar{height:3px;background:var(--fi-gray-100);border-radius:99px;margin-top:14px;overflow:hidden}
.stat-fill{height:100%;border-radius:99px;transition:width 1s ease}

/* Cards */
.card{background:#fff;border:1px solid var(--fi-gray-200);border-radius:12px;padding:20px 22px;margin-bottom:16px}
.card-title{font-size:13px;font-weight:600;color:var(--fi-gray-900);margin-bottom:16px;display:flex;align-items:center;justify-content:space-between}
.card-title span{font-size:12px;font-weight:400;color:var(--fi-gray-400)}

/* Grid layouts */
.grid-2{display:grid;grid-template-columns:1fr 2fr;gap:16px;margin-bottom:16px}
.grid-2r{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px}
.grid-equal{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.grid-3{display:grid;grid-template-columns:1fr 2fr;gap:16px;margin-bottom:16px}

/* Funnel */
.funnel-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--fi-gray-100)}
.funnel-row:last-child{border:none}
.funnel-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.funnel-label{font-size:13px;color:var(--fi-gray-700);flex:1;min-width:0}
.funnel-bar{flex:1;max-width:100px;height:4px;background:var(--fi-gray-100);border-radius:99px;overflow:hidden}
.funnel-bar-fill{height:100%;border-radius:99px}
.funnel-count{font-size:13px;font-weight:700;color:var(--fi-gray-900);min-width:36px;text-align:right}
.funnel-pct{font-size:11px;color:var(--fi-gray-400);min-width:32px;text-align:right}

/* Table */
.tbl{width:100%;border-collapse:collapse;font-size:13px}
.tbl th{font-size:11px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--fi-gray-500);padding:8px 10px;border-bottom:1px solid var(--fi-gray-200);text-align:left}
.tbl td{padding:10px 10px;border-bottom:1px solid var(--fi-gray-100);color:var(--fi-gray-700)}
.tbl tr:last-child td{border:none}
.tbl tr:hover td{background:var(--fi-gray-50)}
.tbl .total-row td{background:var(--fi-gray-50);font-weight:600;font-size:12px;color:var(--fi-gray-500);text-transform:uppercase;letter-spacing:.04em}

/* Badge */
.badge{display:inline-flex;align-items:center;font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px}
.badge-green{background:var(--fi-green-light);color:var(--fi-green)}
.badge-red{background:var(--fi-red-light);color:var(--fi-red)}
.badge-orange{background:var(--fi-primary-light);color:var(--fi-primary)}
.badge-blue{background:var(--fi-blue-light);color:var(--fi-blue)}
.badge-purple{background:var(--fi-purple-light);color:var(--fi-purple)}
.badge-gray{background:var(--fi-gray-100);color:var(--fi-gray-500)}

/* Avatar */
.av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0}

/* Reminder card */
.rem-card{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-radius:8px;border:1px solid;margin-bottom:8px}
.rem-crit{background:#fef2f2;border-color:#fecaca}
.rem-warn{background:#fffbeb;border-color:#fde68a}
.rem-ok{background:#f0fdf4;border-color:#bbf7d0}

/* Karyawan link */
.kar-row{display:flex;justify-content:space-between;align-items:center;padding:8px 10px;border-radius:8px;text-decoration:none;transition:background .1s}
.kar-row:hover{background:var(--fi-gray-50)}
.kar-num{font-size:15px;font-weight:800;padding:2px 10px;border-radius:6px}

/* Page header */
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px}
.page-title{font-size:18px;font-weight:700;color:var(--fi-gray-900)}
.page-sub{font-size:12px;color:var(--fi-gray-400);margin-top:2px}
</style>

{{-- Page Header --}}
<div class="page-hdr">
  <div>
    <div class="page-title">Dashboard Analitik Rekrutmen</div>
    <div class="page-sub">PT Arisamandiri Pratama · {{ now()->isoFormat('dddd, D MMMM Y') }}</div>
  </div>
  @if(isset($reminderCount) && $reminderCount > 0)
  <a href="{{ route('join.reminder') }}"
     style="display:inline-flex;align-items:center;gap:6px;background:#fffbeb;border:1px solid #fde68a;color:#92400e;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none">
    <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
    {{ $reminderCount }} kontrak habis
  </a>
  @endif
</div>

{{-- KPI Row --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Total Kandidat</div>
    <div class="stat-value" style="color:var(--fi-gray-900)">{{ number_format($stats['total_kandidat']) }}</div>
    <div class="stat-sub">Ghisna · Nisa · Wiwit</div>
    <div class="stat-bar"><div class="stat-fill" style="width:100%;background:var(--fi-gray-900)"></div></div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="color:var(--fi-green)">Diterima</div>
    <div class="stat-value" style="color:var(--fi-green)">{{ number_format($stats['diterima']) }}</div>
    <div class="stat-sub">Konversi <strong>{{ $stats['konversi'] }}%</strong></div>
    <div class="stat-bar"><div class="stat-fill" style="width:{{ max($stats['konversi'],1) }}%;background:var(--fi-green)"></div></div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="color:var(--fi-red)">Ditolak / NG</div>
    <div class="stat-value" style="color:var(--fi-red)">{{ number_format($stats['ditolak']) }}</div>
    <div class="stat-sub">Rejection {{ $stats['total_kandidat']>0 ? round($stats['ditolak']/$stats['total_kandidat']*100,1) : 0 }}%</div>
    <div class="stat-bar"><div class="stat-fill" style="width:{{ $stats['total_kandidat']>0 ? round($stats['ditolak']/$stats['total_kandidat']*100) : 0 }}%;background:var(--fi-red)"></div></div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="color:var(--fi-purple)">Sedang Proses</div>
    <div class="stat-value" style="color:var(--fi-purple)">{{ number_format($stats['proses']) }}</div>
    <div class="stat-sub">Dipertimbangkan: <strong>{{ \App\Models\Kandidat::where('status_akhir','dipertimbangkan')->count() }}</strong></div>
    <div class="stat-bar"><div class="stat-fill" style="width:{{ $stats['total_kandidat']>0 ? round($stats['proses']/$stats['total_kandidat']*100) : 0 }}%;background:var(--fi-purple)"></div></div>
  </div>
</div>

{{-- Row 2: Funnel + Line Chart --}}
<div class="grid-2">
  <div class="card">
    <div class="card-title">Tahapan Rekrutmen</div>
    @php
      $total = max($stats['total_kandidat'],1);
      $steps = [
        ['CV Masuk',          $stats['total_kandidat'],     '#111827'],
        ['Interview Online',  $funnel['interview_online'],  '#7c3aed'],
        ['App Form',          \App\Models\Kandidat::where('app_form','terkirim')->count(), '#2563eb'],
        ['Interview Offline', $funnel['interview_offline'], '#d97706'],
        ['Psikotest',         \App\Models\Kandidat::whereIn('psikotest',['ok','dipertimbangkan'])->count(), '#db2777'],
        ['Diterima',          $funnel['diterima'],          '#16a34a'],
      ];
    @endphp
    @foreach($steps as [$lbl,$n,$clr])
    @php $pct = round($n/$total*100); @endphp
    <div class="funnel-row">
      <div class="funnel-dot" style="background:{{ $clr }}"></div>
      <div class="funnel-label">{{ $lbl }}</div>
      <div class="funnel-bar"><div class="funnel-bar-fill" style="width:{{ $pct }}%;background:{{ $clr }}"></div></div>
      <div class="funnel-count">{{ number_format($n) }}</div>
      <div class="funnel-pct">{{ $pct }}%</div>
    </div>
    @endforeach
  </div>

  <div class="card">
    <div class="card-title">
      Tren Rekrutmen — 6 Bulan
      <span style="display:flex;gap:12px">
        <span style="display:flex;align-items:center;gap:4px"><span style="width:16px;height:2px;background:#111827;display:inline-block;border-radius:2px"></span>Total</span>
        <span style="display:flex;align-items:center;gap:4px"><span style="width:16px;height:2px;background:#16a34a;display:inline-block;border-radius:2px"></span>Diterima</span>
        <span style="display:flex;align-items:center;gap:4px"><span style="width:16px;height:2px;background:#dc2626;display:inline-block;border-radius:2px"></span>Ditolak</span>
      </span>
    </div>
    <canvas id="lineChart" height="120"></canvas>
  </div>
</div>

{{-- Row 3: PIC Table + Donut --}}
<div class="grid-2r">
  <div class="card">
    <div class="card-title">Performa Recruiter</div>
    <table class="tbl">
      <thead>
        <tr>
          <th>Recruiter</th>
          <th style="text-align:center">Total</th>
          <th style="text-align:center">Int. Online</th>
          <th style="text-align:center">Int. Offline</th>
          <th style="text-align:center">Diterima</th>
          <th style="text-align:center">Ditolak</th>
          <th style="text-align:center">Konversi</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($pics as $i => $pic)
        @php
          $p = $perPic[$pic];
          $avColors = [['#eff6ff','#2563eb'],['#f0fdf4','#16a34a'],['#fdf2f8','#db2777']];
          [$avBg,$avClr] = $avColors[$i % 3];
        @endphp
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:8px">
              <div class="av" style="background:{{ $avBg }};color:{{ $avClr }}">{{ strtoupper(substr($pic,0,2)) }}</div>
              <span style="font-weight:500;color:var(--fi-gray-900)">{{ $pic }}</span>
            </div>
          </td>
          <td style="text-align:center;font-weight:600;color:var(--fi-gray-900)">{{ $p['total'] }}</td>
          <td style="text-align:center;color:var(--fi-purple)">{{ $p['online'] }}</td>
          <td style="text-align:center;color:#d97706">{{ $p['offline'] }}</td>
          <td style="text-align:center;color:var(--fi-green);font-weight:700">{{ $p['diterima'] }}</td>
          <td style="text-align:center;color:var(--fi-red)">{{ $p['ditolak'] }}</td>
          <td style="text-align:center">
            <span class="badge {{ $p['pct']>=5 ? 'badge-green' : 'badge-gray' }}">{{ $p['pct'] }}%</span>
          </td>
          <td><a href="/admin/kandidats" style="font-size:12px;color:var(--fi-blue);text-decoration:none;white-space:nowrap">Detail →</a></td>
        </tr>
        @endforeach
        <tr class="total-row">
          <td>Total</td>
          <td style="text-align:center">{{ $stats['total_kandidat'] }}</td>
          <td style="text-align:center;color:var(--fi-purple)">{{ $funnel['interview_online'] }}</td>
          <td style="text-align:center;color:#d97706">{{ $funnel['interview_offline'] }}</td>
          <td style="text-align:center;color:var(--fi-green)">{{ $stats['diterima'] }}</td>
          <td style="text-align:center;color:var(--fi-red)">{{ $stats['ditolak'] }}</td>
          <td style="text-align:center"><span class="badge badge-gray">{{ $stats['konversi'] }}%</span></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="card">
    <div class="card-title">Distribusi Status</div>
    <canvas id="donutChart" height="160"></canvas>
    <div style="margin-top:14px;display:flex;flex-direction:column;gap:6px">
      @foreach([
        ['Proses',          $stats['proses'],          '#7c3aed','badge-purple'],
        ['Diterima',        $stats['diterima'],        '#16a34a','badge-green'],
        ['Ditolak',         $stats['ditolak'],         '#dc2626','badge-red'],
        ['Dipertimbangkan', \App\Models\Kandidat::where('status_akhir','dipertimbangkan')->count(), '#d97706','badge-orange'],
        ['Mundur',          \App\Models\Kandidat::where('status_akhir','mundur')->count(), '#6b7280','badge-gray'],
      ] as [$lbl,$n,$clr,$bc])
      <div style="display:flex;justify-content:space-between;align-items:center">
        <span style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--fi-gray-700)">
          <span style="width:8px;height:8px;border-radius:50%;background:{{ $clr }};flex-shrink:0;display:inline-block"></span>
          {{ $lbl }}
        </span>
        <span class="badge {{ $bc }}">{{ $n }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Row 4: Pivot + Bar --}}
<div class="grid-equal">
  <div class="card">
    <div class="card-title">Pivot Status × Recruiter</div>
    <table class="tbl">
      <thead>
        <tr>
          <th>Status</th>
          @foreach($pics as $pic)<th style="text-align:center">{{ $pic }}</th>@endforeach
          <th style="text-align:center">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach([
          ['proses','Proses','badge-purple'],
          ['diterima','Diterima','badge-green'],
          ['ditolak','Ditolak','badge-red'],
          ['dipertimbangkan','Dipertimbangkan','badge-orange'],
          ['mundur','Mundur','badge-gray'],
        ] as [$st,$lbl,$bc])
        <tr>
          <td><span class="badge {{ $bc }}">{{ $lbl }}</span></td>
          @php $rt=0; @endphp
          @foreach($pics as $pic)
            @php $n=\App\Models\Kandidat::where('pic',$pic)->where('status_akhir',$st)->count(); $rt+=$n; @endphp
            <td style="text-align:center;font-weight:{{ $n?'600':'400' }};color:{{ $n?'var(--fi-gray-900)':'var(--fi-gray-400)' }}">{{ $n ?: '—' }}</td>
          @endforeach
          <td style="text-align:center;font-weight:700;color:var(--fi-gray-900)">{{ $rt }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card">
    <div class="card-title">Komparasi Pipeline per Recruiter</div>
    <canvas id="barChart" height="180"></canvas>
  </div>
</div>

{{-- Row 5: Ringkasan + Reminder --}}
<div class="grid-3">
  <div class="card">
    <div class="card-title">Ringkasan Karyawan</div>
    @foreach([
      ['Data JOIN',        $stats['join'],          '#111827','#f5f3ef',  '/admin/joins'],
      ['OnBoard Operator', $stats['onboard_op'],    '#4338ca','#eef2ff',  '/admin/onboards/operator'],
      ['OnBoard Staff',    $stats['onboard_staff'], '#0369a1','#eff6ff',  '/admin/onboards/staff'],
      ['Onboard Bln Ini',  $stats['onboard_bulan'], '#0f766e','#f0fdfa',  '/admin/onboards'],
      ['Surat PG',         $stats['surat_pg'],      '#b45309','#fffbeb',  '/admin/surat-pgs'],
      ['Man Power OS',     $stats['os_total'],      '#be185d','#fdf2f8',  '/admin/os'],
    ] as [$lbl,$n,$tc,$bg,$link])
    <a href="{{ $link }}" class="kar-row">
      <span style="font-size:13px;color:var(--fi-gray-700)">{{ $lbl }}</span>
      <span class="kar-num" style="background:{{ $bg }};color:{{ $tc }}">{{ $n }}</span>
    </a>
    @endforeach
  </div>

  <div class="card">
    <div class="card-title">
      Reminder Kontrak Habis
      <a href="{{ route('join.reminder') }}" style="font-size:12px;color:var(--fi-blue);text-decoration:none">Lihat semua →</a>
    </div>
    @if(isset($reminders) && $reminders->count() > 0)
    <div style="max-height:260px;overflow-y:auto;display:flex;flex-direction:column;gap:8px">
      @foreach($reminders->take(6) as $r)
      @php $sisa=(int)now()->diffInDays($r->tgl_akhir_kontrak,false); @endphp
      <div class="rem-card {{ $sisa<=7?'rem-crit':($sisa<=14?'rem-warn':'rem-ok') }}">
        <div>
          <div style="font-weight:600;font-size:13px;color:var(--fi-gray-900)">{{ $r->nama }}</div>
          <div style="font-size:11px;color:var(--fi-gray-400);margin-top:2px">{{ $r->posisi }} · {{ $r->divisi }}</div>
        </div>
        <div style="text-align:right;flex-shrink:0">
          <div style="font-size:12px;font-weight:500;color:var(--fi-gray-900)">{{ $r->tgl_akhir_kontrak->format('d M Y') }}</div>
          <span class="badge {{ $sisa<=7?'badge-red':($sisa<=14?'badge-orange':'badge-green') }}" style="margin-top:3px">{{ $sisa }}h</span>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align:center;padding:32px;color:var(--fi-gray-400)">
      <div style="font-size:24px;margin-bottom:8px">✓</div>
      <div style="font-size:13px">Tidak ada kontrak yang akan habis</div>
    </div>
    @endif
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const grid='#f3f4f6', tick={family:'ui-sans-serif,system-ui,sans-serif',size:11};

@php
  $months=[];$totM=[];$ditM=[];$ditolakM=[];
  for($i=5;$i>=0;$i--){
    $b=now()->subMonths($i);
    $months[]=$b->format('M Y');
    $totM[]=\App\Models\Kandidat::whereMonth('created_at',$b->month)->whereYear('created_at',$b->year)->count();
    $ditM[]=\App\Models\Kandidat::where('status_akhir','diterima')->whereMonth('updated_at',$b->month)->whereYear('updated_at',$b->year)->count();
    $ditolakM[]=\App\Models\Kandidat::where('status_akhir','ditolak')->whereMonth('updated_at',$b->month)->whereYear('updated_at',$b->year)->count();
  }
@endphp

new Chart(document.getElementById('lineChart'),{
  type:'line',
  data:{
    labels:{!! json_encode($months) !!},
    datasets:[
      {label:'Total',data:{!! json_encode($totM) !!},borderColor:'#111827',backgroundColor:'rgba(17,24,39,0.04)',borderWidth:2,pointRadius:4,pointBackgroundColor:'#111827',tension:0.3,fill:true},
      {label:'Diterima',data:{!! json_encode($ditM) !!},borderColor:'#16a34a',backgroundColor:'transparent',borderWidth:2,pointRadius:4,pointBackgroundColor:'#16a34a',tension:0.3},
      {label:'Ditolak',data:{!! json_encode($ditolakM) !!},borderColor:'#dc2626',backgroundColor:'transparent',borderWidth:2,pointRadius:4,pointBackgroundColor:'#dc2626',tension:0.3,borderDash:[4,4]},
    ]
  },
  options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:grid},ticks:{font:tick}},x:{grid:{display:false},ticks:{font:tick}}}}
});

new Chart(document.getElementById('donutChart'),{
  type:'doughnut',
  data:{
    labels:['Proses','Diterima','Ditolak','Dipertimbangkan','Mundur'],
    datasets:[{
      data:[{{ $stats['proses'] }},{{ $stats['diterima'] }},{{ $stats['ditolak'] }},{{ \App\Models\Kandidat::where('status_akhir','dipertimbangkan')->count() }},{{ \App\Models\Kandidat::where('status_akhir','mundur')->count() }}],
      backgroundColor:['#7c3aed','#16a34a','#dc2626','#d97706','#9ca3af'],
      borderWidth:3,borderColor:'#fff',
    }]
  },
  options:{cutout:'68%',plugins:{legend:{display:false}}}
});

new Chart(document.getElementById('barChart'),{
  type:'bar',
  data:{
    labels:{!! json_encode($pics) !!},
    datasets:[
      {label:'Int. Online', data:{!! json_encode(array_map(fn($p)=>$perPic[$p]['online'],$pics)) !!},backgroundColor:'#c4b5fd',borderRadius:4},
      {label:'Int. Offline',data:{!! json_encode(array_map(fn($p)=>$perPic[$p]['offline'],$pics)) !!},backgroundColor:'#fde68a',borderRadius:4},
      {label:'Diterima',    data:{!! json_encode(array_map(fn($p)=>$perPic[$p]['diterima'],$pics)) !!},backgroundColor:'#86efac',borderRadius:4},
      {label:'Ditolak',     data:{!! json_encode(array_map(fn($p)=>$perPic[$p]['ditolak'],$pics)) !!},backgroundColor:'#fca5a5',borderRadius:4},
    ]
  },
  options:{responsive:true,plugins:{legend:{position:'bottom',labels:{boxWidth:10,font:tick}}},scales:{y:{beginAtZero:true,grid:{color:grid},ticks:{font:tick}},x:{grid:{display:false},ticks:{font:tick}}}}
});
</script>

</div>
