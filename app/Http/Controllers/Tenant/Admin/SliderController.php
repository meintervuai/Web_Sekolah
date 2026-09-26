<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\SliderBeranda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * Tampilkan daftar slider banner beranda.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $sliders = SliderBeranda::orderBy('urutan')->get();

        return view('tenant.admin.slider.index', compact('tenant', 'sliders'));
    }

    /**
     * Tampilkan form pembuatan slider baru.
     */
    public function create(): View
    {
        $tenant = app('tenant');
        $urutanBerikutnya = (SliderBeranda::max('urutan') ?? 0) + 1;

        return view('tenant.admin.slider.create', compact('tenant', 'urutanBerikutnya'));
    }

    /**
     * Simpan slider banner baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:200'],
            'subjudul' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'string', 'max:500'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'link_tombol' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_file')) {
            $validated['gambar'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('gambar_file'), 'slider', 1600);
        }

        if (empty($validated['gambar'])) {
            return back()->withErrors(['gambar' => 'Harap upload gambar banner atau masukkan URL gambar valid.'])->withInput();
        }

        unset($validated['gambar_file']);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        SliderBeranda::create($validated);

        return redirect()->route('tenant.admin.slider.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Slider banner beranda berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit slider.
     */
    public function edit(SliderBeranda $slider): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.slider.edit', compact('tenant', 'slider'));
    }

    /**
     * Perbarui slider banner.
     */
    public function update(Request $request, SliderBeranda $slider): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:200'],
            'subjudul' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'string', 'max:500'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'link_tombol' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_file')) {
            $validated['gambar'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('gambar_file'), 'slider', 1600);
        }

        if (empty($validated['gambar'])) {
            $validated['gambar'] = $slider->gambar;
        }

        unset($validated['gambar_file']);
        $validated['is_aktif'] = $request->boolean('is_aktif');

        $slider->update($validated);

        return redirect()->route('tenant.admin.slider.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Slider banner beranda berhasil diperbarui.');
    }

    /**
     * Hapus slider banner.
     */
    public function destroy(SliderBeranda $slider): RedirectResponse
    {
        $tenant = app('tenant');

        $slider->delete();

        return redirect()->route('tenant.admin.slider.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Slider banner beranda berhasil dihapus.');
    }
}
