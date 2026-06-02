<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE os MODIFY COLUMN status_akhir ENUM('proses','diterima','ditolak','dipertimbangkan','mundur','keluar') DEFAULT 'diterima'");
    }
    public function down(): void
    {
        DB::statement("ALTER TABLE os MODIFY COLUMN status_akhir ENUM('proses','diterima','ditolak','dipertimbangkan','mundur') DEFAULT 'proses'");
    }
};
