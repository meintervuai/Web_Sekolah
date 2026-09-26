<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Agenda;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    /**
     * Tampilkan daftar Agenda Sekolah.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $query = Agenda::orderBy('tgl_mulai', 'desc');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('judul', 'like', "%{$q}%")->orWhere('lokasi', 'like', "%{$q}%");
        }

        $agenda = $query->paginate(10)->withQueryString();

        return view('tenant.admin.agenda.index', compact('tenant', 'agenda'));
    }

    /**
     * Form tambah agenda.
     */
    public function create(): View
    {
        $tenant = app('tenant');

        return view('tenant.admin.agenda.create', compact('tenant'));
    }

    /**
     * Simpan agenda baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'jam_mulai' => ['nullable', 'string', 'max:50'],
            'jam_selesai' => ['nullable', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:255'],
            'penyelenggara' => ['nullable', 'string', 'max:200'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('gambar_sampul_file'),
                'agenda',
                $tenant->slug,
                1200,
                82
            );
        }

        $validated['slug'] = Str::slug($validated['judul']).'-'.Str::random(5);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        Agenda::create($validated);

        return redirect()->route('tenant.admin.agenda.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Agenda kegiatan berhasil ditambahkan.');
    }

    /**
     * Form edit agenda.
     */
    public function edit(int $id): View
    {
        $tenant = app('tenant');
        $agenda = Agenda::findOrFail($id);

        return view('tenant.admin.agenda.edit', compact('tenant', 'agenda'));
    }

    /**
     * Update agenda.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'jam_mulai' => ['nullable', 'string', 'max:50'],
            'jam_selesai' => ['nullable', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:255'],
            'penyelenggara' => ['nullable', 'string', 'max:200'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'gambar_sampul_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_sampul_file')) {
            $validated['gambar_sampul'] = $this->imageService->uploadAndConvertToWebp(
                $request->file('gambar_sampul_file'),
                'agenda',
                $tenant->slug,
                1200,
                82
            );
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $agenda->update($validated);

        return redirect()->route('tenant.admin.agenda.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Agenda kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus agenda.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('tenant.admin.agenda.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Agenda berhasil dihapus.');
    }
}
