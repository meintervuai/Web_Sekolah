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
        // Hubungkan tabel sosial_media ke pengguna (pengguna_id)
        if (Schema::connection('tenant')->hasTable('sosial_media') && ! Schema::connection('tenant')->hasColumn('sosial_media', 'pengguna_id')) {
            Schema::connection('tenant')->table('sosial_media', function (Blueprint $table) {
                $table->foreignId('pengguna_id')->nullable()->after('is_aktif')->constrained('pengguna')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('tenant')->hasTable('sosial_media') && Schema::connection('tenant')->hasColumn('sosial_media', 'pengguna_id')) {
            Schema::connection('tenant')->table('sosial_media', function (Blueprint $table) {
                $table->dropForeign(['pengguna_id']);
                $table->dropColumn('pengguna_id');
            });
        }
    }
};
