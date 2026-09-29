<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Tampilkan galeri dan manajemen media induk.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = Media::query()->with('pengguna');

        // Filter tipe media
        $tipe = $request->get('tipe', 'semua');
        if (in_array($tipe, ['gambar', 'video', 'dokumen', 'youtube'])) {
            $query->where('tipe_media', $tipe);
        }

        // Filter kategori
        if ($kategori = $request->get('kategori')) {
            $query->where('kategori', $kategori);
        }

        // Pencarian judul / nama file / alt text
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nama_file_asli', 'like', "%{$search}%")
                    ->orWhere('alt_teks', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        // Statistik ringkas media
        $stats = [
            'total' => Media::count(),
            'gambar' => Media::where('tipe_media', 'gambar')->count(),
            'video' => Media::where('tipe_media', 'video')->count(),
            'youtube' => Media::where('tipe_media', 'youtube')->count(),
            'dokumen' => Media::where('tipe_media', 'dokumen')->count(),
        ];

        // Daftar kategori unik untuk filter
        $daftarKategori = Media::select('kategori')->distinct()->pluck('kategori')->filter()->values();

        $medias = $query->orderBy('urutan', 'asc')->latest()->paginate(24)->withQueryString();

        return view('tenant.admin.media.index', compact('tenant', 'medias', 'stats', 'daftarKategori', 'tipe'));
    }

    /**
     * Unggah berkas media baru (otomatis konversi ke WebP untuk gambar & kompresi).
     */
    public function upload(Request $request, MediaService $mediaService): JsonResponse|RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:51200'], // Maksimal 50MB
            'kategori' => ['nullable', 'string', 'max:100'],
            'judul' => ['nullable', 'string', 'max:255'],
            'alt_teks' => ['nullable', 'string', 'max:500'],
        ], [
            'file.required' => 'Pilih berkas yang akan diunggah.',
            'file.max' => 'Ukuran berkas maksimal adalah 50MB.',
        ]);

        $penggunaId = Auth::guard('tenant_admin')->id();
        $kategori = $request->get('kategori', 'umum') ?: 'umum';
        $judul = $request->get('judul');
        $altTeks = $request->get('alt_teks');

        try {
            $media = $mediaService->unggahBerkas(
                $request->file('file'),
                $penggunaId,
                $kategori,
                $judul,
                $altTeks
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => true,
                    'pesan' => 'Berkas berhasil diunggah dan dikompresi ke WebP.',
                    'data' => $media,
                ]);
            }

            return back()->with('sukses', "Berkas \"{$media->judul}\" berhasil diunggah ke pustaka media.");
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors(['file' => $e->getMessage()]);
        }
    }

    /**
     * Impor berkas gambar atau video YouTube dari tautan URL eksternal.
     */
    public function importUrl(Request $request, MediaService $mediaService): JsonResponse|RedirectResponse
    {
        $request->validate([
            'url' => ['required', 'url', 'max:1000'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'judul' => ['nullable', 'string', 'max:255'],
            'alt_teks' => ['nullable', 'string', 'max:500'],
        ], [
            'url.required' => 'Tautan URL media wajib diisi.',
            'url.url' => 'Format tautan URL tidak valid.',
        ]);

        $penggunaId = Auth::guard('tenant_admin')->id();
        $kategori = $request->get('kategori', 'umum') ?: 'umum';

        try {
            $media = $mediaService->imporDariUrl(
                $request->get('url'),
                $penggunaId,
                $kategori,
                $request->get('judul'),
                $request->get('alt_teks')
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => true,
                    'pesan' => 'Media dari URL berhasil diimpor ke pustaka.',
                    'data' => $media,
                ]);
            }

            return back()->with('sukses', "Media dari tautan URL \"{$media->judul}\" berhasil disimpan.");
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors(['url' => $e->getMessage()]);
        }
    }

    /**
     * Pengecekan URL otomatis (Live check & thumbnail preview sebelum diimpor).
     */
    public function checkUrl(Request $request, MediaService $mediaService): JsonResponse
    {
        $url = trim($request->get('url', ''));
        if (empty($url) || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['valid' => false, 'pesan' => 'URL tidak valid'], 422);
        }

        // Cek jika YouTube
        if ($mediaService->isYouTubeUrl($url)) {
            $ytId = $mediaService->ekstrakYouTubeId($url);
            if ($ytId) {
                return response()->json([
                    'valid' => true,
                    'tipe' => 'youtube',
                    'preview_url' => "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg",
                    'judul_saran' => 'Video YouTube ('.$ytId.')',
                    'pesan' => 'Tautan YouTube valid.',
                ]);
            }
        }

        // Cek URL direct file / image
        try {
            $resp = Http::timeout(5)->head($url);
            if (! $resp->successful()) {
                $resp = Http::timeout(5)->get($url);
            }

            if ($resp->successful()) {
                $contentType = $resp->header('Content-Type') ?: '';
                $isImage = str_starts_with($contentType, 'image/') || preg_match('/\.(jpg|jpeg|png|webp|gif|svg)$/i', $url);
                $isVideo = str_starts_with($contentType, 'video/') || preg_match('/\.(mp4|webm|ogg)$/i', $url);

                return response()->json([
                    'valid' => true,
                    'tipe' => $isImage ? 'gambar' : ($isVideo ? 'video' : 'dokumen'),
                    'preview_url' => $isImage ? $url : null,
                    'content_type' => $contentType,
                    'pesan' => 'Tautan media aktif dan siap diimpor.',
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'valid' => false,
                'pesan' => 'Tidak dapat menghubungi tautan URL: '.$e->getMessage(),
            ], 422);
        }

        return response()->json(['valid' => false, 'pesan' => 'Tautan tidak dapat diakses atau tidak merespons.'], 422);
    }

    /**
     * Perbarui metadata media (Ganti nama judul, alt text, kategori, urutan).
     */
    public function update(Request $request, Media $media): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'alt_teks' => ['nullable', 'string', 'max:500'],
            'kategori' => ['required', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer'],
        ], [
            'judul.required' => 'Judul atau nama berkas wajib diisi.',
            'kategori.required' => 'Kategori berkas wajib ditentukan.',
        ]);

        $media->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'sukses' => true,
                'pesan' => 'Metadata media berhasil diperbarui.',
                'data' => $media,
            ]);
        }

        return back()->with('sukses', "Informasi berkas \"{$media->judul}\" berhasil disimpan.");
    }

    /**
     * Edit gambar interaktif (Crop & Rotate) dan perbarui file WebP.
     */
    public function editImage(Request $request, Media $media, MediaService $mediaService): JsonResponse|RedirectResponse
    {
        $request->validate([
            'crop_x' => ['nullable', 'numeric'],
            'crop_y' => ['nullable', 'numeric'],
            'crop_w' => ['nullable', 'numeric'],
            'crop_h' => ['nullable', 'numeric'],
            'rotate' => ['nullable', 'integer', 'in:0,90,180,270'],
        ]);

        $cropData = null;
        if ($request->filled('crop_w') && $request->filled('crop_h') && $request->crop_w > 0 && $request->crop_h > 0) {
            $cropData = [
                'x' => (int) $request->crop_x,
                'y' => (int) $request->crop_y,
                'width' => (int) $request->crop_w,
                'height' => (int) $request->crop_h,
            ];
        }

        $rotateAngle = (int) $request->get('rotate', 0);

        try {
            $croppedMedia = $mediaService->prosesEditGambar($media, $cropData, $rotateAngle);

            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => true,
                    'pesan' => 'Versi potong (crop) WebP baru berhasil dibuat tanpa mengubah berkas master asli.',
                    'data' => $croppedMedia,
                ]);
            }

            return back()->with('sukses', "Versi potong (crop) baru untuk \"{$media->judul}\" berhasil disimpan ke pustaka media.");
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors(['edit' => $e->getMessage()]);
        }
    }

    /**
     * Hapus berkas media tunggal dari database dan storage.
     */
    public function destroy(Media $media, MediaService $mediaService): JsonResponse|RedirectResponse
    {
        $judul = $media->judul;
        $mediaService->hapusMedia($media);

        if (request()->wantsJson()) {
            return response()->json([
                'sukses' => true,
                'pesan' => "Media \"{$judul}\" berhasil dihapus.",
            ]);
        }

        return back()->with('sukses', "Media \"{$judul}\" berhasil dihapus.");
    }

    /**
     * Hapus beberapa berkas media sekaligus (bulk delete).
     */
    public function bulkDestroy(Request $request, MediaService $mediaService): JsonResponse|RedirectResponse
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', (array) $ids));

        if (empty($ids)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => 'Tidak ada berkas media yang dipilih untuk dihapus.',
                ], 422);
            }

            return back()->withErrors(['ids' => 'Pilih minimal satu berkas media untuk dihapus.']);
        }

        $medias = Media::whereIn('id', $ids)->get();
        $jumlah = $medias->count();

        foreach ($medias as $media) {
            $mediaService->hapusMedia($media);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'sukses' => true,
                'pesan' => "Sebanyak {$jumlah} berkas media berhasil dihapus secara permanen.",
            ]);
        }

        return back()->with('sukses', "Sebanyak {$jumlah} berkas media berhasil dihapus secara permanen.");
    }
}
