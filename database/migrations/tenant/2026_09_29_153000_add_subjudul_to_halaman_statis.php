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
        Schema::connection('tenant')->table('halaman_statis', function (Blueprint $table) {
            if (! Schema::connection('tenant')->hasColumn('halaman_statis', 'subjudul')) {
                $table->string('subjudul', 500)->nullable()->after('judul');
            }
            if (! Schema::connection('tenant')->hasColumn('halaman_statis', 'pola_latar')) {
                $table->string('pola_latar', 50)->default('dots')->after('gambar_banner');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('halaman_statis', function (Blueprint $table) {
            if (Schema::connection('tenant')->hasColumn('halaman_statis', 'pola_latar')) {
                $table->dropColumn('pola_latar');
            }
            if (Schema::connection('tenant')->hasColumn('halaman_statis', 'subjudul')) {
                $table->dropColumn('subjudul');
            }
        });
    }
};
