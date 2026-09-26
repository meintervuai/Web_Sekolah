<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\PrestasiSiswa;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Prestasi Siswa.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = PrestasiSiswa::orderBy('tanggal', 'desc');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('nama_prestasi', 'like', "%{$q}%")
                ->orWhere('nama_siswa', 'like', "%{$q}%");
        }

        $prestasi = $query->paginate(10)->withQueryString();

        return view('tenant.admin.prestasi.index', compact('tenant', 'prestasi'));
    }

    /**
     * Form tambah prestasi.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.prestasi.create', compact('tenant'));
    }

    /**
     * Simpan prestasi.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_prestasi' => ['required', 'string', 'max:255'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'string', 'max:100'],
            'tanggal' => ['required', 'date'],
            'tahun' => ['required', 'integer'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'prestasi',
                $tenant->slug,
                1000,
                82
            );
        }

        $validated['slug'] = Str::slug($validated['nama_prestasi']).'-'.Str::random(5);

        PrestasiSiswa::create($validated);

        return redirect()->route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data capaian prestasi siswa berhasil ditambahkan.');
    }

    /**
     * Form edit prestasi.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $prestasi = PrestasiSiswa::findOrFail($id);

        return view('tenant.admin.prestasi.edit', compact('tenant', 'prestasi'));
    }

    /**
     * Update prestasi.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $prestasi = PrestasiSiswa::findOrFail($id);

        $validated = $request->validate([
            'nama_prestasi' => ['required', 'string', 'max:255'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'string', 'max:100'],
            'tanggal' => ['required', 'date'],
            'tahun' => ['required', 'integer'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'prestasi',
                $tenant->slug,
                1000,
                82
            );
        }

        $prestasi->update($validated);

        return redirect()->route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data prestasi siswa berhasil diperbarui.');
    }

    /**
     * Hapus prestasi.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $prestasi = PrestasiSiswa::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('tenant.admin.prestasi.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data prestasi siswa berhasil dihapus.');
    }
}
