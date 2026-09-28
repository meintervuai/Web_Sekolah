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
        // Hubungkan super_admin sebagai penanggung jawab/pembuat entitas sekolah
        Schema::table('sekolah', function (Blueprint $table) {
            $table->foreignId('super_admin_id')->nullable()->after('id')->constrained('super_admin')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->dropForeign(['super_admin_id']);
            $table->dropColumn('super_admin_id');
        });
    }
};
