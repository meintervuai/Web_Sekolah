<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\StrukturOrganisasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman dashboard manajemen profil sekolah.
     */
    public function index(Request $request): View
    {
        $adminId = auth('tenant_admin')->id();
        $sekolah = app('tenant');

        // 1. Data Identitas & Pengaturan Umum
        $pengaturan = [
            'nama_sekolah' => PengaturanUmum::ambil('nama_sekolah', $sekolah->nama_sekolah),
            'slogan' => PengaturanUmum::ambil('slogan', 'Sekolah Pusat Keunggulan - Unggul, Berkarakter & Berdaya Saing Global'),
            'npsn' => PengaturanUmum::ambil('npsn', $sekolah->data['npsn'] ?? '20219146'),
            'akreditasi' => PengaturanUmum::ambil('akreditasi', $sekolah->data['akreditasi'] ?? 'A'),
            'tahun_berdiri' => PengaturanUmum::ambil('tahun_berdiri', '1951'),
            'alamat' => PengaturanUmum::ambil('alamat', $sekolah->data['alamat'] ?? ''),
            'no_telepon' => PengaturanUmum::ambil('no_telepon', $sekolah->data['telepon'] ?? ''),
            'email_sekolah' => PengaturanUmum::ambil('email_sekolah', $sekolah->data['email'] ?? ''),
            'whatsapp' => PengaturanUmum::ambil('whatsapp', '081222333444'),
            'jam_layanan' => PengaturanUmum::ambil('jam_layanan', 'Senin - Jumat: 07.00 - 16.00 WIB'),
            'logo' => PengaturanUmum::ambil('logo', ''),
            'nama_kepsek' => PengaturanUmum::ambil('nama_kepsek', 'Dr. H. Hasanudin, M.Pd.'),
            'nip_kepsek' => PengaturanUmum::ambil('nip_kepsek', '19680512 199303 1 004'),
            'foto_kepsek' => PengaturanUmum::ambil('foto_kepsek', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop'),
            'sambutan_kepsek' => PengaturanUmum::ambil('sambutan_kepsek', ''),
            'video_profil' => PengaturanUmum::ambil('video_profil', 'https://www.youtube.com/watch?v=kYJydU5jUqM'),
            'video_profil_judul' => PengaturanUmum::ambil('video_profil_judul', 'Profil & Kilas Pembelajaran Vokasi'),
            'video_profil_deskripsi' => PengaturanUmum::ambil('video_profil_deskripsi', 'Saksikan tayangan visual fasilitas modern, lingkungan belajar TEFA, dan aktivitas siswa vokasi unggulan kami.'),
            'mode_tampilan_struktur' => PengaturanUmum::ambil('mode_tampilan_struktur', 'semua'),
        ];

        // 2. Data Halaman Statis (Profil, Sejarah, Visi Misi, Struktur)
        $halamanProfil = Page::firstOrCreate(
            ['slug' => 'profil'],
            [
                'judul' => 'Profil '.$sekolah->nama_sekolah,
                'subjudul' => 'Mengenal lebih dekat sejarah, visi misi, budaya kerja, dan pimpinan satuan pendidikan kejuruan berprestasi.',
                'isi_konten' => '',
                'gambar_banner' => null,
                'pola_latar' => 'dots',
                'pengguna_id' => $adminId,
            ]
        );

        $halamanSejarah = Page::firstOrCreate(
            ['slug' => 'sejarah'],
            [
                'judul' => 'Sejarah '.$sekolah->nama_sekolah,
                'subjudul' => 'Mengenal perjalanan panjang dan tonggak bersejarah pendirian '.$sekolah->nama_sekolah.'.',
                'isi_konten' => '<p>SMK Negeri 2 Bandung didirikan pada tahun 1951 sebagai salah satu pelopor pendidikan kejuruan teknik tertua dan terkemuka di Kota Bandung.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600&auto=format&fit=crop',
                'pola_latar' => 'dots',
                'pengguna_id' => $adminId,
            ]
        );

        $halamanVisiMisi = Page::firstOrCreate(
            ['slug' => 'visi-misi'],
            [
                'judul' => 'Visi, Misi & Tujuan Satuan Pendidikan',
                'subjudul' => 'Arah haluan, cita-cita luhur, dan komitmen penyelenggaraan pendidikan vokasi di '.$sekolah->nama_sekolah.'.',
                'isi_konten' => '<h3>Visi</h3><p>Menjadi Sekolah Menengah Kejuruan unggul berstandar internasional yang menghasilkan lulusan berkarakter, berkompeten, dan berdaya saing global.</p><h3>Misi</h3><ul><li>Menyelenggarakan pembelajaran vokasi berbasis Teaching Factory (TEFA).</li><li>Mengembangkan budaya kerja industri dan nilai-nilai religius.</li><li>Membangun kemitraan strategis dengan dunia usaha dan industri.</li></ul>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop',
                'pola_latar' => 'dots',
                'pengguna_id' => $adminId,
            ]
        );

        $halamanStruktur = Page::firstOrCreate(
            ['slug' => 'struktur'],
            [
                'judul' => 'Struktur Organisasi Sekolah',
                'subjudul' => 'Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di '.$sekolah->nama_sekolah.'.',
                'isi_konten' => '',
                'gambar_banner' => null,
                'pola_latar' => 'dots',
                'pengguna_id' => $adminId,
            ]
        );

        // 3. Diagram Struktur Organisasi
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

        // 4. Pejabat Struktural
        $pejabatList = StrukturOrganisasi::with('guru')->orderBy('urutan')->get();
        $guruList = GuruStaf::where('status_aktif', true)->orderBy('nama_lengkap')->get();

        // 5. Menu Profil & Sub-item
        $menuProfil = Menu::where(function ($q) {
            $q->where('id', 2)
                ->orWhere('name', 'Profil')
                ->orWhere('url', '/profil')
                ->orWhere('url', '#');
        })->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('urutan');
            }])
            ->first();

        // 6. Feature Flags
        $fiturProfil = [
            'profil' => PengaturanFitur::isAktif('profil', true),
            'sejarah' => PengaturanFitur::isAktif('sejarah', true),
            'visi_misi' => PengaturanFitur::isAktif('visi_misi', true),
            'struktur_organisasi' => PengaturanFitur::isAktif('struktur_organisasi', true),
            'guru_staf' => PengaturanFitur::isAktif('guru_staf', true),
            'fasilitas' => PengaturanFitur::isAktif('fasilitas', true),
        ];

        return view('tenant.admin.profil.index', compact(
            'pengaturan',
            'halamanProfil',
            'halamanSejarah',
            'halamanVisiMisi',
            'halamanStruktur',
            'diagrams',
            'pejabatList',
            'guruList',
            'menuProfil',
            'fiturProfil'
        ));
    }

    /**
     * Simpan pembaruan identitas sekolah & sambutan kepala sekolah.
     */
    public function updateIdentitas(Request $request, \App\Services\MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:150'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:30'],
            'akreditasi' => ['required', 'string', 'max:20'],
            'tahun_berdiri' => ['required', 'string', 'max:10'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'email_sekolah' => ['nullable', 'email', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'jam_layanan' => ['nullable', 'string', 'max:100'],
            'logo' => ['nullable', 'string', 'max:500'],
            'nama_kepsek' => ['nullable', 'string', 'max:150'],
            'nip_kepsek' => ['nullable', 'string', 'max:50'],
            'foto_kepsek' => ['nullable', 'string', 'max:500'],
            'sambutan_kepsek' => ['nullable', 'string'],
            'video_profil' => ['nullable', 'string', 'max:500'],
            'video_profil_judul' => ['nullable', 'string', 'max:200'],
            'video_profil_deskripsi' => ['nullable', 'string', 'max:500'],
            'judul_profil' => ['nullable', 'string', 'max:200'],
            'subjudul_profil' => ['nullable', 'string', 'max:500'],
            'pola_latar_profil' => ['nullable', 'string', 'in:dots,grid,mesh,polos'],
            'gambar_banner_profil' => ['nullable', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();

        // 1. Auto-Sinkronisasi URL Eksternal ke Manajemen Media
        if (! empty($validated['logo'])) {
            $validated['logo'] = $mediaService->sinkronisasiOtomatisUrl($validated['logo'], $adminId, 'profil', 'Logo ' . $validated['nama_sekolah']);
        }
        if (! empty($validated['foto_kepsek'])) {
            $validated['foto_kepsek'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto_kepsek'], $adminId, 'profil', 'Foto ' . ($validated['nama_kepsek'] ?: 'Kepala Sekolah'));
        }
        if (! empty($validated['video_profil'])) {
            $validated['video_profil'] = $mediaService->sinkronisasiOtomatisUrl($validated['video_profil'], $adminId, 'profil', $validated['video_profil_judul'] ?: 'Video Profil Sekolah');
        }
        if (! empty($validated['gambar_banner_profil'])) {
            $validated['gambar_banner_profil'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_banner_profil'], $adminId, 'profil', 'Banner Hero Profil Sekolah');
        }

        DB::connection('tenant')->transaction(function () use ($validated, $adminId, $request) {
            $keysToSave = [
                'nama_sekolah', 'slogan', 'npsn', 'akreditasi', 'tahun_berdiri',
                'alamat', 'no_telepon', 'email_sekolah', 'whatsapp', 'jam_layanan',
                'logo', 'nama_kepsek', 'nip_kepsek', 'foto_kepsek', 'sambutan_kepsek',
                'video_profil', 'video_profil_judul', 'video_profil_deskripsi',
            ];

            foreach ($keysToSave as $kunci) {
                if (array_key_exists($kunci, $validated)) {
                    PengaturanUmum::updateOrCreate(
                        ['kunci' => $kunci],
                        [
                            'nilai' => $validated[$kunci],
                            'pengguna_id' => $adminId,
                        ]
                    );
                }
            }

            // Update judul, subjudul, gambar banner & pola latar hero halaman Profil
            Page::updateOrCreate(
                ['slug' => 'profil'],
                [
                    'judul' => $request->input('judul_profil', 'Profil '.$validated['nama_sekolah']),
                    'subjudul' => $request->input('subjudul_profil', 'Mengenal lebih dekat sejarah, visi misi, budaya kerja, dan pimpinan satuan pendidikan kejuruan berprestasi.'),
                    'pola_latar' => $request->input('pola_latar_profil', 'dots'),
                    'gambar_banner' => $validated['gambar_banner_profil'] ?? null,
                    'pengguna_id' => $adminId,
                ]
            );
        });

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'identitas'])
            ->with('success', 'Identitas sekolah, deskripsi hero, dan sambutan kepala sekolah berhasil disimpan.');
    }

    /**
     * Simpan pembaruan halaman statis (Sejarah / Visi Misi).
     */
    public function updateHalaman(Request $request, string $slug, \App\Services\MediaService $mediaService): RedirectResponse
    {
        if (! in_array($slug, ['sejarah', 'visi-misi', 'profil'], true)) {
            abort(404, 'Halaman tidak ditemukan.');
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'subjudul' => ['nullable', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_banner' => ['nullable', 'string', 'max:500'],
            'pola_latar' => ['nullable', 'string', 'in:dots,grid,mesh,polos'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $adminId = auth('tenant_admin')->id();
        $isAktif = $request->boolean('is_aktif', true);

        if (! empty($validated['gambar_banner'])) {
            $validated['gambar_banner'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_banner'], $adminId, 'profil', 'Banner ' . $validated['judul']);
        }

        DB::connection('tenant')->transaction(function () use ($slug, $validated, $adminId, $isAktif) {
            Page::updateOrCreate(
                ['slug' => $slug],
                [
                    'judul' => $validated['judul'],
                    'subjudul' => $validated['subjudul'] ?? null,
                    'isi_konten' => $validated['isi_konten'],
                    'gambar_banner' => $validated['gambar_banner'] ?? null,
                    'pola_latar' => $validated['pola_latar'] ?? 'dots',
                    'pengguna_id' => $adminId,
                ]
            );

            // Sinkronkan status aktif ke pengaturan_fitur dan menus
            $kodeFitur = $slug === 'sejarah' ? 'sejarah' : ($slug === 'visi-misi' ? 'visi_misi' : 'profil');
            $namaFitur = $slug === 'sejarah' ? 'Sejarah Sekolah' : ($slug === 'visi-misi' ? 'Visi & Misi' : 'Profil Sekolah');

            PengaturanFitur::updateOrCreate(
                ['kode_fitur' => $kodeFitur],
                [
                    'nama_fitur' => $namaFitur,
                    'is_aktif' => $isAktif,
                    'pengguna_id' => $adminId,
                ]
            );

            // Update status menu yang bersangkutan
            $targetUrl = $slug === 'sejarah' ? '/profil/sejarah' : ($slug === 'visi-misi' ? '/profil/visi-misi' : '/profil');
            Menu::where('url', $targetUrl)->update(['is_aktif' => $isAktif]);
        });

        $tab = $slug === 'sejarah' ? 'sejarah' : ($slug === 'visi-misi' ? 'visimisi' : 'identitas');

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => $tab])
            ->with('success', 'Konten halaman '.($slug === 'sejarah' ? 'Sejarah' : 'Visi & Misi').' berhasil diperbarui.');
    }

    /**
     * Simpan pembaruan diagram struktur organisasi.
     */
    public function updateStruktur(Request $request, \App\Services\MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'subjudul_struktur' => ['nullable', 'string', 'max:500'],
            'pola_latar_struktur' => ['nullable', 'string', 'in:dots,grid,mesh,polos'],
            'mode_tampilan_struktur' => ['nullable', 'string', 'in:semua,pejabat,diagram'],
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

        DB::connection('tenant')->transaction(function () use ($validated, $adminId, $diagramsList, $request) {
            PengaturanUmum::updateOrCreate(
                ['kunci' => 'struktur_diagrams'],
                [
                    'nilai' => json_encode($diagramsList),
                    'pengguna_id' => $adminId,
                ]
            );

            PengaturanUmum::updateOrCreate(
                ['kunci' => 'mode_tampilan_struktur'],
                [
                    'nilai' => $request->input('mode_tampilan_struktur', 'semua'),
                    'pengguna_id' => $adminId,
                ]
            );

            // Update subjudul & pola latar hero halaman Struktur
            Page::updateOrCreate(
                ['slug' => 'struktur'],
                [
                    'judul' => 'Struktur Organisasi Sekolah',
                    'subjudul' => $request->input('subjudul_struktur', 'Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di sekolah.'),
                    'pola_latar' => $request->input('pola_latar_struktur', 'dots'),
                    'pengguna_id' => $adminId,
                ]
            );
        });

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Bagan diagram dan pengaturan hero struktur organisasi berhasil disimpan.');
    }

    /**
     * Tambah pejabat struktural baru.
     */
    public function storePejabat(Request $request, \App\Services\MediaService $mediaService): RedirectResponse
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
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto ' . $validated['nama_lengkap']);
        }

        $validated['urutan'] = $validated['urutan'] ?? (StrukturOrganisasi::max('urutan') + 1);

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Pejabat struktural baru berhasil ditambahkan.');
    }

    /**
     * Update pejabat struktural.
     */
    public function updatePejabat(Request $request, StrukturOrganisasi $pejabat, \App\Services\MediaService $mediaService): RedirectResponse
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
            $validated['foto'] = $mediaService->sinkronisasiOtomatisUrl($validated['foto'], $adminId, 'profil', 'Foto ' . $validated['nama_lengkap']);
        }

        $pejabat->update($validated);

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Data pejabat struktural berhasil diperbarui.');
    }

    /**
     * Hapus pejabat struktural.
     */
    public function destroyPejabat(StrukturOrganisasi $pejabat): RedirectResponse
    {
        $pejabat->delete();

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'struktur'])
            ->with('success', 'Pejabat struktural berhasil dihapus.');
    }

    /**
     * Toggle visibilitas menu atau sub-menu secara asinkron / form.
     */
    public function toggleMenu(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'menu_id' => ['nullable', 'integer', 'exists:tenant.menus,id'],
            'kode_fitur' => ['nullable', 'string', 'max:50'],
            'is_aktif' => ['required', 'boolean'],
        ]);

        $adminId = auth('tenant_admin')->id();
        $isAktif = (bool) $validated['is_aktif'];
        $menuName = 'Menu';

        DB::connection('tenant')->transaction(function () use ($validated, $isAktif, $adminId, &$menuName) {
            // 1. Jika diberikan menu_id
            if (! empty($validated['menu_id'])) {
                $menu = Menu::find($validated['menu_id']);
                if ($menu) {
                    $menu->update(['is_aktif' => $isAktif]);
                    $menuName = $menu->name;

                    // Petakan URL menu ke kode_fitur
                    $mapping = [
                        '/profil' => 'profil',
                        '/profil/sejarah' => 'sejarah',
                        '/profil/visi-misi' => 'visi_misi',
                        '/profil/struktur' => 'struktur_organisasi',
                        '/guru-staf' => 'guru_staf',
                        '/fasilitas' => 'fasilitas',
                    ];

                    $urlClean = '/'.ltrim($menu->url, '/');
                    if (isset($mapping[$urlClean])) {
                        PengaturanFitur::updateOrCreate(
                            ['kode_fitur' => $mapping[$urlClean]],
                            [
                                'nama_fitur' => $menu->name,
                                'is_aktif' => $isAktif,
                                'pengguna_id' => $adminId,
                            ]
                        );
                    }
                }
            }

            // 2. Jika diberikan kode_fitur langsung
            if (! empty($validated['kode_fitur'])) {
                $kode = $validated['kode_fitur'];
                $namaMap = [
                    'profil' => 'Profil Sekolah',
                    'sejarah' => 'Sejarah Sekolah',
                    'visi_misi' => 'Visi & Misi',
                    'struktur_organisasi' => 'Struktur Organisasi',
                    'guru_staf' => 'Guru & Staf',
                    'fasilitas' => 'Fasilitas Sekolah',
                ];

                PengaturanFitur::updateOrCreate(
                    ['kode_fitur' => $kode],
                    [
                        'nama_fitur' => $namaMap[$kode] ?? ucfirst(str_replace('_', ' ', $kode)),
                        'is_aktif' => $isAktif,
                        'pengguna_id' => $adminId,
                    ]
                );

                $urlMap = [
                    'profil' => '/profil',
                    'sejarah' => '/profil/sejarah',
                    'visi_misi' => '/profil/visi-misi',
                    'struktur_organisasi' => '/profil/struktur',
                    'guru_staf' => '/guru-staf',
                    'fasilitas' => '/fasilitas',
                ];

                if (isset($urlMap[$kode])) {
                    Menu::where('url', $urlMap[$kode])->update(['is_aktif' => $isAktif]);
                }
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Visibilitas {$menuName} berhasil diubah menjadi ".($isAktif ? 'Aktif (Tampil)' : 'Nonaktif (Sembunyi)'),
                'is_aktif' => $isAktif,
            ]);
        }

        return redirect()
            ->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug, 'tab' => 'visibilitas'])
            ->with('success', "Status visibilitas {$menuName} berhasil diperbarui.");
    }
}
