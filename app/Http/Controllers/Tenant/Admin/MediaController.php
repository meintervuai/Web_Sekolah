<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Tampilkan antarmuka manajemen berkas dan media (gambar, video, dokumen).
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $tenantSlug = $tenant ? $tenant->slug : 'common';
        $baseDir = "uploads/{$tenantSlug}";

        // Pastikan folder uploads tenant ada
        if (! Storage::disk('public')->exists($baseDir)) {
            Storage::disk('public')->makeDirectory($baseDir);
        }

        $allFiles = Storage::disk('public')->allFiles($baseDir);
        $filesData = [];

        $filterType = $request->query('type', 'all');
        $searchQuery = strtolower(trim($request->query('q', '')));

        $totalBytes = 0;
        $countImages = 0;
        $countVideos = 0;
        $countDocs = 0;

        foreach ($allFiles as $filePath) {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $filename = basename($filePath);
            $sizeBytes = Storage::disk('public')->size($filePath);
            $lastModified = Storage::disk('public')->lastModified($filePath);

            $type = match ($extension) {
                'jpg', 'jpeg', 'png', 'webp', 'gif', 'svg' => 'image',
                'mp4', 'webm', 'mov', 'avi', 'mkv' => 'video',
                'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar' => 'document',
                default => 'other',
            };

            $totalBytes += $sizeBytes;
            if ($type === 'image') {
                $countImages++;
            } elseif ($type === 'video') {
                $countVideos++;
            } elseif ($type === 'document') {
                $countDocs++;
            }

            // Filter pencarian
            if ($searchQuery && ! str_contains(strtolower($filename), $searchQuery)) {
                continue;
            }

            // Filter tipe
            if ($filterType !== 'all' && $type !== $filterType) {
                continue;
            }

            $filesData[] = [
                'name' => $filename,
                'path' => $filePath,
                'url' => Storage::url($filePath),
                'size' => $this->formatBytes($sizeBytes),
                'size_bytes' => $sizeBytes,
                'extension' => $extension,
                'type' => $type,
                'last_modified' => date('d M Y H:i', $lastModified),
                'timestamp' => $lastModified,
            ];
        }

        // Urutkan file terbaru di paling atas
        usort($filesData, fn ($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        $stats = [
            'total_files' => count($allFiles),
            'total_size' => $this->formatBytes($totalBytes),
            'images' => $countImages,
            'videos' => $countVideos,
            'documents' => $countDocs,
        ];

        return view('tenant.admin.media.index', compact('tenant', 'filesData', 'stats', 'filterType', 'searchQuery'));
    }

    /**
     * Upload berkas baru ke direktori media tenant.
     */
    public function upload(Request $request): RedirectResponse
    {
        $tenant = app('tenant');
        $tenantSlug = $tenant ? $tenant->slug : 'common';

        $request->validate([
            'file' => ['required', 'file', 'max:25600'], // maks 25MB
            'folder' => ['nullable', 'string', 'max:50'],
        ]);

        $folder = $request->input('folder', 'media');
        $folder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder) ?: 'media';
        $uploadedFile = $request->file('file');
        $mime = $uploadedFile->getMimeType();

        if (str_starts_with($mime, 'image/') && ! in_array($uploadedFile->getClientOriginalExtension(), ['svg', 'gif'])) {
            ImageService::uploadAndConvertToWebp($uploadedFile, $folder, 1920);
        } else {
            $ext = $uploadedFile->getClientOriginalExtension();
            $safeName = Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)).'-'.Str::random(6).'.'.$ext;
            $uploadedFile->storeAs("public/uploads/{$tenantSlug}/{$folder}", $safeName);
        }

        return redirect()->route('tenant.admin.media.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Berkas berhasil diunggah ke penyimpanan media.');
    }

    /**
     * Ganti nama berkas (Rename file).
     */
    public function rename(Request $request): RedirectResponse
    {
        $tenant = app('tenant');
        $tenantSlug = $tenant ? $tenant->slug : 'common';

        $validated = $request->validate([
            'path' => ['required', 'string'],
            'new_name' => ['required', 'string', 'max:100'],
        ]);

        $oldPath = $validated['path'];
        $baseDir = "uploads/{$tenantSlug}";

        // Keamanan: Pastikan path berada dalam folder tenant
        if (! str_starts_with($oldPath, $baseDir) || ! Storage::disk('public')->exists($oldPath)) {
            return back()->with('error', 'Berkas tidak ditemukan atau berada di luar batas izin.');
        }

        $oldExtension = pathinfo($oldPath, PATHINFO_EXTENSION);
        $cleanBaseName = Str::slug(pathinfo($validated['new_name'], PATHINFO_FILENAME));

        if (empty($cleanBaseName)) {
            return back()->with('error', 'Nama berkas baru tidak valid.');
        }

        $dirName = dirname($oldPath);
        $newFilename = $cleanBaseName.'.'.$oldExtension;
        $newPath = $dirName.'/'.$newFilename;

        if (Storage::disk('public')->exists($newPath) && $newPath !== $oldPath) {
            $newPath = $dirName.'/'.$cleanBaseName.'-'.Str::random(4).'.'.$oldExtension;
        }

        Storage::disk('public')->move($oldPath, $newPath);

        return redirect()->route('tenant.admin.media.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Nama berkas berhasil diperbarui menjadi: '.basename($newPath));
    }

    /**
     * Simpan hasil pemotongan gambar (Crop image).
     */
    public function crop(Request $request): JsonResponse
    {
        $tenant = app('tenant');
        $tenantSlug = $tenant ? $tenant->slug : 'common';

        $validated = $request->validate([
            'path' => ['required', 'string'],
            'cropped_image' => ['required', 'string'], // Base64 dataURL
            'save_mode' => ['required', 'in:replace,new'], // Ganti file asli atau simpan baru
        ]);

        $originalPath = $validated['path'];
        $baseDir = "uploads/{$tenantSlug}";

        if (! str_starts_with($originalPath, $baseDir) || ! Storage::disk('public')->exists($originalPath)) {
            return response()->json(['success' => false, 'message' => 'Berkas sumber tidak ditemukan.'], 404);
        }

        // Ambil data binary dari base64
        $base64Data = $validated['cropped_image'];
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }
        $decoded = base64_decode($base64Data);

        if (! $decoded) {
            return response()->json(['success' => false, 'message' => 'Data gambar hasil crop tidak valid.'], 422);
        }

        $dirName = dirname($originalPath);
        $originalExt = pathinfo($originalPath, PATHINFO_EXTENSION);

        if ($validated['save_mode'] === 'replace') {
            $targetPath = $originalPath;
        } else {
            $targetFilename = pathinfo($originalPath, PATHINFO_FILENAME).'-crop-'.Str::random(5).'.'.$originalExt;
            $targetPath = $dirName.'/'.$targetFilename;
        }

        Storage::disk('public')->put($targetPath, $decoded);

        return response()->json([
            'success' => true,
            'message' => 'Gambar hasil pemotongan (crop) berhasil disimpan.',
            'url' => Storage::url($targetPath),
            'filename' => basename($targetPath),
        ]);
    }

    /**
     * Hapus berkas dari disk.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $tenant = app('tenant');
        $tenantSlug = $tenant ? $tenant->slug : 'common';

        $validated = $request->validate([
            'path' => ['required', 'string'],
        ]);

        $filePath = $validated['path'];
        $baseDir = "uploads/{$tenantSlug}";

        if (! str_starts_with($filePath, $baseDir) || ! Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Berkas tidak ditemukan.');
        }

        Storage::disk('public')->delete($filePath);

        return redirect()->route('tenant.admin.media.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Berkas berhasil dihapus secara permanen.');
    }

    /**
     * Format ukuran berkas (bytes to KB/MB).
     */
    private function formatBytes(int $bytes, int $precision = 1): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log($bytes, 1024));

        return round($bytes / pow(1024, $i), $precision).' '.$units[$i];
    }
}
