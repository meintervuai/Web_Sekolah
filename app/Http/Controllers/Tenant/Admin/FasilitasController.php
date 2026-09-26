<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Fasilitas;
use App\Models\Tenant\FotoFasilitas;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Fasilitas Sekolah.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $fasilitas = Fasilitas::with('fotoLainnya')->latest()->get();

        return view('tenant.admin.fasilitas.index', compact('tenant', 'fasilitas'));
    }

    /**
     * Form tambah fasilitas.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.fasilitas.create', compact('tenant'));
    }

    /**
     * Simpan fasilitas baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string'],
            'foto_utama' => ['nullable', 'string', 'max:500'],
            'foto_utama_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_aktif' => ['nullable', 'boolean'],
            'foto_tambahan' => ['nullable', 'array'],
            'foto_tambahan.*' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('foto_utama_file')) {
            $validated['foto_utama'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_utama_file'),
                'fasilitas',
                $tenant->slug,
                1200,
                82
            );
        }

        if (empty($validated['foto_utama'])) {
            return back()->withErrors(['foto_utama' => 'Foto fasilitas wajib diunggah atau diisi URL-nya.'])->withInput();
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $fasilitas = Fasilitas::create($validated);

        if (! empty($validated['foto_tambahan'])) {
            foreach ($validated['foto_tambahan'] as $urlFoto) {
                if (! empty($urlFoto)) {
                    FotoFasilitas::create([
                        'fasilitas_id' => $fasilitas->id,
                        'file_foto' => $urlFoto,
                    ]);
                }
            }
        }

        return redirect()->route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Fasilitas dan sarana pembelajaran berhasil ditambahkan.');
    }

    /**
     * Form edit fasilitas.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $fasilitas = Fasilitas::with('fotoLainnya')->findOrFail($id);

        return view('tenant.admin.fasilitas.edit', compact('tenant', 'fasilitas'));
    }

    /**
     * Update fasilitas.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:200'],
            'deskripsi' => ['required', 'string'],
            'foto_utama' => ['nullable', 'string', 'max:500'],
            'foto_utama_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_utama_file')) {
            $validated['foto_utama'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_utama_file'),
                'fasilitas',
                $tenant->slug,
                1200,
                82
            );
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $fasilitas->update($validated);

        return redirect()->route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Hapus fasilitas.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->fotoLainnya()->delete();
        $fasilitas->delete();

        return redirect()->route('tenant.admin.fasilitas.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Fasilitas berhasil dihapus.');
    }
}
