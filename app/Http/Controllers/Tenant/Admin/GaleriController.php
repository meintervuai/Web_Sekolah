<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GaleriAlbum;
use App\Models\Tenant\GaleriItem;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GaleriController extends Controller
{
    /**
     * Tampilkan daftar album galeri dan foto dokumentasi.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $albums = GaleriAlbum::withCount('items')->latest()->get();
        $recentItems = GaleriItem::with('album')->latest()->take(12)->get();

        return view('tenant.admin.galeri.index', compact('tenant', 'albums', 'recentItems'));
    }

    /**
     * Simpan album baru.
     */
    public function storeAlbum(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_album' => ['required', 'string', 'max:200'],
            'tipe' => ['required', 'in:foto,video'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'cover_album' => ['nullable', 'string', 'max:500'],
            'cover_album_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('cover_album_file')) {
            $validated['cover_album'] = ImageService::uploadAndConvertToWebp($request->file('cover_album_file'), 'galeri', 1200);
        }

        if (empty($validated['cover_album'])) {
            return back()->withErrors(['cover_album' => 'Harap upload gambar sampul album atau masukkan URL gambar.']);
        }

        $validated['slug'] = Str::slug($validated['nama_album']).'-'.Str::random(5);
        unset($validated['cover_album_file']);

        GaleriAlbum::create($validated);

        return redirect()->route('tenant.admin.galeri.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Album galeri berhasil dibuat.');
    }

    /**
     * Tambah item foto ke dalam album.
     */
    public function storeItem(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'album_id' => ['required', 'exists:tenant.galeri_album,id'],
            'judul_item' => ['required', 'string', 'max:200'],
            'file_media_atau_link' => ['nullable', 'string', 'max:500'],
            'file_media_atau_link_file' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,mp4,webm,mov', 'max:30720'],
        ]);

        if ($request->hasFile('file_media_atau_link_file')) {
            $file = $request->file('file_media_atau_link_file');
            $ext = strtolower($file->getClientOriginalExtension());
            if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                $filename = 'galeri-video-'.time().'-'.Str::random(5).'.'.$ext;
                $path = $file->storeAs('uploads/galeri-video', $filename, 'public');
                $validated['file_media_atau_link'] = Storage::url($path);
            } else {
                $validated['file_media_atau_link'] = ImageService::uploadAndConvertToWebp($file, 'galeri-foto', 1600);
            }
        }

        if (empty($validated['file_media_atau_link'])) {
            return back()->withErrors(['file_media_atau_link' => 'Harap upload file foto/video dokumentasi atau masukkan tautan URL media (YouTube / file).']);
        }

        unset($validated['file_media_atau_link_file']);

        GaleriItem::create($validated);

        return redirect()->route('tenant.admin.galeri.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Item foto/video dokumentasi berhasil ditambahkan ke album.');
    }

    /**
     * Hapus album.
     */
    public function destroyAlbum(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $album = GaleriAlbum::findOrFail($id);
        $album->items()->delete();
        $album->delete();

        return redirect()->route('tenant.admin.galeri.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Album dan seluruh foto di dalamnya berhasil dihapus.');
    }

    /**
     * Hapus item foto.
     */
    public function destroyItem(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $item = GaleriItem::findOrFail($id);
        $item->delete();

        return redirect()->route('tenant.admin.galeri.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Foto/media dokumentasi berhasil dihapus.');
    }
}
