@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto">
  <h2 class="text-xl font-bold mb-4">Import Excel</h2>
  <div class="bg-white rounded-xl border p-6">
    <form method="POST" action="{{ route('kandidat.import.post') }}" enctype="multipart/form-data">
      @csrf
      @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4 text-sm text-red-700">
          {{ $errors->first() }}
        </div>
      @endif
      <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-blue-400 transition mb-4">
        <div class="text-3xl mb-2">📊</div>
        <p class="text-sm text-slate-500 mb-3">Upload file Excel rekruitmen kamu</p>
        <input type="file" name="file_excel" accept=".xlsx,.xls" class="text-sm w-full">
        <p class="text-xs text-slate-400 mt-2">Sheet yang akan diimport: Ghisna · Nisa · Wiwit</p>
      </div>
      <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-lg font-medium hover:bg-slate-800">
        📥 Import Sekarang
      </button>
    </form>
  </div>
</div>
@endsection
