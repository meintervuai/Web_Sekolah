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

        // Unduh gambar/file dari URL dengan timeout wajar & alokasi waktu aman
        @set_time_limit(120);
        $response = Http::timeout(8)->connectTimeout(4)->get($url);

        if (! $response->successful()) {
            throw new \RuntimeException("Gagal mengunduh file dari URL (Status: {$response->status()}).");
        }

        $contentType = $response->header('Content-Type') ?: '';
        $body = $response->body();
        $pathUrl = parse_url($url, PHP_URL_PATH) ?: '';
        $namaAsli = pathinfo($pathUrl, PATHINFO_FILENAME) ?: 'impor-media-' . time();
        $judul = $judulCustom ?: Str::headline(str_replace(['-', '_'], ' ', $namaAsli));

        // Jika konten adalah gambar -> Konversi ke WebP
        if (str_starts_with($contentType, 'image/') || preg_match('/\.(jpg|jpeg|png|webp|bmp|gif)$/i', $pathUrl)) {
            return $this->prosesDanSimpanGambarWebp(
                $body,
                $namaAsli,
                $penggunaId,
                $kategori,
                $judul,
                $altTeks,
                'url_eksternal'
            );
        }

        // Jika non-gambar (misal video mp4 direct URL)
        $ekstensi = pathinfo($pathUrl, PATHINFO_EXTENSION) ?: 'bin';
        $filename = Str::slug($namaAsli) . '-' . time() . '.' . $ekstensi;
        $tipeMedia = str_starts_with($contentType, 'video/') ? 'video' : 'dokumen';
        $folder = $tipeMedia === 'video' ? 'video' : 'dokumen';

        Storage::disk($this->disk)->put($this->folderMedia . "/{$folder}/{$filename}", $body);
        $path = $this->folderMedia . "/{$folder}/{$filename}";

        return Media::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'nama_file_asli' => basename($pathUrl) ?: $filename,
            'nama_file_disimpan' => $filename,
            'path' => $path,
            'url' => $this->getStorageUrl($path),
            'tipe_media' => $tipeMedia,
            'mime_type' => $contentType ?: 'application/octet-stream',
            'ekstensi' => $ekstensi,
            'ukuran_bytes' => strlen($body),
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

        // Jika path belum ada (misal data awal/URL), unduh dan simpan lokal dulu
        if (empty($media->path)) {
            $binary = @file_get_contents($media->url);
            if (! $binary) {
                $resp = Http::timeout(10)->get($media->url);
                $binary = $resp->successful() ? $resp->body() : null;
            }
            if (! $binary) {
                throw new \RuntimeException('Gagal memuat sumber gambar untuk diedit.');
            }
            $filename = Str::slug($media->judul ?: 'media') . '-' . time() . '.webp';
            $relativePath = $this->folderMedia . '/gambar/' . $filename;
            $fullStoragePath = Storage::disk($this->disk)->path($relativePath);
            $dir = dirname($fullStoragePath);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $res = @imagecreatefromstring($binary);
            if (! $res) {
                throw new \RuntimeException('Format gambar tidak valid.');
            }
            if (! imageistruecolor($res)) {
                imagepalettetotruecolor($res);
            }
            imagealphablending($res, true);
            imagesavealpha($res, true);
            imagewebp($res, $fullStoragePath, 85);
            imagedestroy($res);
            $media->update([
                'path' => $relativePath,
                'url' => $this->getStorageUrl($relativePath),
                'nama_file_disimpan' => $filename,
                'ekstensi' => 'webp',
            ]);
        }

        $sourceFullPath = Storage::disk($this->disk)->path($media->path);
        if (! file_exists($sourceFullPath)) {
            throw new \RuntimeException('File gambar master tidak ditemukan di storage.');
        }

        $imageResource = @imagecreatefromstring(file_get_contents($sourceFullPath));
        if (! $imageResource) {
            throw new \RuntimeException('Gagal memuat gambar untuk proses edit.');
        }

        if (! imageistruecolor($imageResource)) {
            imagepalettetotruecolor($imageResource);
        }
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        // 1. Rotasi jika ada
        if (in_array($rotateAngle, [90, 180, 270])) {
            // GD imagerotate berlawanan arah, 360 - angle untuk searah jarum jam
            $rotated = imagerotate($imageResource, 360 - $rotateAngle, 0);
            imagedestroy($imageResource);
            $imageResource = $rotated;
        }

        // 2. Crop jika ada koordinat
        if ($cropData && ! empty($cropData['width']) && ! empty($cropData['height'])) {
            $x = max(0, (int) ($cropData['x'] ?? 0));
            $y = max(0, (int) ($cropData['y'] ?? 0));
            $w = (int) $cropData['width'];
            $h = (int) $cropData['height'];

            $cropped = imagecrop($imageResource, ['x' => $x, 'y' => $y, 'width' => $w, 'height' => $h]);
            if ($cropped !== false) {
                imagedestroy($imageResource);
                $imageResource = $cropped;
            }
        }

        $finalWidth = imagesx($imageResource);
        $finalHeight = imagesy($imageResource);

        // Simpan sebagai berkas WebP BARU (Non-Destruktif, jangan menimpa file master asli)
        $cleanBaseName = Str::slug(pathinfo($media->nama_file_disimpan ?: $media->judul, PATHINFO_FILENAME));
        $newFilename = $cleanBaseName . '-crop-' . time() . '.webp';
        $newRelativePath = $this->folderMedia . '/gambar/' . $newFilename;
        $newFullStoragePath = Storage::disk($this->disk)->path($newRelativePath);

        $dir = dirname($newFullStoragePath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        imagewebp($imageResource, $newFullStoragePath, 85);
        imagedestroy($imageResource);

        $fileSize = file_exists($newFullStoragePath) ? filesize($newFullStoragePath) : 0;

        // Buat record media baru untuk versi cropped teroptimasi
        return Media::create([
            'pengguna_id' => $media->pengguna_id,
            'judul' => $media->judul . ' (Versi Crop)',
            'nama_file_asli' => $newFilename,
            'nama_file_disimpan' => $newFilename,
            'path' => $newRelativePath,
            'url' => $this->getStorageUrl($newRelativePath),
            'tipe_media' => 'gambar',
            'mime_type' => 'image/webp',
            'ekstensi' => 'webp',
            'ukuran_bytes' => $fileSize,
            'dimensi' => "{$finalWidth}x{$finalHeight}",
            'kategori' => $media->kategori,
            'alt_teks' => $media->alt_teks ?: $media->judul,
            'sumber' => $media->sumber,
            'urutan' => $media->urutan,
        ]);
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
     * Hapus berkas media dari database dan storage fisik.
     */
    public function hapusMedia(Media $media): bool
    {
        if (! empty($media->path) && Storage::disk($this->disk)->exists($media->path)) {
            Storage::disk($this->disk)->delete($media->path);
        }

        return $media->delete();
    }
}
