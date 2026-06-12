<x-filament-widgets::widget>
<x-filament::section>
  <x-slot name="heading">Reminder Kontrak Habis</x-slot>

  @if($reminders->count() > 0)
  <div class="overflow-x-auto">
  <table class="w-full text-sm">
    <thead>
      <tr class="border-b border-gray-200 dark:border-gray-700">
        <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Nama</th>
        <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Posisi</th>
        <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Divisi</th>
        <th class="text-left py-2 px-3 text-xs font-semibold text-gray-500 uppercase">PIC</th>
        <th class="text-center py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Akhir Kontrak</th>
        <th class="text-center py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Sisa</th>
        <th class="text-center py-2 px-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($reminders as $r)
      @php $sisa = (int)now()->diffInDays($r->tgl_akhir_kontrak, false); @endphp
      <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800">
        <td class="py-2.5 px-3 font-medium">{{ $r->nama }}</td>
        <td class="py-2.5 px-3 text-gray-500 text-xs">{{ $r->posisi }}</td>
        <td class="py-2.5 px-3 text-gray-500 text-xs">{{ $r->divisi }}</td>
        <td class="py-2.5 px-3 text-xs">
          <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
            {{ $r->pic ?? '—' }}
          </span>
        </td>
        <td class="py-2.5 px-3 text-center text-xs text-gray-500">{{ $r->tgl_akhir_kontrak->format('d M Y') }}</td>
        <td class="py-2.5 px-3 text-center">
          <span class="px-2 py-0.5 rounded-full text-xs font-bold
            {{ $sisa <= 7 ? 'bg-red-100 text-red-700' : ($sisa <= 14 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
            {{ $sisa }} hari
          </span>
        </td>
        <td class="py-2.5 px-3 text-center">
          <span class="px-2 py-0.5 rounded-full text-xs font-bold text-white
            {{ $sisa <= 7 ? 'bg-red-500' : ($sisa <= 14 ? 'bg-yellow-500' : 'bg-green-500') }}">
            {{ $sisa <= 7 ? 'Kritis' : ($sisa <= 14 ? 'Segera' : 'Perhatian') }}
          </span>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  @else
  <div class="text-center py-8 text-gray-400">
    <div class="text-3xl mb-2">✓</div>
    <div class="text-sm">Tidak ada kontrak habis dalam 30 hari</div>
  </div>
  @endif

</x-filament::section>
</x-filament-widgets::widget>
