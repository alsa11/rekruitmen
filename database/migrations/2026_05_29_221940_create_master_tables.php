<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('departemen')->nullable();
            $table->timestamps();
        });
        Schema::create('divisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('posisis');
        Schema::dropIfExists('divisis');
    }
};
