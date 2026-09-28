<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\StrukturOrganisasi;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StrukturController extends Controller
{
    /**
     * Ambil daftar diagram struktur (dengan data default jika belum dikonfigurasi).
     */
    private function getDiagramsList(): array
    {
        $diagramsRaw = PengaturanUmum::ambil('struktur_diagrams', null);
        if ($diagramsRaw !== null) {
            return json_decode($diagramsRaw, true) ?: [];
        }

        return [
            [
                'judul' => 'Bagan Struktur Utama Manajemen Sekolah',
                'deskripsi' => 'Alur garis komando dan koordinasi Kepala Sekolah, Komite, Tim Penjaminan Mutu, Wakil Kepala Sekolah, dan Koordinator Tata Usaha.',
                'gambar' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'judul' => 'Bagan Tata Kelola Teaching Factory (TEFA) & Hubungan Industri',
                'deskripsi' => 'Alur koordinasi unit produksi kejuruan, kemitraan dunia usaha/dunia kerja (DUDI), dan Bursa Kerja Khusus (BKK).',
                'gambar' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'judul' => 'Bagan Tata Kelola Program Keahlian & Laboratorium Praktik',
                'deskripsi' => 'Struktur pembagian penanggung jawab bengkel mesin, lab komputer, studio desain, dan sarana praktik vokasi.',
                'gambar' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=1600&auto=format&fit=crop',
            ],
        ];
    }

    /**
     * Tampilkan halaman pengelolaan struktur organisasi sekolah (Bagan Diagram & Jajaran Pejabat).
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();
        $diagrams = $this->getDiagramsList();

        return view('tenant.admin.struktur.index', compact('tenant', 'struktur', 'diagrams'));
    }

    /**
     * Simpan anggota struktural baru.
     */
    public function storeAnggota(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'urutan' => ['required', 'integer'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = ImageService::uploadAndConvertToWebp($request->file('foto_file'), 'struktur', 600);
        }
        unset($validated['foto_file']);

        StrukturOrganisasi::create($validated);

        return redirect()->route('tenant.admin.struktur.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Anggota struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Perbarui data anggota struktural.
     */
    public function updateAnggota(Request $request, int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $item = StrukturOrganisasi::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'urutan' => ['required', 'integer'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto'] = ImageService::uploadAndConvertToWebp($request->file('foto_file'), 'struktur', 600);
        }
        unset($validated['foto_file']);

        $item->update($validated);

        return redirect()->route('tenant.admin.struktur.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Data anggota struktur organisasi berhasil diperbarui.');
    }

    /**
     * Hapus anggota struktural.
     */
    public function destroyAnggota(int $id): RedirectResponse
    {
        $tenant = app('tenant');

        $item = StrukturOrganisasi::findOrFail($id);
        $item->delete();

        return redirect()->route('tenant.admin.struktur.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Anggota struktur organisasi berhasil dihapus.');
    }

    /**
     * Simpan / Tambah diagram bagan alur struktur organisasi.
     */
    public function storeDiagram(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'gambar' => ['nullable', 'string', 'max:500'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
        ]);

        if ($request->hasFile('gambar_file')) {
            $validated['gambar'] = ImageService::uploadAndConvertToWebp($request->file('gambar_file'), 'diagram-struktur', 1920);
        }
        unset($validated['gambar_file']);

        if (empty($validated['gambar'])) {
            return back()->with('error', 'Silakan unggah berkas gambar bagan atau masukkan tautan URL gambar.');
        }

        $diagrams = $this->getDiagramsList();

        $diagrams[] = [
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? '',
            'gambar' => $validated['gambar'],
        ];

        PengaturanUmum::simpan('struktur_diagrams', json_encode(array_values($diagrams)));

        return redirect()->route('tenant.admin.struktur.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Bagan diagram struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Hapus diagram bagan struktur organisasi berdasarkan index.
     */
    public function destroyDiagram(int $index): RedirectResponse
    {
        $tenant = app('tenant');

        $diagrams = $this->getDiagramsList();

        if (isset($diagrams[$index])) {
            array_splice($diagrams, $index, 1);
            PengaturanUmum::simpan('struktur_diagrams', json_encode(array_values($diagrams)));
        }

        return redirect()->route('tenant.admin.struktur.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Bagan diagram struktur berhasil dihapus.');
    }
}
