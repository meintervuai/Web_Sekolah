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
        // 1. Relasi Jurusan -> Kepala Program / Guru (FK guru_id)
        Schema::connection('tenant')->table('jurusan', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->after('urutan')->constrained('guru_staf')->nullOnDelete();
        });

        // 2. Relasi Ekstrakurikuler -> Guru Pembina (FK guru_id)
        Schema::connection('tenant')->table('ekstrakurikuler', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->after('pembina')->constrained('guru_staf')->nullOnDelete();
        });

        // 3. Relasi Prestasi Siswa -> Jurusan (FK jurusan_id)
        Schema::connection('tenant')->table('prestasi_siswa', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->after('deskripsi')->constrained('jurusan')->nullOnDelete();
        });

        // 4. Relasi Agenda -> Pengguna Pembuat (FK pengguna_id)
        Schema::connection('tenant')->table('agenda', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('is_aktif')->constrained('pengguna')->nullOnDelete();
        });

        // 5. Relasi Unduhan -> Pengguna Pengunggah (FK pengguna_id)
        Schema::connection('tenant')->table('unduhan', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->after('jumlah_unduh')->constrained('pengguna')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->table('unduhan', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('agenda', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });

        Schema::connection('tenant')->table('prestasi_siswa', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });

        Schema::connection('tenant')->table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });

        Schema::connection('tenant')->table('jurusan', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};
