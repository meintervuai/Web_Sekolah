<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Upload gambar, kompres, konversi otomatis ke format WebP, dan simpan di public storage.
     *
     * @param UploadedFile $file File gambar yang diunggah
     * @param string $folder Folder penyimpanan (misal: 'berita', 'slider', 'jurusan')
     * @param int $maxWidth Lebar maksimal gambar sebelum proporsional scale down
     * @param int $quality Kualitas kompresi WebP (1-100)
     * @return string URL publik gambar (contoh: /storage/uploads/berita/xyz.webp)
     */
    public static function uploadAndConvertToWebp(
        UploadedFile $file,
        string $folder = 'general',
        int|string|null $param3 = null,
        int|null $param4 = null,
        int|null $param5 = null
    ): string {
        $realPath = $file->getRealPath();
        $mime = $file->getMimeType();

        // Cek apakah parameter ke-3 adalah tenantSlug (string) atau maxWidth (int)
        if (is_string($param3) && !is_numeric($param3)) {
            $explicitTenantSlug = $param3;
            $maxWidth = $param4 ?? 1600;
            $quality = $param5 ?? 82;
        } else {
            $explicitTenantSlug = null;
            $maxWidth = is_numeric($param3) ? (int)$param3 : 1600;
            $quality = is_numeric($param4) ? (int)$param4 : 82;
        }

        // Tentukan slug tenant aktif
        $tenantSlug = $explicitTenantSlug 
            ?: (app()->bound('tenant') && app('tenant') ? app('tenant')->slug : 'common');

        // Pastikan path selalu berada di bawah uploads/{tenantSlug}/ agar langsung terindeks di Media & Berkas Manager
        $relativeDir = "uploads/{$tenantSlug}/{$folder}";
        $filename = Str::random(24) . '.webp';
        $destinationPath = storage_path("app/public/{$relativeDir}/{$filename}");

        // Pastikan folder tujuan ada
        if (!file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0755, true);
        }

        if ($srcImage && function_exists('imagewebp')) {
            $origWidth = imagesx($srcImage);
            $origHeight = imagesy($srcImage);

            // Hitung dimensi baru jika melebihi maxWidth
            if ($origWidth > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) round(($origHeight / $origWidth) * $maxWidth);
            } else {
                $newWidth = $origWidth;
                $newHeight = $origHeight;
            }

            // Buat canvas gambar baru dengan true color dan transparansi alpha
            $dstImage = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
            $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
            imagefilledrectangle($dstImage, 0, 0, $newWidth, $newHeight, $transparent);

            // Resample / resize dengan kualitas tinggi
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

            // Simpan gambar sebagai WebP terkompresi
            imagewebp($dstImage, $destinationPath, $quality);

            imagedestroy($srcImage);
            imagedestroy($dstImage);
        } else {
            // Fallback jika GD gagal / bukan format yang didukung GD, simpan langsung
            $file->storeAs("public/{$relativeDir}", $file->hashName());
            return Storage::url("{$relativeDir}/" . $file->hashName());
        }

        return Storage::url("{$relativeDir}/{$filename}");
    }
}
