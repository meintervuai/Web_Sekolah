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
        int $maxWidth = 1600,
        int $quality = 82
    ): string {
        $realPath = $file->getRealPath();
        $mime = $file->getMimeType();

        // Buat GD image source berdasarkan tipe file
        $srcImage = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
            'image/png' => @imagecreatefrompng($realPath),
            'image/webp' => @imagecreatefromwebp($realPath),
            'image/gif' => @imagecreatefromgif($realPath),
            default => null,
        };

        $tenantSlug = app()->bound('tenant') && app('tenant') ? app('tenant')->slug : 'common';
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
