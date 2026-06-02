<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('os', function (Blueprint $table) {
            $table->string('placement')->nullable()->after('posisi');
            $table->integer('qty')->nullable()->after('placement');
            $table->string('keterangan')->nullable()->after('qty');
            $table->date('tgl_approval')->nullable()->after('keterangan');
        });
    }
    public function down(): void
    {
        Schema::table('os', function (Blueprint $table) {
            $table->dropColumn(['placement','qty','keterangan','tgl_approval']);
        });
    }
};
