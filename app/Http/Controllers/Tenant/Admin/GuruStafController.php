<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruStafController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Guru & Tenaga Kependidikan.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = GuruStaf::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('nama_lengkap', 'like', "%{$q}%")
                ->orWhere('jabatan', 'like', "%{$q}%")
                ->orWhere('mata_pelajaran', 'like', "%{$q}%");
        }

        $guru = $query->paginate(12)->withQueryString();

        return view('tenant.admin.guru.index', compact('tenant', 'guru'));
    }

    /**
     * Form tambah guru/staf.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.guru.create', compact('tenant'));
    }

    /**
     * Simpan data guru/staf.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'jabatan' => ['required', 'string', 'max:100'],
            'mata_pelajaran' => ['nullable', 'string', 'max:150'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'guru',
                $tenant->slug,
                600,
                85
            );
        }

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        GuruStaf::create($validated);

        return redirect()->route('tenant.admin.guru.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data Pendidik / Tenaga Kependidikan berhasil ditambahkan.');
    }

    /**
     * Form edit guru/staf.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $guru = GuruStaf::findOrFail($id);

        return view('tenant.admin.guru.edit', compact('tenant', 'guru'));
    }

    /**
     * Update data guru/staf.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $guru = GuruStaf::findOrFail($id);

        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'jabatan' => ['required', 'string', 'max:100'],
            'mata_pelajaran' => ['nullable', 'string', 'max:150'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('foto_file'),
                'guru',
                $tenant->slug,
                600,
                85
            );
        }

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        $guru->update($validated);

        return redirect()->route('tenant.admin.guru.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data Pendidik / Tenaga Kependidikan berhasil diperbarui.');
    }

    /**
     * Hapus data guru/staf.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $guru = GuruStaf::findOrFail($id);
        $guru->delete();

        return redirect()->route('tenant.admin.guru.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data Pendidik / Tenaga Kependidikan berhasil dihapus.');
    }
}
