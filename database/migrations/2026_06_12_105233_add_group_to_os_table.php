<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('os', function (Blueprint $table) {
            if (!Schema::hasColumn('os', 'posisi_group'))
                $table->string('posisi_group')->nullable()->after('posisi');
        });
    }
    public function down(): void {
        Schema::table('os', function (Blueprint $table) {
            $table->dropColumn('posisi_group');
        });
    }
};
