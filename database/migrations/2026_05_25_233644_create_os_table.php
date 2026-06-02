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
    Schema::create('os', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('no_wa')->nullable();
        $table->string('posisi')->nullable();
        $table->string('pic')->nullable();
        $table->enum('interview_online', ['belum','hadir','tidak_hadir','reschedule'])->default('belum');
        $table->text('ket_interview_online')->nullable();
        $table->enum('interview_offline', ['belum','hadir','tidak_hadir','reschedule'])->default('belum');
        $table->enum('hasil', ['belum','ok','ng','dipertimbangkan'])->default('belum');
        $table->text('ket_hasil')->nullable();
        $table->enum('status_akhir', ['proses','diterima','ditolak','dipertimbangkan','mundur'])->default('proses');
        $table->date('tanggal_join')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('os');
    }
};
