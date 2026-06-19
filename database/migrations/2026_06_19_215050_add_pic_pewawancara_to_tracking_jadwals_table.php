<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('tracking_jadwals', function (Blueprint $table) {
            if (!Schema::hasColumn('tracking_jadwals', 'pic_pewawancara'))
                $table->string('pic_pewawancara')->nullable()->after('sourcing');
        });
    }
    public function down(): void {
        Schema::table('tracking_jadwals', function (Blueprint $table) {
            $table->dropColumn('pic_pewawancara');
        });
    }
};
