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
    Schema::create('onboards', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nik_ktp', 20)->nullable();
        $table->date('onboarding_date')->nullable();
        $table->date('join_date')->nullable();
        $table->string('job_title')->nullable();
        $table->enum('level', ['staff','operator'])->default('staff');
        $table->string('departemen')->nullable();
        $table->string('divisi')->nullable();
        $table->string('email')->nullable();
        $table->string('no_hp')->nullable();
        $table->string('alamat')->nullable();
        $table->enum('status_kontrak', ['kontrak','tetap','magang'])->default('kontrak');
        $table->string('lama_kontrak')->nullable();
        $table->string('pic')->nullable();
        $table->string('lokasi')->nullable();
        $table->string('status_makan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboards');
    }
};
