<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('os', function (Blueprint $table) {
            if (!Schema::hasColumn('os', 'os_filled'))
                $table->integer('os_filled')->default(0)->after('qty');
            if (!Schema::hasColumn('os', 'divisi'))
                $table->string('divisi')->nullable()->after('posisi');
        });
    }
    public function down(): void {
        Schema::table('os', function (Blueprint $table) {
            $table->dropColumn(['os_filled','divisi']);
        });
    }
};
