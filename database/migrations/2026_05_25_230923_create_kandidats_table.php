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
    Schema::create('kandidats', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('no_wa')->nullable();
        $table->string('posisi');
        $table->string('departemen')->nullable();
        $table->date('tanggal_interview')->nullable();
        $table->string('jam_interview')->nullable();
        $table->string('pic')->nullable();
        $table->string('user_interviewer')->nullable();
        $table->string('cv_link')->nullable();
        $table->string('cv_status')->nullable();
        $table->enum('interview_online', ['belum','hadir','tidak_hadir','reschedule','sudah_dalam_proses','belum_lolos'])->default('belum');
        $table->text('ket_interview_online')->nullable();
        $table->enum('app_form', ['belum','terkirim','lanjut_offline','lanjut_user','dialihkan','mundur'])->default('belum');
        $table->text('ket_app_form')->nullable();
        $table->enum('interview_offline', ['belum','hadir','tidak_hadir','reschedule','tidak_respon'])->default('belum');
        $table->enum('hasil_offline', ['belum','ok','ng','dipertimbangkan'])->default('belum');
        $table->text('ket_offline')->nullable();
        $table->enum('psikotest', ['belum','ok','ng','dipertimbangkan','mundur'])->default('belum');
        $table->text('ket_psikotest')->nullable();
        $table->enum('status_akhir', ['proses','diterima','ditolak','dipertimbangkan','mundur','dialihkan'])->default('proses');
        $table->date('tanggal_join')->nullable();
        $table->text('catatan')->nullable();
        $table->string('sumber_sheet')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
