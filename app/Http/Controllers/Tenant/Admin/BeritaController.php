<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\KategoriArtikel;
use App\Models\Tenant\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /**
     * Tampilkan daftar Berita Sekolah.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = Post::where('is_pengumuman', false)->with('kategori')->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('judul', 'like', "%{$q}%");
        }

        $berita = $query->paginate(10)->withQueryString();

        return view('tenant.admin.berita.index', compact('tenant', 'berita'));
    }

    /**
     * Form tambah berita.
     */
    public function create(): View
    {
        $tenant = app('tenant');
        $kategoriList = KategoriArtikel::all();

        return view('tenant.admin.berita.create', compact('tenant', 'kategoriList'));
    }

    /**
     * Simpan berita baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'integer'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_publikasi' => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('gambar_sampul_file'), 'berita', 1200);
        }
        unset($validated['gambar_sampul_file']);

        $validated['slug'] = Str::slug($validated['judul']).'-'.Str::random(5);
        $validated['pengguna_id'] = auth('tenant_admin')->id();
        $validated['is_pengumuman'] = false;
        $validated['tgl_publikasi'] = $validated['status_publikasi'] === 'published' ? now() : null;

        Post::create($validated);

        return redirect()->route('tenant.admin.berita.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Berita berhasil dipublikasikan.');
    }

    /**
     * Form edit berita.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $berita = Post::where('is_pengumuman', false)->findOrFail($id);
        $kategoriList = KategoriArtikel::all();

        return view('tenant.admin.berita.edit', compact('tenant', 'berita', 'kategoriList'));
    }

    /**
     * Update berita.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $berita = Post::where('is_pengumuman', false)->findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'integer'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_publikasi' => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('gambar_sampul_file'), 'berita', 1200);
        }
        unset($validated['gambar_sampul_file']);

        if ($validated['status_publikasi'] === 'published' && ! $berita->tgl_publikasi) {
            $validated['tgl_publikasi'] = now();
        }

        $berita->update($validated);

        return redirect()->route('tenant.admin.berita.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $berita = Post::where('is_pengumuman', false)->findOrFail($id);
        $berita->delete();

        return redirect()->route('tenant.admin.berita.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Berita berhasil dihapus.');
    }
}
