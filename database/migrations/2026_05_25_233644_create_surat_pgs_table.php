<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('surat_pgs', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_surat')->nullable();
        $table->string('nama_karyawan');
        $table->string('departemen')->nullable();
        $table->string('posisi')->nullable();
        $table->date('tanggal_join')->nullable();
        $table->string('pic')->nullable();
        $table->enum('status_ttd', ['belum','sudah'])->default('belum');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pgs');
    }
};
