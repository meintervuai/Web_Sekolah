<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Ekstrakurikuler;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EkstrakurikulerController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Ekstrakurikuler.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $ekskul = Ekstrakurikuler::latest()->get();

        return view('tenant.admin.ekskul.index', compact('tenant', 'ekskul'));
    }

    /**
     * Form tambah ekskul.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.ekskul.create', compact('tenant'));
    }

    /**
     * Simpan ekskul baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_ekstrakurikuler' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'hari_jadwal' => ['nullable', 'string', 'max:100'],
            'waktu_jadwal' => ['nullable', 'string', 'max:100'],
            'pembina' => ['nullable', 'string', 'max:150'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'ekskul',
                $tenant->slug,
                1000,
                82
            );
        }

        $validated['slug'] = Str::slug($validated['nama_ekstrakurikuler']).'-'.Str::random(4);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        Ekstrakurikuler::create($validated);

        return redirect()->route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Form edit ekskul.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $ekskul = Ekstrakurikuler::findOrFail($id);

        return view('tenant.admin.ekskul.edit', compact('tenant', 'ekskul'));
    }

    /**
     * Update ekskul.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $ekskul = Ekstrakurikuler::findOrFail($id);

        $validated = $request->validate([
            'nama_ekstrakurikuler' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'hari_jadwal' => ['nullable', 'string', 'max:100'],
            'waktu_jadwal' => ['nullable', 'string', 'max:100'],
            'pembina' => ['nullable', 'string', 'max:150'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'ekskul',
                $tenant->slug,
                1000,
                82
            );
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $ekskul->update($validated);

        return redirect()->route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Hapus ekskul.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $ekskul->delete();

        return redirect()->route('tenant.admin.ekskul.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data ekstrakurikuler berhasil dihapus.');
    }
}
