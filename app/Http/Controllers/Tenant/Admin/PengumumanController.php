<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Post;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Pengumuman Resmi Sekolah.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = Post::where('is_pengumuman', true)->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('judul', 'like', "%{$q}%");
        }

        $pengumuman = $query->paginate(10)->withQueryString();

        return view('tenant.admin.pengumuman.index', compact('tenant', 'pengumuman'));
    }

    /**
     * Form tambah pengumuman.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.pengumuman.create', compact('tenant'));
    }

    /**
     * Simpan pengumuman baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_publikasi' => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('gambar_sampul_file'),
                'pengumuman',
                $tenant->slug,
                1200,
                80
            );
        }

        $validated['slug'] = Str::slug($validated['judul']).'-'.Str::random(5);
        $validated['pengguna_id'] = auth('tenant_admin')->id();
        $validated['is_pengumuman'] = true;
        $validated['tgl_publikasi'] = $validated['status_publikasi'] === 'published' ? now() : null;

        Post::create($validated);

        return redirect()->route('tenant.admin.pengumuman.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pengumuman resmi berhasil diterbitkan.');
    }

    /**
     * Form edit pengumuman.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $pengumuman = Post::where('is_pengumuman', true)->findOrFail($id);

        return view('tenant.admin.pengumuman.edit', compact('tenant', 'pengumuman'));
    }

    /**
     * Update pengumuman.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $pengumuman = Post::where('is_pengumuman', true)->findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_publikasi' => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('gambar_sampul_file'),
                'pengumuman',
                $tenant->slug,
                1200,
                80
            );
        }

        if ($validated['status_publikasi'] === 'published' && ! $pengumuman->tgl_publikasi) {
            $validated['tgl_publikasi'] = now();
        }

        $pengumuman->update($validated);

        return redirect()->route('tenant.admin.pengumuman.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pengumuman resmi berhasil diperbarui.');
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $pengumuman = Post::where('is_pengumuman', true)->findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('tenant.admin.pengumuman.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pengumuman resmi berhasil dihapus.');
    }
}
