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
        if (! Schema::connection('tenant')->hasTable('agenda')) {
            Schema::connection('tenant')->create('agenda', function (Blueprint $table) {
                $table->id();
                $table->string('judul', 255);
                $table->string('slug', 255)->unique();
                $table->text('ringkasan')->nullable();
                $table->longText('deskripsi_lengkap')->nullable();
                $table->date('tgl_mulai');
                $table->date('tgl_selesai')->nullable();
                $table->string('jam_mulai', 50)->nullable();
                $table->string('jam_selesai', 50)->nullable();
                $table->string('lokasi', 255)->nullable();
                $table->string('penyelenggara', 150)->nullable();
                $table->string('gambar_sampul', 255)->nullable();
                $table->string('link_pendaftaran', 255)->nullable();
                $table->boolean('is_aktif')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('agenda');
    }
};
