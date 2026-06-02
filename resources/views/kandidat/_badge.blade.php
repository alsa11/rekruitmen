@php
$c = match($v ?? 'belum') {
  'hadir','ok','diterima'       => 'bg-green-100 text-green-700',
  'tidak_hadir','ng','ditolak'  => 'bg-red-100 text-red-600',
  'dipertimbangkan'             => 'bg-yellow-100 text-yellow-700',
  'mundur','dialihkan'          => 'bg-slate-100 text-slate-500',
  'reschedule'                  => 'bg-orange-100 text-orange-600',
  'proses','sudah_dalam_proses' => 'bg-blue-100 text-blue-600',
  default                       => 'bg-slate-100 text-slate-400',
};
@endphp
<span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $c }}">{{ str_replace('_',' ',$v ?? 'belum') }}</span>
