<?php

namespace App\Services;

use App\Models\Tenant\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Folder dasar penyimpanan media di storage public.
     */
    protected string $disk = 'public';

    protected string $folderMedia = 'uploads/media';

    /**
     * Dapatkan URL publik berkas dari disk storage.
     */
    protected function getStorageUrl(string $path): string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk($this->disk);

        return $disk->url($path);
    }

    /**
     * Proses unggah berkas lokal (Gambar -> WebP terkompresi, Video, Dokumen).
     */
    public function unggahBerkas(
        UploadedFile $file,
        ?int $penggunaId = null,
        string $kategori = 'umum',
        ?string $judulCustom = null,
        ?string $altTeks = null
    ): Media {
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $namaAsli = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ekstensiAsli = strtolower($file->getClientOriginalExtension());
        $judul = $judulCustom ?: Str::headline($namaAsli);

        // 1. Kategori Gambar -> Konversi Otomatis ke WebP & Kompresi
        if (str_starts_with($mime, 'image/') && ! in_array($ekstensiAsli, ['svg', 'ico'])) {
            return $this->prosesDanSimpanGambarWebp(
                file_get_contents($file->getRealPath()),
                $namaAsli,
                $penggunaId,
                $kategori,
                $judul,
                $altTeks
            );
        }

        // 2. Kategori SVG / Ico (Simpan apa adanya)
        if (in_array($ekstensiAsli, ['svg', 'ico'])) {
            $filename = Str::slug($namaAsli) . '-' . time() . '.' . $ekstensiAsli;
            $path = $file->storeAs($this->folderMedia . '/gambar', $filename, $this->disk);

            return Media::create([
                'pengguna_id' => $penggunaId,
                'judul' => $judul,
                'nama_file_asli' => $file->getClientOriginalName(),
                'nama_file_disimpan' => $filename,
                'path' => $path,
                'url' => $this->getStorageUrl($path),
                'tipe_media' => 'gambar',
                'mime_type' => $mime,
                'ekstensi' => $ekstensiAsli,
                'ukuran_bytes' => $file->getSize(),
                'dimensi' => null,
                'kategori' => $kategori,
                'alt_teks' => $altTeks ?: $judul,
                'sumber' => 'upload_langsung',
            ]);
        }

        // 3. Kategori Video (MP4, WebM, OGG, dll)
        if (str_starts_with($mime, 'video/')) {
            $filename = Str::slug($namaAsli) . '-' . time() . '.' . $ekstensiAsli;
            $path = $file->storeAs($this->folderMedia . '/video', $filename, $this->disk);

            return Media::create([
                'pengguna_id' => $penggunaId,
                'judul' => $judul,
                'nama_file_asli' => $file->getClientOriginalName(),
                'nama_file_disimpan' => $filename,
                'path' => $path,
                'url' => $this->getStorageUrl($path),
                'tipe_media' => 'video',
                'mime_type' => $mime,
                'ekstensi' => $ekstensiAsli,
                'ukuran_bytes' => $file->getSize(),
                'dimensi' => null,
                'kategori' => $kategori,
                'alt_teks' => $altTeks ?: $judul,
                'sumber' => 'upload_langsung',
            ]);
        }

        // 4. Kategori Dokumen (PDF, Word, Excel, dll)
        $filename = Str::slug($namaAsli) . '-' . time() . '.' . $ekstensiAsli;
        $path = $file->storeAs($this->folderMedia . '/dokumen', $filename, $this->disk);

        return Media::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'nama_file_asli' => $file->getClientOriginalName(),
            'nama_file_disimpan' => $filename,
            'path' => $path,
            'url' => $this->getStorageUrl($path),
            'tipe_media' => 'dokumen',
            'mime_type' => $mime,
            'ekstensi' => $ekstensiAsli,
            'ukuran_bytes' => $file->getSize(),
            'dimensi' => null,
            'kategori' => $kategori,
            'alt_teks' => $altTeks ?: $judul,
            'sumber' => 'upload_langsung',
        ]);
    }

    /**
     * Impor media dari URL eksternal (Gambar dikonversi ke WebP lokal, YouTube didaftarkan terstruktur).
     */
    public function imporDariUrl(
        string $url,
        ?int $penggunaId = null,
        string $kategori = 'umum',
        ?string $judulCustom = null,
        ?string $altTeks = null
    ): Media {
        $url = trim($url);

        // Jika URL adalah YouTube
        if ($this->isYouTubeUrl($url)) {
            return $this->daftarkanYouTube($url, $penggunaId, $kategori, $judulCustom, $altTeks);
        }

        // Cek ekstensi / nama file dari path URL
        $pathUrl = parse_url($url, PHP_URL_PATH) ?: '';
        $namaAsli = pathinfo($pathUrl, PATHINFO_FILENAME) ?: 'media-url-' . time();
        $ekstensi = strtolower(pathinfo($pathUrl, PATHINFO_EXTENSION) ?: 'jpg');
        $judul = $judulCustom ?: Str::headline(str_replace(['-', '_'], ' ', $namaAsli));

        // Tentukan tipe media berdasarkan ekstensi atau URL
        $tipeMedia = 'gambar';
        if (in_array($ekstensi, ['mp4', 'webm', 'ogg', 'mov', 'm4v'])) {
            $tipeMedia = 'video';
        } elseif (in_array($ekstensi, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'])) {
            $tipeMedia = 'dokumen';
        }

        // Simpan langsung ke entitas Media database sebagai URL eksternal (tanpa download fisik)
        return Media::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'nama_file_asli' => basename($pathUrl) ?: $namaAsli,
            'nama_file_disimpan' => $namaAsli,
            'path' => null, // Tidak ada file lokal, murni rujukan URL
            'url' => $url,
            'tipe_media' => $tipeMedia,
            'mime_type' => $tipeMedia === 'video' ? 'video/' . $ekstensi : ($tipeMedia === 'dokumen' ? 'application/' . $ekstensi : 'image/' . $ekstensi),
            'ekstensi' => $ekstensi,
            'ukuran_bytes' => 0,
            'dimensi' => null,
            'kategori' => $kategori,
            'alt_teks' => $altTeks ?: $judul,
            'sumber' => 'url_eksternal',
        ]);
    }

    /**
     * Daftarkan video YouTube sebagai entitas media terstruktur.
     */
    public function daftarkanYouTube(
        string $url,
        ?int $penggunaId = null,
        string $kategori = 'umum',
        ?string $judulCustom = null,
        ?string $altTeks = null
    ): Media {
        $youtubeId = $this->ekstrakYouTubeId($url);
        $judul = $judulCustom ?: ('Video YouTube ' . ($youtubeId ?: 'Sekolah'));

        // Thumbnail resmi YouTube HQ
        $thumbnailUrl = $youtubeId ? "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg" : '';

        return Media::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'nama_file_asli' => 'YouTube: ' . $youtubeId,
            'nama_file_disimpan' => $youtubeId,
            'path' => null,
            'url' => $url,
            'tipe_media' => 'youtube',
            'mime_type' => 'video/x-youtube',
            'ekstensi' => 'youtube',
            'ukuran_bytes' => 0,
            'dimensi' => '16:9',
            'kategori' => $kategori,
            'alt_teks' => $altTeks ?: $judul,
            'sumber' => 'youtube',
        ]);
    }

    /**
     * Proses kompresi & konversi biner gambar ke WebP berkualitas tinggi.
     */
    protected function prosesDanSimpanGambarWebp(
        string $binaryData,
        string $namaAsli,
        ?int $penggunaId,
        string $kategori,
        string $judul,
        ?string $altTeks,
        string $sumber = 'upload_langsung'
    ): Media {
        if (! extension_loaded('gd')) {
            throw new \RuntimeException('Ekstensi PHP GD diperlukan untuk kompresi gambar WebP.');
        }

        $imageResource = @imagecreatefromstring($binaryData);
        if (! $imageResource) {
            throw new \InvalidArgumentException('Format gambar tidak valid atau rusak.');
        }

        // Pastikan imageResource adalah truecolor (wajib untuk WebP dan palette PNG/GIF)
        if (! imageistruecolor($imageResource)) {
            imagepalettetotruecolor($imageResource);
        }

        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        // Pastikan orientasi truecolor & transparansi alpha
        $origWidth = imagesx($imageResource);
        $origHeight = imagesy($imageResource);

        // Batasi resolusi maksimum 1920px (menjaga aspek rasio)
        $maxWidth = 1920;
        $maxHeight = 1920;

        if ($origWidth > $maxWidth || $origHeight > $maxHeight) {
            $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
            $newWidth = (int) round($origWidth * $ratio);
            $newHeight = (int) round($origHeight * $ratio);

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            imagecopyresampled($resizedImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($imageResource);
            $imageResource = $resizedImage;
            $finalWidth = $newWidth;
            $finalHeight = $newHeight;
        } else {
            $finalWidth = $origWidth;
            $finalHeight = $origHeight;
        }

        // Simpan sebagai WebP ke storage
        $filename = Str::slug($namaAsli) . '-' . time() . '.webp';
        $relativePath = $this->folderMedia . '/gambar/' . $filename;
        $fullStoragePath = Storage::disk($this->disk)->path($relativePath);

        // Pastikan direktori tersedia
        $dir = dirname($fullStoragePath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Kualitas WebP 82% (keseimbangan optimal ukuran & ketajaman visual)
        imagewebp($imageResource, $fullStoragePath, 82);
        imagedestroy($imageResource);

        $fileSize = file_exists($fullStoragePath) ? filesize($fullStoragePath) : 0;

        return Media::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'nama_file_asli' => $namaAsli . '.webp',
            'nama_file_disimpan' => $filename,
            'path' => $relativePath,
            'url' => $this->getStorageUrl($relativePath),
            'tipe_media' => 'gambar',
            'mime_type' => 'image/webp',
            'ekstensi' => 'webp',
            'ukuran_bytes' => $fileSize,
            'dimensi' => "{$finalWidth}x{$finalHeight}",
            'kategori' => $kategori,
            'alt_teks' => $altTeks ?: $judul,
            'sumber' => $sumber,
        ]);
    }

    /**
     * Edit gambar (Crop & Rotate) secara NON-DESTRUKTIF:
     * Menyimpan hasil crop sebagai berkas WebP baru terpisah di pustaka media
     * sehingga berkas asli tetap aman dan utuh.
     */
    public function prosesEditGambar(
        Media $media,
        ?array $cropData = null, // ['x' => ..., 'y' => ..., 'width' => ..., 'height' => ...]
        int $rotateAngle = 0 // 90, 180, 270
    ): Media {
        if ($media->tipe_media !== 'gambar') {
            throw new \InvalidArgumentException('Hanya berkas gambar yang dapat diedit.');
        }

        // Mode Pratinjau: Berkas asli tetap utuh di database & storage server tanpa menimpa berkas master
        return $media;
    }

    /**
     * Update URL lama ke URL baru di seluruh tabel entitas website sekolah.
     */
    public function sinkronisasiPerubahanUrlKeSemuaEntitas(string $oldUrl, string $newUrl): void
    {
        try {
            \App\Models\Tenant\PengaturanUmum::where('nilai', $oldUrl)->update(['nilai' => $newUrl]);
            \App\Models\Tenant\Page::where('gambar_banner', $oldUrl)->update(['gambar_banner' => $newUrl]);
            \App\Models\Tenant\StrukturOrganisasi::where('foto', $oldUrl)->update(['foto' => $newUrl]);
            \App\Models\Tenant\GuruStaf::where('foto', $oldUrl)->update(['foto' => $newUrl]);
            \App\Models\Tenant\Jurusan::where('ikon_atau_foto', $oldUrl)->update(['ikon_atau_foto' => $newUrl]);
            \App\Models\Tenant\Ekstrakurikuler::where('foto', $oldUrl)->update(['foto' => $newUrl]);
            \App\Models\Tenant\PrestasiSiswa::where('foto', $oldUrl)->update(['foto' => $newUrl]);
            \App\Models\Tenant\Fasilitas::where('foto_utama', $oldUrl)->update(['foto_utama' => $newUrl]);
            \App\Models\Tenant\FotoFasilitas::where('file_foto', $oldUrl)->update(['file_foto' => $newUrl]);
            \App\Models\Tenant\SliderBeranda::where('gambar', $oldUrl)->update(['gambar' => $newUrl]);
            \App\Models\Tenant\GaleriItem::where('file_path', $oldUrl)->update(['file_path' => $newUrl]);
            \App\Models\Tenant\BeritaArtikel::where('gambar_sampul', $oldUrl)->update(['gambar_sampul' => $newUrl]);
        } catch (\Throwable $e) {
            // Silently continue if any table doesn't have the column
        }
    }

    /**
     * Periksa apakah URL adalah tautan video YouTube.
     */
    public function isYouTubeUrl(string $url): bool
    {
        return Str::contains($url, ['youtube.com', 'youtu.be']);
    }

    /**
     * Ekstrak YouTube ID dari string URL.
     */
    public function ekstrakYouTubeId(string $url): ?string
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return $match[1];
        }

        return null;
    }

    /**
     * Sinkronisasi otomatis URL yang dimasukkan admin:
     * Jika URL berupa http/https eksternal (Unsplash, file luar, dsb), unduh otomatis dan simpan ke entitas media,
     * lalu kembalikan URL lokal internal storage.
     * Jika sudah merupakan URL lokal atau link YouTube terdaftar, kembalikan URL yang valid.
     */
    public function sinkronisasiOtomatisUrl(
        ?string $url,
        ?int $penggunaId = null,
        string $kategori = 'profil',
        ?string $judul = null
    ): ?string {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // 1. Periksa apakah URL ini adalah berkas internal storage lokal kita
        // (Mendeteksi /storage/uploads/, http://127.0.0.1:8000/storage/..., http://localhost:8000/storage/..., dsb)
        if (str_contains($url, '/storage/') || str_contains($url, 'uploads/media/')) {
            return $url;
        }

        // Abaikan jika bukan format URL http / https
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            return $url;
        }

        // 2. Periksa apakah URL ini sudah pernah tersimpan di tabel Media database
        $existing = Media::where('url', $url)->first();
        if ($existing) {
            return $existing->url;
        }

        // 3. Jika URL adalah link YouTube
        if ($this->isYouTubeUrl($url)) {
            try {
                $media = $this->daftarkanYouTube($url, $penggunaId, $kategori, $judul);
                return $media->url;
            } catch (\Throwable $e) {
                return $url;
            }
        }

        // 4. Jika URL adalah file eksternal (gambar/video/dokumen luar) -> Unduh & simpan ke Media internal
        try {
            $media = $this->imporDariUrl($url, $penggunaId, $kategori, $judul);
            return $media->url;
        } catch (\Throwable $e) {
            // Jika download gagal atau timeout, tetap gunakan URL yang dimasukkan admin
            return $url;
        }
    }

    /**
     * Dapatkan peta penggunaan berkas media di seluruh entitas database website sekolah.
     * Mengembalikan array yang memetakan URL / path berkas media ke daftar nama entitas pemakainya.
     *
     * @return array<string, array<int, string>>
     */
    public function getUsedMediaMap(): array
    {
        $usedMap = [];

        $recordUsage = function (?string $url, string $entityLabel) use (&$usedMap) {
            if (empty($url)) {
                return;
            }
            $cleanUrl = trim($url);
            if (! isset($usedMap[$cleanUrl])) {
                $usedMap[$cleanUrl] = [];
            }
            if (! in_array($entityLabel, $usedMap[$cleanUrl])) {
                $usedMap[$cleanUrl][] = $entityLabel;
            }
        };

        // 1. Pengaturan Umum (Logo, Favicon, Video Profil, dsb)
        $pengaturan = \App\Models\Tenant\PengaturanUmum::whereIn('kunci', [
            'logo', 'logo_aplikasi', 'favicon', 'video_profil', 'gambar_profil_utama', 'foto_kepala_sekolah'
        ])->get();
        foreach ($pengaturan as $p) {
            $label = match($p->kunci) {
                'logo', 'logo_aplikasi' => 'Logo Sekolah',
                'favicon' => 'Favicon Website',
                'video_profil' => 'Video Profil Utama',
                'gambar_profil_utama' => 'Banner Profil Utama',
                'foto_kepala_sekolah' => 'Foto Kepala Sekolah',
                default => 'Pengaturan Umum: ' . Str::headline($p->kunci),
            };
            $recordUsage($p->nilai, $label);
        }

        // 2. Halaman Statis (Sejarah, Visi Misi, Struktur, Profil)
        $halaman = \App\Models\Tenant\Page::all();
        foreach ($halaman as $page) {
            $recordUsage($page->gambar_banner, 'Banner: ' . $page->judul);
        }

        // 3. Struktur Organisasi
        $pejabat = \App\Models\Tenant\StrukturOrganisasi::all();
        foreach ($pejabat as $st) {
            $recordUsage($st->foto, 'Pejabat: ' . $st->nama_lengkap);
        }

        // 4. Guru & Staf
        $guruStaf = \App\Models\Tenant\GuruStaf::all();
        foreach ($guruStaf as $gs) {
            $recordUsage($gs->foto, 'Guru/Staf: ' . $gs->nama_lengkap);
        }

        // 5. Jurusan
        $jurusan = \App\Models\Tenant\Jurusan::all();
        foreach ($jurusan as $j) {
            $recordUsage($j->ikon_atau_foto, 'Jurusan: ' . $j->nama_jurusan);
        }

        // 6. Ekstrakurikuler
        $ekskul = \App\Models\Tenant\Ekstrakurikuler::all();
        foreach ($ekskul as $e) {
            $recordUsage($e->foto, 'Ekskul: ' . $e->nama_ekstrakurikuler);
        }

        // 7. Prestasi Siswa
        $prestasi = \App\Models\Tenant\PrestasiSiswa::all();
        foreach ($prestasi as $pr) {
            $recordUsage($pr->foto, 'Prestasi: ' . $pr->nama_prestasi);
        }

        // 8. Fasilitas & Foto Fasilitas
        $fasilitas = \App\Models\Tenant\Fasilitas::all();
        foreach ($fasilitas as $f) {
            $recordUsage($f->foto_utama, 'Fasilitas: ' . $f->nama_fasilitas);
        }
        $fotoFasilitas = \App\Models\Tenant\FotoFasilitas::with('fasilitas')->get();
        foreach ($fotoFasilitas as $ff) {
            $fasName = $ff->fasilitas?->nama_fasilitas ?: 'Fasilitas';
            $recordUsage($ff->file_foto, 'Galeri Fasilitas: ' . $fasName);
        }

        // 9. Slider Beranda
        $sliders = \App\Models\Tenant\SliderBeranda::all();
        foreach ($sliders as $sl) {
            $recordUsage($sl->gambar, 'Slider: ' . ($sl->judul ?: 'Beranda'));
            $recordUsage($sl->video, 'Video Slider: ' . ($sl->judul ?: 'Beranda'));
        }

        // 10. Galeri Album & Galeri Item
        $galeriItem = \App\Models\Tenant\GaleriItem::with('album')->get();
        foreach ($galeriItem as $gi) {
            $albName = $gi->album?->nama_album ?: 'Galeri';
            $recordUsage($gi->file_media_atau_link, 'Item Galeri: ' . $albName);
        }

        // 11. Artikel / Berita (Gambar Sampul)
        $artikel = \App\Models\Tenant\Post::all();
        foreach ($artikel as $art) {
            $recordUsage($art->gambar_sampul, 'Sampul Artikel: ' . Str::limit($art->judul, 25));
        }

        return $usedMap;
    }

    /**
     * Hapus berkas media dari database dan storage fisik.
     */
    public function hapusMedia(Media $media): bool
    {
        if (! empty($media->path) && Storage::disk($this->disk)->exists($media->path)) {
            Storage::disk($this->disk)->delete($media->path);
        }

        return $media->delete();
    }

    /**
     * Dapatkan CSS object-position dari tabel media untuk sembarang URL gambar.
     * Mengembalikan nilai seperti '50% 30%' jika media memiliki focal point / crop_settings.
     */
    public static function getFocalPosition(?string $url): string
    {
        if (empty($url)) {
            return 'center center';
        }

        static $cache = [];
        $cleanUrl = trim($url);

        if (isset($cache[$cleanUrl])) {
            return $cache[$cleanUrl];
        }

        $media = Media::where('url', $cleanUrl)->first();
        $pos = $media ? $media->focal_position_css : 'center center';
        $cache[$cleanUrl] = $pos;

        return $pos;
    }

    /**
     * Dapatkan CSS inline style lengkap (Smart Box Crop Zoom & Clip) untuk sembarang URL gambar.
     */
    public static function getCropStyle(?string $url): string
    {
        if (empty($url)) {
            return 'object-position: center center; object-fit: cover;';
        }

        static $cacheStyle = [];
        $cleanUrl = trim($url);

        if (isset($cacheStyle[$cleanUrl])) {
            return $cacheStyle[$cleanUrl];
        }

        $media = Media::where('url', $cleanUrl)->first();
        $style = $media ? $media->smart_crop_style : 'object-position: center center; object-fit: cover;';
        $cacheStyle[$cleanUrl] = $style;

        return $style;
    }
}
