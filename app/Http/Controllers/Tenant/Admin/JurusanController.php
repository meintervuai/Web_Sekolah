<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JurusanController extends Controller
{
    /**
     * Tampilkan daftar Program Keahlian / Jurusan.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $jurusan = Jurusan::orderBy('urutan')->get();

        return view('tenant.admin.jurusan.index', compact('tenant', 'jurusan'));
    }

    /**
     * Tampilkan form pembuatan Program Keahlian baru.
     */
    public function create(): View
    {
        $tenant = app('tenant');
        $urutanBerikutnya = (Jurusan::max('urutan') ?? 0) + 1;

        return view('tenant.admin.jurusan.create', compact('tenant', 'urutanBerikutnya'));
    }

    /**
     * Simpan Program Keahlian baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:200'],
            'singkatan' => ['required', 'string', 'max:50'],
            'slug' => ['nullable', 'string', 'max:200'],
            'deskripsi_singkat' => ['required', 'string'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'ikon_atau_foto' => ['nullable', 'string', 'max:500'],
            'ikon_atau_foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('ikon_atau_foto_file')) {
            $validated['ikon_atau_foto'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('ikon_atau_foto_file'), 'jurusan', 1200);
        }
        unset($validated['ikon_atau_foto_file']);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['nama_jurusan']);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        Jurusan::create($validated);

        return redirect()->route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Program keahlian/jurusan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit Program Keahlian.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $jurusan = Jurusan::findOrFail($id);

        return view('tenant.admin.jurusan.edit', compact('tenant', 'jurusan'));
    }

    /**
     * Perbarui Program Keahlian.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $jurusan = Jurusan::findOrFail($id);

        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:200'],
            'singkatan' => ['required', 'string', 'max:50'],
            'slug' => ['nullable', 'string', 'max:200'],
            'deskripsi_singkat' => ['required', 'string'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'ikon_atau_foto' => ['nullable', 'string', 'max:500'],
            'ikon_atau_foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('ikon_atau_foto_file')) {
            $validated['ikon_atau_foto'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('ikon_atau_foto_file'), 'jurusan', 1200);
        }
        unset($validated['ikon_atau_foto_file']);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['nama_jurusan']);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $jurusan->update($validated);

        return redirect()->route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Program keahlian/jurusan berhasil diperbarui.');
    }

    /**
     * Hapus Program Keahlian.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('tenant.admin.jurusan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Program keahlian/jurusan berhasil dihapus.');
    }
}
