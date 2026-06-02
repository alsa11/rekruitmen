<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('joins', function (Blueprint $table) {
            $table->string('laptop_needs')->nullable()->after('penempatan');
            $table->string('laptop_memo')->nullable()->after('laptop_needs');
            $table->string('rek_danamon')->nullable()->after('laptop_memo');
        });
    }
    public function down(): void {
        Schema::table('joins', function (Blueprint $table) {
            $table->dropColumn(['laptop_needs','laptop_memo','rek_danamon']);
        });
    }
};
