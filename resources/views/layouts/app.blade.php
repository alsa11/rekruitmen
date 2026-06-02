<!DOCTYPE html>
<html lang="id" class="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ config('app.name') }} — Dashboard Rekruitmen</title>
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
:root{--bg:#f9fafb;--surface:#fff;--border:#e5e7eb;--text:#111827;--muted:#6b7280;--accent:#f97316;--accent-bg:#fff7ed;--nav-hover:#f3f4f6;--nav-text:#374151;--badge-bg:#f3f4f6;--badge-text:#6b7280;--header-h:64px}
html.dark{--bg:#111827;--surface:#1f2937;--border:#374151;--text:#f9fafb;--muted:#9ca3af;--accent:#fb923c;--accent-bg:#1c1412;--nav-hover:#374151;--nav-text:#d1d5db;--badge-bg:#374151;--badge-text:#9ca3af}
*{font-family:ui-sans-serif,system-ui,-apple-system,'Segoe UI',sans-serif;box-sizing:border-box;-webkit-font-smoothing:antialiased}
body{background:var(--bg);color:var(--text);font-size:14px;margin:0;min-height:100vh}

/* TOPBAR — Tailblocks style */
#topbar{position:fixed;top:0;left:0;right:0;height:var(--header-h);background:var(--surface);border-bottom:1px solid var(--border);z-index:50}
.tb-inner{max-width:100%;height:100%;display:flex;align-items:center;padding:0 20px;gap:16px}
.tb-brand{display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0}
.tb-logo{width:36px;height:36px;border-radius:8px;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;flex-shrink:0}
.tb-brand-text{line-height:1.2}
.tb-brand-name{font-size:14px;font-weight:700;color:var(--text)}
.tb-brand-sub{font-size:10px;color:var(--muted)}
.tb-nav{display:flex;align-items:center;gap:2px;margin:0 auto}
.tb-nav a{padding:6px 12px;border-radius:6px;font-size:13px;color:var(--muted);text-decoration:none;white-space:nowrap;transition:background .1s,color .1s}
.tb-nav a:hover{background:var(--nav-hover);color:var(--text)}
.tb-nav a.active{color:var(--accent);font-weight:500}
.tb-right{display:flex;align-items:center;gap:6px;flex-shrink:0}
.btn-admin{display:inline-flex;align-items:center;gap:6px;background:var(--text);color:var(--surface);border:none;padding:7px 14px;border-radius:7px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;font-family:inherit;transition:opacity .15s}
.btn-admin:hover{opacity:.85}
.theme-btn{width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--muted)}
.theme-btn:hover{background:var(--nav-hover)}
.usr-btn{width:32px;height:32px;border-radius:50%;background:var(--text);color:var(--surface);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;font-family:inherit;position:relative}
.usr-dd{position:absolute;top:calc(var(--header-h) + 4px);right:20px;min-width:200px;background:var(--surface);border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.1);padding:6px;display:none;z-index:100}
.usr-dd.open{display:block}
.dd-user{display:flex;align-items:center;gap:10px;padding:8px 10px 10px}
.dd-av{width:30px;height:30px;border-radius:50%;background:var(--text);color:var(--surface);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700}
.dd-sep{height:1px;background:var(--border);margin:4px 0}
.dd-item{display:flex;align-items:center;gap:8px;width:100%;padding:8px 10px;border-radius:6px;font-size:13px;background:none;border:none;cursor:pointer;font-family:inherit;text-align:left;color:var(--nav-text);text-decoration:none}
.dd-item:hover{background:var(--nav-hover)}
.dd-item.danger{color:#ef4444}

/* SIDEBAR */
#sidebar{position:fixed;top:var(--header-h);left:0;bottom:0;width:var(--sidebar-w);background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;z-index:40;overflow:hidden}
.sb-scroll{flex:1;overflow-y:auto;padding:6px 0 12px}
.sb-sec{font-size:11px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);padding:14px 14px 3px}
.sb-item{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;margin:1px 6px;border-radius:6px;text-decoration:none;font-size:13.5px;color:var(--nav-text);transition:background .1s,color .1s}
.sb-item:hover{background:var(--nav-hover);color:var(--text)}
.sb-item.active{background:var(--accent-bg);color:var(--accent);font-weight:500}
.sb-item-l{display:flex;align-items:center;gap:9px}
.sb-item svg{width:16px;height:16px;flex-shrink:0;color:var(--muted)}
.sb-item.active svg{color:var(--accent)}
.sb-badge{font-size:11px;font-weight:500;padding:1px 7px;border-radius:999px;background:var(--badge-bg);color:var(--badge-text)}
.sb-badge.warn{background:#fef3c7;color:#92400e}
.sb-divider{height:1px;background:var(--border);margin:8px 12px}

#main{padding-top:var(--header-h);min-height:100vh}
#content{padding:24px 32px}
.toast-wrap{position:fixed;bottom:20px;right:20px;z-index:999}
.toast{background:var(--text);color:var(--surface);padding:11px 15px;border-radius:8px;font-size:13px;display:flex;align-items:center;gap:8px;box-shadow:0 4px 16px rgba(0,0,0,.15);animation:fadeUp .2s ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

{{-- TOPBAR Tailblocks style --}}
<header id="topbar">
  <div class="tb-inner">

    {{-- Brand kiri --}}
    <a href="{{ route('dashboard') }}" class="tb-brand">
      @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover">
      @else
        <div class="tb-logo">A</div>
      @endif
      <div class="tb-brand-text">
        <div class="tb-brand-name">HR Rekruitmen</div>
        <div class="tb-brand-sub">PT Arisamandiri Pratama</div>
      </div>
    </a>

    {{-- Nav tengah --}}
    <nav class="tb-nav">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard Analitik Rekrutmen</a>
      <a href="{{ route('join.reminder') }}" class="{{ request()->routeIs('join.reminder') ? 'active' : '' }}">
        Reminder Kontrak
        @php $rc=\App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(30)])->count(); @endphp
        @if($rc>0)<span style="background:#fef3c7;color:#92400e;font-size:10px;font-weight:600;padding:1px 6px;border-radius:999px;margin-left:4px">{{ $rc }}</span>@endif
      </a>
      <a href="/admin">Kelola Data</a>
    </nav>

    {{-- Kanan --}}
    <div class="tb-right">
      <button class="theme-btn" id="theme-btn" onclick="setTheme()">🌙</button>
      <div style="position:relative">
        <button class="usr-btn" id="usr-btn" onclick="toggleDD()">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</button>
      </div>
    </div>

  </div>

  {{-- Dropdown --}}
  <div class="usr-dd" id="usr-dd">
    <div class="dd-user">
      <div class="dd-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div>
        <div style="font-size:13px;font-weight:500;color:var(--text)">{{ auth()->user()->name }}</div>
        <div style="font-size:11px;color:var(--muted)">{{ auth()->user()->email }}</div>
      </div>
    </div>
    <div class="dd-sep"></div>
    <a href="/admin" class="dd-item">
      <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      Panel Admin
    </a>
    <div class="dd-sep"></div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="dd-item danger">
        <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        Sign out
      </button>
    </form>
  </div>
</header>



<main id="main"><div id="content">
  @if(session('success'))
  <div id="fm" class="toast-wrap">
    <div class="toast"><span style="color:#4ade80">✓</span> {{ session('success') }}</div>
  </div>
  <script>setTimeout(()=>document.getElementById('fm')?.remove(),3000)</script>
  @endif
  @yield('content')
</div></main>

<script>
function applyTheme(t){
  const d=t==='dark'||(t==='system'&&window.matchMedia('(prefers-color-scheme:dark)').matches);
  document.documentElement.classList.toggle('dark',d);
  document.getElementById('theme-btn').textContent=d?'☀️':'🌙';
}
function setTheme(t){
  if(!t){const c=localStorage.getItem('theme')||'light';t=c==='dark'?'light':'dark';}
  localStorage.setItem('theme',t);applyTheme(t);
}
(()=>applyTheme(localStorage.getItem('theme')||'light'))();
function toggleDD(){document.getElementById('usr-dd').classList.toggle('open')}
document.addEventListener('click',e=>{
  if(!e.target.closest('#usr-btn')&&!e.target.closest('#usr-dd'))
    document.getElementById('usr-dd')?.classList.remove('open');
});
</script>
</body>
</html>
