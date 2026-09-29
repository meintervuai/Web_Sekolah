<?php

namespace Database\Seeders;

use App\Models\Tenant\Media;
use App\Models\Tenant\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Pengguna::first();
        $adminId = $admin ? $admin->id : null;

        $daftarMedia = [];

        // 1. Slider Beranda
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('slider_beranda')) {
            $sliders = DB::connection('tenant')->table('slider_beranda')->get();
            foreach ($sliders as $s) {
                if (! empty($s->gambar)) {
                    $daftarMedia[] = [
                        'judul' => 'Slider: '.($s->judul ?: 'Banner Beranda'),
                        'url' => $s->gambar,
                        'tipe_media' => 'gambar',
                        'kategori' => 'banner',
                        'sumber' => str_starts_with($s->gambar, 'http') ? 'url_eksternal' : 'upload_langsung',
                    ];
                }
                if (! empty($s->video)) {
                    $isYt = Str::contains($s->video, ['youtube.com', 'youtu.be']);
                    $daftarMedia[] = [
                        'judul' => 'Video Slider: '.($s->judul ?: 'Video Beranda'),
                        'url' => $s->video,
                        'tipe_media' => $isYt ? 'youtube' : 'video',
                        'kategori' => 'banner',
                        'sumber' => $isYt ? 'youtube' : (str_starts_with($s->video, 'http') ? 'url_eksternal' : 'upload_langsung'),
                    ];
                }
            }
        }

        // 2. Jurusan
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('jurusan')) {
            $jurusans = DB::connection('tenant')->table('jurusan')->get();
            foreach ($jurusans as $j) {
                if (! empty($j->gambar)) {
                    $daftarMedia[] = [
                        'judul' => 'Jurusan: '.$j->nama_jurusan,
                        'url' => $j->gambar,
                        'tipe_media' => 'gambar',
                        'kategori' => 'jurusan',
                        'sumber' => str_starts_with($j->gambar, 'http') ? 'url_eksternal' : 'upload_langsung',
                    ];
                }
            }
        }

        // 3. Galeri Item & Album
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('galeri_item')) {
            $galeriItems = DB::connection('tenant')->table('galeri_item')->get();
            foreach ($galeriItems as $g) {
                if (! empty($g->file_media_atau_link)) {
                    $isYt = Str::contains($g->file_media_atau_link, ['youtube.com', 'youtu.be']);
                    $daftarMedia[] = [
                        'judul' => ($g->judul_item ?? '') ?: 'Item Galeri',
                        'url' => $g->file_media_atau_link,
                        'tipe_media' => $isYt ? 'youtube' : 'gambar',
                        'kategori' => 'galeri',
                        'sumber' => $isYt ? 'youtube' : (str_starts_with($g->file_media_atau_link, 'http') ? 'url_eksternal' : 'upload_langsung'),
                    ];
                }
            }
        }

        // 4. Fasilitas
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('fasilitas')) {
            $fasilitas = DB::connection('tenant')->table('fasilitas')->get();
            foreach ($fasilitas as $f) {
                if (! empty($f->foto_utama)) {
                    $daftarMedia[] = [
                        'judul' => 'Fasilitas: '.$f->nama_fasilitas,
                        'url' => $f->foto_utama,
                        'tipe_media' => 'gambar',
                        'kategori' => 'fasilitas',
                        'sumber' => str_starts_with($f->foto_utama, 'http') ? 'url_eksternal' : 'upload_langsung',
                    ];
                }
            }
        }

        // 5. Guru & Staf
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('guru_staf')) {
            $gurus = DB::connection('tenant')->table('guru_staf')->take(10)->get();
            foreach ($gurus as $gu) {
                if (! empty($gu->foto)) {
                    $daftarMedia[] = [
                        'judul' => 'Foto Guru: '.$gu->nama_lengkap,
                        'url' => $gu->foto,
                        'tipe_media' => 'gambar',
                        'kategori' => 'guru',
                        'sumber' => str_starts_with($gu->foto, 'http') ? 'url_eksternal' : 'upload_langsung',
                    ];
                }
            }
        }

        // 6. Prestasi Siswa
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('prestasi_siswa')) {
            $prestasis = DB::connection('tenant')->table('prestasi_siswa')->get();
            foreach ($prestasis as $p) {
                if (! empty($p->foto_dokumentasi)) {
                    $daftarMedia[] = [
                        'judul' => 'Prestasi: '.$p->judul_prestasi,
                        'url' => $p->foto_dokumentasi,
                        'tipe_media' => 'gambar',
                        'kategori' => 'prestasi',
                        'sumber' => str_starts_with($p->foto_dokumentasi, 'http') ? 'url_eksternal' : 'upload_langsung',
                    ];
                }
            }
        }

        // 7. Pengaturan Umum (Logo & Video Profil)
        if (DB::connection('tenant')->getSchemaBuilder()->hasTable('pengaturan_umum')) {
            $videoProfil = DB::connection('tenant')->table('pengaturan_umum')->where('kunci', 'video_profil')->value('nilai');
            if (! empty($videoProfil)) {
                $isYt = Str::contains($videoProfil, ['youtube.com', 'youtu.be']);
                $daftarMedia[] = [
                    'judul' => 'Video Profil Resmi Sekolah',
                    'url' => $videoProfil,
                    'tipe_media' => $isYt ? 'youtube' : 'video',
                    'kategori' => 'profil',
                    'sumber' => $isYt ? 'youtube' : (str_starts_with($videoProfil, 'http') ? 'url_eksternal' : 'upload_langsung'),
                ];
            }

            $heroBanner = DB::connection('tenant')->table('pengaturan_umum')->where('kunci', 'hero_banner')->value('nilai');
            if (! empty($heroBanner)) {
                $daftarMedia[] = [
                    'judul' => 'Hero Banner Utama Sekolah',
                    'url' => $heroBanner,
                    'tipe_media' => 'gambar',
                    'kategori' => 'banner',
                    'sumber' => str_starts_with($heroBanner, 'http') ? 'url_eksternal' : 'upload_langsung',
                ];
            }
        }

        // Insert ke tabel media jika belum ada
        foreach ($daftarMedia as $item) {
            $exists = Media::where('url', $item['url'])->first();
            if (! $exists) {
                $urlPath = parse_url($item['url'], PHP_URL_PATH) ?: '';
                $ext = pathinfo($urlPath, PATHINFO_EXTENSION) ?: ($item['tipe_media'] === 'youtube' ? 'youtube' : 'webp');

                Media::create([
                    'pengguna_id' => $adminId,
                    'judul' => $item['judul'],
                    'nama_file_asli' => basename($urlPath) ?: ($item['tipe_media'] === 'youtube' ? 'YouTube Video' : 'media.webp'),
                    'nama_file_disimpan' => basename($urlPath) ?: 'media-'.Str::random(8),
                    'path' => null,
                    'url' => $item['url'],
                    'tipe_media' => $item['tipe_media'],
                    'mime_type' => $item['tipe_media'] === 'youtube' ? 'video/x-youtube' : ($item['tipe_media'] === 'video' ? 'video/mp4' : 'image/webp'),
                    'ekstensi' => $ext,
                    'ukuran_bytes' => 102400,
                    'dimensi' => $item['tipe_media'] === 'youtube' ? '16:9' : '1920x1080',
                    'kategori' => $item['kategori'],
                    'alt_teks' => $item['judul'],
                    'sumber' => $item['sumber'],
                    'urutan' => 0,
                ]);
            }
        }
    }
}
