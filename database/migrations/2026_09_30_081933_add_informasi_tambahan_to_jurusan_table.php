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
        Schema::connection('tenant')->table('jurusan', function (Blueprint $table) {
            if (!Schema::connection('tenant')->hasColumn('jurusan', 'informasi_tambahan')) {
                $table->longText('informasi_tambahan')->nullable()->after('deskripsi_lengkap');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('jurusan', function (Blueprint $table) {
            if (Schema::connection('tenant')->hasColumn('jurusan', 'informasi_tambahan')) {
                $table->dropColumn('informasi_tambahan');
            }
        });
    }
};

