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
    public function index(Request $request): View|JsonResponse
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

        $perPage = (int) $request->get('per_page', 24);
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 24;
        }

        $medias = $query->orderBy('urutan', 'asc')->latest()->paginate($perPage)->withQueryString();

        // Peta penggunaan berkas media di seluruh database
        $mediaService = app(MediaService::class);
        $usedMediaMap = $mediaService->getUsedMediaMap();

        // Hitung statistik berkas digunakan
        $medias->getCollection()->transform(function ($media) use ($usedMediaMap) {
            $url = $media->url;
            $media->is_digunakan = isset($usedMediaMap[$url]) && count($usedMediaMap[$url]) > 0;
            $media->penggunaan = $usedMediaMap[$url] ?? [];
            return $media;
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $medias->items(),
                'current_page' => $medias->currentPage(),
                'last_page' => $medias->lastPage(),
                'total' => $medias->total(),
            ]);
        }

        return view('tenant.admin.media.index', compact('tenant', 'medias', 'stats', 'daftarKategori', 'tipe', 'usedMediaMap'));
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

            return back()->with('error', 'Gagal mengunggah berkas: ' . $e->getMessage())->withErrors(['file' => $e->getMessage()]);
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
     * Simpan pengaturan Framing / Crop & Focal Point (CSS Object-Position) non-destruktif.
     */
    public function editImage(Request $request, Media $media): JsonResponse|RedirectResponse
    {
        $request->validate([
            'crop_x' => ['nullable', 'numeric'],
            'crop_y' => ['nullable', 'numeric'],
            'crop_w' => ['nullable', 'numeric'],
            'crop_h' => ['nullable', 'numeric'],
            'box_x' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'box_y' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'box_w' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'box_h' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'focal_x' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'focal_y' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'ratio' => ['nullable', 'string', 'max:20'],
            'rotate' => ['nullable', 'integer', 'in:0,90,180,270'],
        ]);

        try {
            $focalX = $request->filled('focal_x') ? (float) $request->focal_x : 50;
            $focalY = $request->filled('focal_y') ? (float) $request->focal_y : 50;

            $cropSettings = [
                'focal_x' => round($focalX, 2),
                'focal_y' => round($focalY, 2),
                'box_x' => $request->filled('box_x') ? round((float) $request->box_x, 2) : 0,
                'box_y' => $request->filled('box_y') ? round((float) $request->box_y, 2) : 0,
                'box_w' => $request->filled('box_w') ? round((float) $request->box_w, 2) : 100,
                'box_h' => $request->filled('box_h') ? round((float) $request->box_h, 2) : 100,
                'crop_x' => $request->filled('crop_x') ? (float) $request->crop_x : null,
                'crop_y' => $request->filled('crop_y') ? (float) $request->crop_y : null,
                'crop_w' => $request->filled('crop_w') ? (float) $request->crop_w : null,
                'crop_h' => $request->filled('crop_h') ? (float) $request->crop_h : null,
                'ratio' => $request->get('ratio'),
                'rotate' => (int) $request->get('rotate', 0),
            ];

            $media->update([
                'crop_settings' => $cropSettings,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'sukses' => true,
                    'pesan' => 'Pengaturan crop dan titik fokus (focal point) berhasil disimpan.',
                    'data' => $media->fresh(),
                ]);
            }

            return back()->with('sukses', "Pengaturan crop / titik fokus untuk \"{$media->judul}\" berhasil disimpan.");
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
