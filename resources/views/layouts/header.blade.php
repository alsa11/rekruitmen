<header class="text-gray-600 body-font border-b border-gray-200 bg-white">
  <div class="container mx-auto flex flex-wrap p-4 flex-col md:flex-row items-center">
    <a href="{{ route('dashboard') }}" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 rounded-full object-cover">
      @else
        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-content text-white font-bold text-lg flex items-center justify-center">A</div>
      @endif
      <div class="ml-3">
        <span class="text-base font-semibold text-gray-900 leading-tight block">HR Rekruitmen</span>
        <span class="text-xs text-gray-500">PT Arisamandiri Pratama</span>
      </div>
    </a>
    <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-sm justify-center gap-1">
      <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded {{ request()->routeIs('dashboard') ? 'text-orange-500 font-medium' : 'text-gray-500 hover:text-gray-900' }}">Dashboard</a>
      <a href="{{ route('join.reminder') }}" class="px-3 py-1.5 rounded {{ request()->routeIs('join.reminder') ? 'text-orange-500 font-medium' : 'text-gray-500 hover:text-gray-900' }}">
        Reminder Kontrak
        @php $rc = \App\Models\Join::whereNotNull('tgl_akhir_kontrak')->whereBetween('tgl_akhir_kontrak',[now(),now()->addDays(30)])->count(); @endphp
        @if($rc > 0)<span class="ml-1 bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $rc }}</span>@endif
      </a>
    </nav>
    <a href="/admin" target="_blank" class="inline-flex items-center gap-1.5 bg-gray-900 text-white border-0 py-1.5 px-4 rounded text-sm font-medium hover:bg-gray-700 transition">
      Kelola Data
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-3.5 h-3.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
    </a>
  </div>
</header>
