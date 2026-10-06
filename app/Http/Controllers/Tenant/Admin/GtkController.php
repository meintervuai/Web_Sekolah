<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\StrukturOrganisasi;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GtkController extends Controller
{
    /**
     * Menampilkan halaman manajemen Struktur Organisasi dan Guru & Tenaga Kependidikan (GTK).
     */
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();
        $sekolah = app('tenant');

        $isStrukturAktif = PengaturanFitur::isAktif('struktur_organisasi', true);
        $isGuruAktif = PengaturanFitur::isAktif('guru_staf', true);

        // Jika kedua fitur nonaktif, tolak akses dan alihkan ke profil
        if (! $isStrukturAktif && ! $isGuruAktif) {
            return redirect()
                ->route('tenant.admin.profil.index', ['tenant' => $sekolah->slug])
                ->with('error', 'Akses ditolak: Modul Struktur Organisasi & Direktori GTK sedang dinonaktifkan oleh Super Admin.');
        }

        // Validasi tab jika dispesifikasikan dalam query
        $requestedTab = $request->query('tab');
        if ($requestedTab === 'struktur' && ! $isStrukturAktif) {
            return redirect()
                ->route('tenant.admin.gtk.index', ['tenant' => $sekolah->slug, 'tab' => 'guru'])
                ->with('error', 'Akses ditolak: Modul Struktur Organisasi sedang dinonaktifkan oleh Super Admin.');
        }
        if ($requestedTab === 'guru' && ! $isGuruAktif) {
            return redirect()
                ->route('tenant.admin.gtk.index', ['tenant' => $sekolah->slug, 'tab' => 'struktur'])
                ->with('error', 'Akses ditolak: Modul Direktori Guru & Tenaga Kependidikan sedang dinonaktifkan oleh Super Admin.');
        }

        // Tentukan default tab jika tab yang diminta kosong
        $defaultTab = $isStrukturAktif ? 'struktur' : 'guru';
        $activeTab = $requestedTab ?: $defaultTab;

        // 1. Data Halaman Statis Hero (Struktur & Guru)
        $halamanStruktur = Page::firstOrCreate(
            ['slug' => 'struktur'],
            [
                'judul' => 'Struktur Organisasi Sekolah',
                'subjudul' => 'Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di '.$sekolah->nama_sekolah.'.',
                'isi_konten' => '',
                'gambar_banner' => null,
                'pengguna_id' => $adminId,
            ]
        );

        $halamanGuru = Page::firstOrCreate(
            ['slug' => 'guru-staf'],
            [
                'judul' => 'Guru & Tenaga Kependidikan',
                'subjudul' => 'Didukung oleh tenaga pendidik dan kependidikan profesional berpengalaman, berpendidikan S1/S2, dan bersertifikasi keahlian industri di '.$sekolah->nama_sekolah.'.',
                'isi_konten' => '',
                'gambar_banner' => null,
                'pengguna_id' => $adminId,
            ]
        );

        // 2. Diagram Struktur Organisasi
        $diagramsRaw = PengaturanUmum::ambil('struktur_diagrams', null);
        $diagrams = $diagramsRaw ? json_decode($diagramsRaw, true) : [
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

        // 3. Pejabat Struktural & Guru Direktori
        $pejabatList = StrukturOrganisasi::with('guru')->orderBy('urutan')->get();
        $guruList = GuruStaf::where('status_aktif', true)->orderBy('nama_lengkap')->get();
        $allGuru = GuruStaf::orderBy('nama_lengkap')->get();

        // 4. Feature Flags GTK & Struktur
        $fiturGtk = [
            'struktur_organisasi' => PengaturanFitur::isAktif('struktur_organisasi', true),
            'struktur_diagram' => PengaturanFitur::isAktif('struktur_diagram', true),
            'struktur_pejabat' => PengaturanFitur::isAktif('struktur_pejabat', true),
            'guru_staf' => PengaturanFitur::isAktif('guru_staf', true),
        ];

        return view('tenant.admin.gtk.index', compact(
            'halamanStruktur',
            'halamanGuru',
            'diagrams',
            'pejabatList',
            'guruList',
            'allGuru',
            'fiturGtk',
            'activeTab'
        ));
    }

    /**
     * Simpan kustomisasi hero banner dan diagram struktur organisasi.
     */
    public function updateStruktur(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'judul_struktur' => ['nullable', 'string', 'max:200'],
            'subjudul_struktur' => ['nullable', 'string', 'max:500'],
            'gambar_banner_struktur' => ['nullable', 'string', 'max:500'],
            'diagrams' => ['nullable', 'array'],
            'diagrams.*.judul' => ['required', 'string', 'max:200'],
            'diagrams.*.deskripsi' => ['nullable', 'string', 'max:500'],
            'diagrams.*.gambar' => ['required', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();
        $diagramsList = array_values($validated['diagrams'] ?? []);

        // Sinkronisasi otomatis gambar diagram ke entitas Media
        foreach ($diagramsList as &$diagram) {
            if (! empty($diagram['gambar'])) {
                $diagram['gambar'] = $mediaService->sinkronisasiOtomatisUrl($diagram['gambar'], $adminId, 'profil', $diagram['judul'] ?? 'Diagram Struktur Organisasi');
            }
        }
        unset($diagram);

        // Sinkronisasi otomatis banner hero struktur ke entitas Media
        if (! empty($validated['gambar_banner_struktur'])) {
            $validated['gambar_banner_struktur'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_banner_struktur'], $adminId, 'profil', 'Banner Hero Struktur Organisasi');
        }

        DB::connection('tenant')->transaction(function () use ($validated, $adminId, $diagramsList, $request) {
            PengaturanUmum::updateOrCreate(
                ['kunci' => 'struktur_diagrams'],
                [
                    'nilai' => json_encode($diagramsList),
                    'pengguna_id' => $adminId,
                ]
            );

            // Update judul, subjudul & banner hero halaman Struktur
            Page::updateOrCreate(
                ['slug' => 'struktur'],
                [
                    'judul' => ($validated['judul_struktur'] ?? null) ?: 'Struktur Organisasi Sekolah',
                    'subjudul' => $request->input('subjudul_struktur', 'Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di sekolah.'),
                    'gambar_banner' => $validated['gambar_banner_struktur'] ?? null,
                    'pengguna_id' => $adminId,
                ]
            );
        });

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Bagan diagram dan pengaturan hero struktur organisasi berhasil disimpan.');
    }

    /**
     * Tambah pejabat struktural baru.
     */
    public function storePejabat(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'guru_id' => ['nullable', 'exists:tenant.guru_staf,id'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:100'],
            'foto' => ['nullable', 'string', 'max:500'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['guru_id']) && empty($validated['foto'])) {
            $guru = GuruStaf::find($validated['guru_id']);
            if ($guru && $guru->foto) {
                $validated['foto'] = $guru->foto;
            }
        }

        if (! empty($validated['foto'])) {
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto '.$validated['nama_lengkap']);
        }

        $validated['urutan'] = $validated['urutan'] ?? (StrukturOrganisasi::max('urutan') + 1);

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Pejabat struktural baru berhasil ditambahkan.');
    }

    /**
     * Update pejabat struktural.
     */
    public function updatePejabat(Request $request, StrukturOrganisasi $pejabat, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'guru_id' => ['nullable', 'exists:tenant.guru_staf,id'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:100'],
            'foto' => ['nullable', 'string', 'max:500'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['foto'])) {
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto '.$validated['nama_lengkap']);
        }

        $pejabat->update($validated);

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Data pejabat struktural berhasil diperbarui.');
    }

    /**
     * Hapus pejabat struktural.
     */
    public function destroyPejabat(StrukturOrganisasi $pejabat): RedirectResponse
    {
        $pejabat->delete();

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Pejabat struktural berhasil dihapus.');
    }

    /**
     * Simpan kustomisasi hero banner halaman Guru & Staf publik.
     */
    public function updateGuruHero(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'judul_guru' => ['required', 'string', 'max:200'],
            'subjudul_guru' => ['nullable', 'string', 'max:500'],
            'gambar_banner_guru' => ['nullable', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['gambar_banner_guru'])) {
            $validated['gambar_banner_guru'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_banner_guru'], $adminId, 'profil', 'Banner Hero Guru & Staf');
        }

        Page::updateOrCreate(
            ['slug' => 'guru-staf'],
            [
                'judul' => $validated['judul_guru'],
                'subjudul' => $validated['subjudul_guru'] ?? null,
                'gambar_banner' => $validated['gambar_banner_guru'] ?? null,
                'isi_konten' => '',
                'pengguna_id' => $adminId,
            ]
        );

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'guru'])
            ->with('success', 'Pengaturan hero banner halaman Guru & Tenaga Kependidikan berhasil disimpan.');
    }

    /**
     * Tambah data Guru / Tenaga Kependidikan baru.
     */
    public function storeGuru(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'jabatan' => ['required', 'string', 'max:100'],
            'mata_pelajaran' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'string', 'max:500'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['foto'])) {
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto '.$validated['nama_lengkap']);
        }

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        GuruStaf::create($validated);

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'guru'])
            ->with('success', 'Data Pendidik / Tenaga Kependidikan berhasil ditambahkan.');
    }

    /**
     * Update data Guru / Tenaga Kependidikan.
     */
    public function updateGuru(Request $request, GuruStaf $guru, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['nullable', 'string', 'max:50'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'jabatan' => ['required', 'string', 'max:100'],
            'mata_pelajaran' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'string', 'max:500'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['foto'])) {
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto '.$validated['nama_lengkap']);
        }

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        $guru->update($validated);

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'guru'])
            ->with('success', 'Data Pendidik / Tenaga Kependidikan berhasil diperbarui.');
    }

    /**
     * Hapus data Guru / Tenaga Kependidikan.
     */
    public function destroyGuru(GuruStaf $guru): RedirectResponse
    {
        $guru->delete();

        return redirect()
            ->route('tenant.admin.gtk.index', ['tenant' => app('tenant')->slug, 'tab' => 'guru'])
            ->with('success', 'Data Pendidik / Tenaga Kependidikan berhasil dihapus.');
    }
}
