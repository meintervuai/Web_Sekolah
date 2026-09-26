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
        if (Schema::connection('tenant')->hasTable('ekstrakurikuler')) {
            Schema::connection('tenant')->table('ekstrakurikuler', function (Blueprint $table) {
                if (! Schema::connection('tenant')->hasColumn('ekstrakurikuler', 'slug')) {
                    $table->string('slug', 150)->nullable()->after('nama_ekstrakurikuler');
                }
                if (! Schema::connection('tenant')->hasColumn('ekstrakurikuler', 'pembina')) {
                    $table->string('pembina', 150)->nullable()->after('waktu_jadwal');
                }
            });
        }

        if (Schema::connection('tenant')->hasTable('prestasi_siswa')) {
            Schema::connection('tenant')->table('prestasi_siswa', function (Blueprint $table) {
                if (! Schema::connection('tenant')->hasColumn('prestasi_siswa', 'slug')) {
                    $table->string('slug', 200)->nullable()->after('nama_prestasi');
                }
                if (! Schema::connection('tenant')->hasColumn('prestasi_siswa', 'tahun')) {
                    $table->year('tahun')->nullable()->after('tanggal');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('tenant')->hasTable('ekstrakurikuler')) {
            Schema::connection('tenant')->table('ekstrakurikuler', function (Blueprint $table) {
                if (Schema::connection('tenant')->hasColumn('ekstrakurikuler', 'slug')) {
                    $table->dropColumn('slug');
                }
                if (Schema::connection('tenant')->hasColumn('ekstrakurikuler', 'pembina')) {
                    $table->dropColumn('pembina');
                }
            });
        }

        if (Schema::connection('tenant')->hasTable('prestasi_siswa')) {
            Schema::connection('tenant')->table('prestasi_siswa', function (Blueprint $table) {
                if (Schema::connection('tenant')->hasColumn('prestasi_siswa', 'slug')) {
                    $table->dropColumn('slug');
                }
                if (Schema::connection('tenant')->hasColumn('prestasi_siswa', 'tahun')) {
                    $table->dropColumn('tahun');
                }
            });
        }
    }
};
