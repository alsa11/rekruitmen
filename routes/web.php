<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\KandidatController;

Route::middleware(['auth','verified'])->group(function () {

    // Halaman utama = Dashboard analitik
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    // Reminder kontrak
    Route::get('/reminder-kontrak', [JoinController::class,'reminder'])->name('join.reminder');

    // Import/Export (tetap di custom karena pakai logic khusus)
    Route::get('/import',  [KandidatController::class,'importForm'])->name('kandidat.import');
    Route::post('/import', [KandidatController::class,'import'])->name('kandidat.import.post');
    Route::get('/export',  [KandidatController::class,'export'])->name('kandidat.export');

    // Redirect semua CRUD ke Filament /admin
    Route::get('/kandidat',       fn() => redirect('/admin/kandidats'))->name('kandidat.index');
    Route::get('/pipeline/{pic}', fn($pic) => redirect('/admin/kandidats?tableFilters[pic][value]='.$pic))->name('kandidat.pipeline');
    Route::get('/join',           fn() => redirect('/admin/joins'))->name('join.index');
    Route::get('/onboard',        fn() => redirect('/admin/onboards'))->name('onboard.index');
    Route::get('/surat-pg',       fn() => redirect('/admin/surat-pgs'))->name('surat-pg.index');
    Route::get('/os',             fn() => redirect('/admin/os'))->name('os.index');

});

require __DIR__.'/auth.php';

// Import
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/import-data',  [App\Http\Controllers\ImportController::class,'index'])->name('import.index');
    Route::post('/import-data', [App\Http\Controllers\ImportController::class,'import'])->name('import.post');
});
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/export/{type}', [App\Http\Controllers\ImportController::class,'export'])->name('export');
});
