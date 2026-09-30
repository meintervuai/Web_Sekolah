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
            $table->string('logo', 255)->nullable()->after('singkatan');
            $table->string('jenjang', 50)->nullable()->default('SMK (3 Tahun)')->after('deskripsi_lengkap');
            $table->string('peluang_kerja', 255)->nullable()->default('Industri & Wirausaha')->after('jenjang');
            $table->string('sertifikasi', 255)->nullable()->default('LSP-P1 / BNSP')->after('peluang_kerja');
        });

        Schema::connection('tenant')->create('foto_jurusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusan')->cascadeOnDelete();
            $table->string('file_foto', 255);
            $table->string('judul', 150)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('foto_jurusan');

        Schema::connection('tenant')->table('jurusan', function (Blueprint $table) {
            $table->dropColumn(['logo', 'jenjang', 'peluang_kerja', 'sertifikasi']);
        });
    }
};
