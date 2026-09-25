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
        // 1. Pengguna
        Schema::connection('tenant')->create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->enum('peran', ['admin', 'operator', 'penulis'])->default('operator');
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Pengaturan Umum
        Schema::connection('tenant')->create('pengaturan_umum', function (Blueprint $table) {
            $table->id();
            $table->string('kunci', 100)->unique();
            $table->longText('nilai')->nullable();
            $table->timestamps();
        });

        // 3. Pengaturan Fitur
        Schema::connection('tenant')->create('pengaturan_fitur', function (Blueprint $table) {
            $table->id();
            $table->string('kode_fitur', 100)->unique();
            $table->string('nama_fitur', 150);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 4. Sosial Media
        Schema::connection('tenant')->create('sosial_media', function (Blueprint $table) {
            $table->id();
            $table->string('nama_platform', 50);
            $table->string('ikon', 50);
            $table->string('url', 255);
            $table->integer('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 5. Halaman Statis
        Schema::connection('tenant')->create('halaman_statis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('slug', 200)->unique();
            $table->longText('isi_konten');
            $table->string('gambar_banner', 255)->nullable();
            $table->timestamps();
        });

        // 6. Slider Beranda
        Schema::connection('tenant')->create('slider_beranda', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200)->nullable();
            $table->string('subjudul', 255)->nullable();
            $table->string('gambar', 255);
            $table->string('link_tombol', 255)->nullable();
            $table->string('teks_tombol', 50)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 7. Struktur Organisasi
        Schema::connection('tenant')->create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 150);
            $table->string('jabatan', 100);
            $table->string('foto', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // 8. Guru & Staf
        Schema::connection('tenant')->create('guru_staf', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->nullable();
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('jabatan', 100);
            $table->string('mata_pelajaran', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        // 9. Jurusan
        Schema::connection('tenant')->create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan', 150);
            $table->string('singkatan', 20)->nullable();
            $table->string('slug', 150)->unique();
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('ikon_atau_foto', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 10. Ekstrakurikuler
        Schema::connection('tenant')->create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekskul', 150);
            $table->string('slug', 150)->unique();
            $table->string('nama_pembina', 150)->nullable();
            $table->string('jadwal_kegiatan', 100)->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('foto_utama', 255)->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 11. Fasilitas
        Schema::connection('tenant')->create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas', 150);
            $table->text('deskripsi')->nullable();
            $table->string('foto_utama', 255);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 12. Foto Fasilitas
        Schema::connection('tenant')->create('foto_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fasilitas_id')->constrained('fasilitas')->cascadeOnDelete();
            $table->string('file_foto', 255);
            $table->string('keterangan', 200)->nullable();
            $table->timestamps();
        });

        // 13. Kalender Akademik
        Schema::connection('tenant')->create('kalender_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan', 200);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 14. Kategori Artikel
        Schema::connection('tenant')->create('kategori_artikel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 100);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        // 15. Artikel
        Schema::connection('tenant')->create('artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori_artikel')->restrictOnDelete();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi_konten');
            $table->string('gambar_sampul', 255)->nullable();
            $table->boolean('is_pengumuman')->default(false);
            $table->enum('status_publikasi', ['draft', 'published'])->default('published');
            $table->dateTime('tgl_publikasi')->useCurrent();
            $table->integer('jumlah_dilihat')->default(0);
            $table->timestamps();
        });

        // 16. Galeri Album
        Schema::connection('tenant')->create('galeri_album', function (Blueprint $table) {
            $table->id();
            $table->string('nama_album', 150);
            $table->string('slug', 150)->unique();
            $table->enum('tipe', ['foto', 'video'])->default('foto');
            $table->text('deskripsi')->nullable();
            $table->string('cover_album', 255)->nullable();
            $table->timestamps();
        });

        // 17. Galeri Item
        Schema::connection('tenant')->create('galeri_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('galeri_album')->cascadeOnDelete();
            $table->string('file_media_atau_link', 255);
            $table->string('judul_item', 150)->nullable();
            $table->timestamps();
        });

        // 18. Prestasi
        Schema::connection('tenant')->create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penghargaan', 200);
            $table->enum('tingkat', ['Kecamatan', 'Kota/Kabupaten', 'Provinsi', 'Nasional', 'Internasional']);
            $table->string('peraih_prestasi', 150);
            $table->date('tgl_perolehan')->nullable();
            $table->string('foto_dokumentasi', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 19. Unduhan
        Schema::connection('tenant')->create('unduhan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen', 200);
            $table->string('kategori_dokumen', 100)->nullable();
            $table->string('file_path', 255);
            $table->string('ekstensi', 10);
            $table->string('ukuran_file', 20);
            $table->integer('jumlah_unduh')->default(0);
            $table->timestamps();
        });

        // 20. Pesan Masuk
        Schema::connection('tenant')->create('pesan_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengirim', 150);
            $table->string('email_pengirim', 150);
            $table->string('no_telepon', 50)->nullable();
            $table->string('subjek', 200);
            $table->text('pesan');
            $table->boolean('is_dibaca')->default(false);
            $table->timestamps();
        });

        // 21. Pengaturan PPDB
        Schema::connection('tenant')->create('pengaturan_ppdb', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_buka')->default(false);
            $table->enum('mode_ppdb', ['internal', 'eksternal'])->default('eksternal');
            $table->string('link_eksternal', 255)->nullable();
            $table->string('tahun_ajaran', 20);
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->longText('informasi_syarat')->nullable();
            $table->timestamps();
        });

        // 22. Pendaftar PPDB
        Schema::connection('tenant')->create('pendaftar_ppdb', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran', 50)->unique();
            $table->string('nisn', 20)->nullable();
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100);
            $table->date('tgl_lahir');
            $table->string('asal_sekolah', 150);
            $table->string('nama_wali', 150);
            $table->string('no_whatsapp_wali', 30);
            $table->text('alamat_lengkap');
            $table->foreignId('pilihan_jurusan_id')->nullable()->constrained('jurusan')->nullOnDelete();
            $table->enum('status_verifikasi', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('pendaftar_ppdb');
        Schema::connection('tenant')->dropIfExists('pengaturan_ppdb');
        Schema::connection('tenant')->dropIfExists('pesan_masuk');
        Schema::connection('tenant')->dropIfExists('unduhan');
        Schema::connection('tenant')->dropIfExists('prestasi');
        Schema::connection('tenant')->dropIfExists('galeri_item');
        Schema::connection('tenant')->dropIfExists('galeri_album');
        Schema::connection('tenant')->dropIfExists('artikel');
        Schema::connection('tenant')->dropIfExists('kategori_artikel');
        Schema::connection('tenant')->dropIfExists('kalender_akademik');
        Schema::connection('tenant')->dropIfExists('foto_fasilitas');
        Schema::connection('tenant')->dropIfExists('fasilitas');
        Schema::connection('tenant')->dropIfExists('ekstrakurikuler');
        Schema::connection('tenant')->dropIfExists('jurusan');
        Schema::connection('tenant')->dropIfExists('guru_staf');
        Schema::connection('tenant')->dropIfExists('struktur_organisasi');
        Schema::connection('tenant')->dropIfExists('slider_beranda');
        Schema::connection('tenant')->dropIfExists('halaman_statis');
        Schema::connection('tenant')->dropIfExists('sosial_media');
        Schema::connection('tenant')->dropIfExists('pengaturan_fitur');
        Schema::connection('tenant')->dropIfExists('pengaturan_umum');
        Schema::connection('tenant')->dropIfExists('pengguna');
    }
};
