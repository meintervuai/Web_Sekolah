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
        // 1. Struktur Organisasi -> Relasi ke Guru/Staf (guru_id)
        Schema::connection('tenant')->table('struktur_organisasi', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->after('foto')->constrained('guru_staf')->nullOnDelete();
        });

        // 2. Slider Beranda -> Relasi ke Pengguna pembuat (pengguna_id)
        Schema::connection('tenant')->table('slider_beranda', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('is_aktif')->constrained('pengguna')->nullOnDelete();
        });

        // 3. Halaman Statis -> Relasi ke Pengguna editor/penulis (pengguna_id)
        Schema::connection('tenant')->table('halaman_statis', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('gambar_banner')->constrained('pengguna')->nullOnDelete();
        });

        // 4. Kalender Akademik -> Relasi ke Pengguna pembuat jadwal (pengguna_id)
        Schema::connection('tenant')->table('kalender_akademik', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('keterangan')->constrained('pengguna')->nullOnDelete();
        });

        // 5. Pesan Masuk -> Relasi ke Pengguna yang merespons/menandai (petugas_id)
        Schema::connection('tenant')->table('pesan_masuk', function (Blueprint $table) {
            $table->foreignId('petugas_id')->nullable()->after('is_dibaca')->constrained('pengguna')->nullOnDelete();
        });

        // 6. Pengaturan PPDB -> Relasi ke Pengguna administrator PPDB (pengguna_id)
        Schema::connection('tenant')->table('pengaturan_ppdb', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('informasi_syarat')->constrained('pengguna')->nullOnDelete();
        });

        // 7. Pengaturan Umum -> Relasi ke Pengguna pengubah terakhir (pengguna_id)
        Schema::connection('tenant')->table('pengaturan_umum', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('nilai')->constrained('pengguna')->nullOnDelete();
        });

        // 8. Pengaturan Fitur -> Relasi ke Pengguna pengubah terakhir (pengguna_id)
        Schema::connection('tenant')->table('pengaturan_fitur', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('is_aktif')->constrained('pengguna')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('pengaturan_fitur', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('pengaturan_umum', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('pengaturan_ppdb', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('pesan_masuk', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropColumn('petugas_id');
        });

        Schema::connection('tenant')->table('kalender_akademik', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('halaman_statis', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('slider_beranda', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('struktur_organisasi', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};
