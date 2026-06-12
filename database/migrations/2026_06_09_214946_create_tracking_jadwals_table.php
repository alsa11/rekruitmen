<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tracking_jadwals', function (Blueprint $table) {
            $table->id();
            $table->string('posisi');
            $table->date('tanggal');
            $table->string('jam')->nullable();
            $table->string('tipe_kegiatan')->default('online'); // online, test_onsite, intvw_user
            $table->string('sourcing')->nullable();
            $table->string('pic_hrd')->nullable();
            $table->string('pic_intern')->nullable();
            $table->string('link_gmeet')->nullable();
            $table->enum('status', ['pending','done','cancel'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tracking_jadwals');
    }
};
