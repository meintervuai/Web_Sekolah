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
        if (! Schema::connection('tenant')->hasTable('media')) {
            Schema::connection('tenant')->create('media', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengguna_id')
                    ->nullable()
                    ->constrained('pengguna')
                    ->nullOnDelete();

                $table->string('judul', 255);
                $table->string('nama_file_asli', 255)->nullable();
                $table->string('nama_file_disimpan', 255)->nullable();
                $table->string('path', 500)->nullable();
                $table->text('url');
                $table->enum('tipe_media', ['gambar', 'video', 'dokumen', 'youtube'])->default('gambar');
                $table->string('mime_type', 100)->nullable();
                $table->string('ekstensi', 20)->nullable();
                $table->unsignedBigInteger('ukuran_bytes')->default(0);
                $table->string('dimensi', 50)->nullable();
                $table->string('kategori', 100)->default('umum');
                $table->text('alt_teks')->nullable();
                $table->enum('sumber', ['upload_langsung', 'url_eksternal', 'youtube'])->default('upload_langsung');
                $table->integer('urutan')->default(0);
                $table->timestamps();

                $table->index(['tipe_media', 'kategori']);
                $table->index('urutan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('media');
    }
};
