<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\SliderBeranda;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'video' => ['nullable', 'string', 'max:500'],
            'video_file' => ['nullable', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:51200'],
            'link_tombol' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_file')) {
            $validated['gambar'] = ImageService::uploadAndConvertToWebp($request->file('gambar_file'), 'slider', 1600);
        }

        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            $vidFilename = 'slider-video-'.time().'-'.Str::random(6).'.'.$videoFile->getClientOriginalExtension();
            $vidPath = $videoFile->storeAs('uploads/video', $vidFilename, 'public');
            $validated['video'] = Storage::url($vidPath);
        }

        // Setidaknya harus ada salah satu media: gambar atau video
        if (empty($validated['gambar']) && empty($validated['video'])) {
            return back()->withErrors(['gambar' => 'Harap upload gambar atau video untuk slider banner hero ini.'])->withInput();
        }

        unset($validated['gambar_file'], $validated['video_file']);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        SliderBeranda::create($validated);

        return redirect()->route('tenant.admin.slider.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Slider banner hero beranda berhasil ditambahkan.');
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
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'video' => ['nullable', 'string', 'max:500'],
            'video_file' => ['nullable', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:51200'],
            'link_tombol' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'urutan' => ['required', 'integer'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_file')) {
            $validated['gambar'] = ImageService::uploadAndConvertToWebp($request->file('gambar_file'), 'slider', 1600);
        }

        if (empty($validated['gambar'])) {
            $validated['gambar'] = $slider->gambar;
        }

        if ($request->hasFile('video_file')) {
            $videoFile = $request->file('video_file');
            $vidFilename = 'slider-video-'.time().'-'.Str::random(6).'.'.$videoFile->getClientOriginalExtension();
            $vidPath = $videoFile->storeAs('uploads/video', $vidFilename, 'public');
            $validated['video'] = Storage::url($vidPath);
        } elseif (! array_key_exists('video', $validated) || $validated['video'] === null) {
            $validated['video'] = $slider->video;
        }

        // Jika user sengaja mengosongkan gambar namun tidak ada video, cegah
        if (empty($validated['gambar']) && empty($validated['video'])) {
            return back()->withErrors(['gambar' => 'Banner hero harus memiliki setidaknya gambar atau video.'])->withInput();
        }

        unset($validated['gambar_file'], $validated['video_file']);
        $validated['is_aktif'] = $request->boolean('is_aktif');

        $slider->update($validated);

        return redirect()->route('tenant.admin.slider.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Slider banner hero beranda berhasil diperbarui.');
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
