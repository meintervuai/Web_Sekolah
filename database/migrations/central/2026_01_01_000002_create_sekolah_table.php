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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_sekolah', 200);
            $table->string('slug', 200)->unique();
            $table->enum('jenjang', ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN']);
            $table->boolean('status_aktif')->default(true);
            $table->date('tgl_berakhir')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
