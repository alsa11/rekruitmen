<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('kandidats', function (Blueprint $table) {
            if (!Schema::hasColumn('kandidats', 'cv_file'))
                $table->string('cv_file')->nullable()->after('cv_link');
            if (!Schema::hasColumn('kandidats', 'app_form_file'))
                $table->string('app_form_file')->nullable()->after('cv_file');
        });
    }
    public function down(): void {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropColumn(['cv_file','app_form_file']);
        });
    }
};
