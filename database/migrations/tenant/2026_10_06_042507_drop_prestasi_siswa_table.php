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
        Schema::connection('tenant')->dropIfExists('prestasi_siswa');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->create('prestasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa', 150);
            $table->string('nama_prestasi', 200);
            $table->string('slug', 200)->nullable();
            $table->string('tingkat', 100)->nullable();
            $table->date('tanggal')->nullable();
            $table->year('tahun')->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->nullOnDelete();
            $table->timestamps();
        });
    }
};

