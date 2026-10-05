<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * Tampilkan daftar seluruh tenant sekolah terdaftar dengan filter & pencarian.
     */
    public function index(Request $request): View
    {
        $query = Sekolah::with('domains');

        // Pencarian nama sekolah atau domain
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhereHas('domains', function ($dq) use ($search) {
                        $dq->where('domain', 'like', "%{$search}%");
                    });
            });
        }

        // Filter jenjang
        if ($jenjang = $request->input('jenjang')) {
            $query->where('jenjang', $jenjang);
        }

        // Filter status operasional
        if ($request->filled('status')) {
            $status = $request->input('status') === 'aktif';
            $query->where('status_aktif', $status);
        }

        $sekolahList = $query->latest()->paginate(10)->withQueryString();

        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];

        return view('central.tenants.index', compact('sekolahList', 'daftarJenjang'));
    }

    /**
     * Tampilkan formulir pendaftaran tenant sekolah baru.
     */
    public function create(): View
    {
        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];

        return view('central.tenants.create', compact('daftarJenjang'));
    }

    /**
     * Simpan pendaftaran tenant sekolah dan domain baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:200'],
            'jenjang' => ['required', Rule::in(['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'])],
            'domain' => ['required', 'string', 'max:255', 'unique:domain_sekolah,domain', 'regex:/^[a-zA-Z0-9.-]+$/'],
            'status_aktif' => ['nullable', 'boolean'],
            'tgl_berakhir' => ['nullable', 'date'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'domain.required' => 'Subdomain/Domain sekolah wajib diisi.',
            'domain.unique' => 'Domain tersebut sudah terdaftar pada sistem.',
            'domain.regex' => 'Format domain tidak valid (gunakan huruf, angka, tanda titik atau strip).',
        ]);

        $sekolah = Sekolah::create([
            'id' => (string) Str::uuid(),
            'super_admin_id' => auth('superadmin')->id() ?? auth()->id(),
            'nama_sekolah' => $validated['nama_sekolah'],
            'slug' => Str::slug($validated['nama_sekolah']),
            'jenjang' => $validated['jenjang'],
            'status_aktif' => $request->boolean('status_aktif', true),
            'tgl_berakhir' => $validated['tgl_berakhir'] ?? null,
            'data' => [
                'telepon' => $validated['telepon'] ?? '',
                'email' => $validated['email'] ?? '',
                'alamat' => $validated['alamat'] ?? '',
            ],
        ]);

        DomainSekolah::create([
            'sekolah_id' => $sekolah->id,
            'domain' => strtolower(trim($validated['domain'])),
        ]);

        // Otomatis buat database tenant dan jalankan migrasi
        $slug_db = str_replace('-', '_', $sekolah->slug);
        $dbName = 'tenant_'.$slug_db;

        try {
            DB::connection('mysql')->statement("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            Config::set('database.connections.tenant.database', $dbName);
            DB::purge('tenant');
            DB::reconnect('tenant');

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--database' => 'tenant',
                '--class' => 'Database\\Seeders\\TenantDummySeeder',
                '--force' => true,
            ]);
        } catch (\Throwable $e) {
            Log::warning("Gagal membuat/migrasi database tenant {$dbName}: ".$e->getMessage());
        }

        return redirect()->route('superadmin.tenants.index')
            ->with('sukses', "Tenant sekolah '{$sekolah->nama_sekolah}' dan database '{$dbName}' berhasil didaftarkan dan diinisialisasi.");
    }

    /**
     * Tampilkan detail tenant sekolah beserta riwayat domain, konfigurasi, dan visibilitas menu & rute.
     */
    public function show(Sekolah $tenant): View
    {
        $tenant->load('domains');

        // Hubungkan ke database tenant untuk membaca data fitur & menu
        $slug_db = str_replace('-', '_', $tenant->slug);
        $dbName = 'tenant_'.$slug_db;

        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $fiturList = [];
        try {
            $fiturList = DB::connection('tenant')->table('pengaturan_fitur')->pluck('is_aktif', 'kode_fitur')->toArray();
        } catch (\Throwable $e) {
            Log::warning("Gagal membaca pengaturan_fitur tenant {$dbName}: ".$e->getMessage());
        }

        // Feature flags visibilitas aktual (sesuai modul yang ada)
        $fiturVisibilitas = [
            'menu_profil' => (bool) ($fiturList['menu_profil'] ?? true),
            'profil' => (bool) ($fiturList['profil'] ?? true),
            'profil_data_pokok' => (bool) ($fiturList['profil_data_pokok'] ?? true),
            'profil_sambutan_kepsek' => (bool) ($fiturList['profil_sambutan_kepsek'] ?? true),
            'profil_video' => (bool) ($fiturList['profil_video'] ?? true),
            'sejarah' => (bool) ($fiturList['sejarah'] ?? true),
            'visi_misi' => (bool) ($fiturList['visi_misi'] ?? true),
            'struktur_organisasi' => (bool) ($fiturList['struktur_organisasi'] ?? true),
            'struktur_diagram' => (bool) ($fiturList['struktur_diagram'] ?? true),
            'struktur_pejabat' => (bool) ($fiturList['struktur_pejabat'] ?? true),
            'guru_staf' => (bool) ($fiturList['guru_staf'] ?? true),
            'program_keahlian' => (bool) ($fiturList['program_keahlian'] ?? true),
            'berita' => (bool) ($fiturList['berita'] ?? true),
            'pengumuman' => (bool) ($fiturList['pengumuman'] ?? true),
            'agenda' => (bool) ($fiturList['agenda'] ?? true),
            'galeri' => (bool) ($fiturList['galeri'] ?? true),
            'fasilitas' => (bool) ($fiturList['fasilitas'] ?? true),
            'spmb' => (bool) ($fiturList['spmb'] ?? true),
            'kontak' => (bool) ($fiturList['kontak'] ?? true),
        ];

        // Susun daftar menu & sub-komponen untuk kontrol visibilitas
        $menuItems = [
            [
                'key' => 'menu_profil',
                'label' => 'Menu Profil Sekolah',
                'description' => 'Menu induk navigasi Profil Sekolah di navbar beserta seluruh sub-menunya.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['menu_profil'],
                'sub_sections' => [
                    ['key' => 'profil', 'label' => 'Halaman Utama Profil', 'type' => 'page', 'aktif' => $fiturVisibilitas['profil']],
                    ['key' => 'profil_video', 'label' => 'Video Profil Sekolah (Sidebar / Pemutar)', 'type' => 'sub_section', 'aktif' => $fiturVisibilitas['profil_video']],
                    ['key' => 'sejarah', 'label' => 'Halaman Sejarah', 'type' => 'sub_section', 'aktif' => $fiturVisibilitas['sejarah']],
                    ['key' => 'visi_misi', 'label' => 'Halaman Visi & Misi', 'type' => 'sub_section', 'aktif' => $fiturVisibilitas['visi_misi']],
                    ['key' => 'struktur_organisasi', 'label' => 'Halaman Struktur Organisasi', 'type' => 'sub_section', 'aktif' => $fiturVisibilitas['struktur_organisasi']],
                    ['key' => 'guru_staf', 'label' => 'Halaman Direktori Guru & GTK', 'type' => 'sub_section', 'aktif' => $fiturVisibilitas['guru_staf']],
                ],
            ],
            [
                'key' => 'program_keahlian',
                'label' => 'Program Keahlian / Jurusan',
                'description' => 'Menu navigasi dan halaman katalog seluruh program keahlian/jurusan vokasi.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['program_keahlian'],
                'sub_sections' => [],
            ],
            [
                'key' => 'berita',
                'label' => 'Berita & Artikel',
                'description' => 'Publikasi artikel berita sekolah, liputan kegiatan, dan artikel edukasi.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['berita'],
                'sub_sections' => [],
            ],
            [
                'key' => 'pengumuman',
                'label' => 'Pengumuman Resmi',
                'description' => 'Pemberitahuan resmi kedinasan, surat edaran, dan pengumuman sekolah.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['pengumuman'],
                'sub_sections' => [],
            ],
            [
                'key' => 'agenda',
                'label' => 'Agenda & Kegiatan',
                'description' => 'Kalender acara sekolah mendatang, jadwal ujian, dan kegiatan akademik.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['agenda'],
                'sub_sections' => [],
            ],
            [
                'key' => 'galeri',
                'label' => 'Galeri Foto & Video',
                'description' => 'Dokumentasi album foto kegiatan dan video dokumenter sekolah.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['galeri'],
                'sub_sections' => [],
            ],
            [
                'key' => 'fasilitas',
                'label' => 'Sarana & Fasilitas',
                'description' => 'Daftar sarana prasarana sekolah, ruang kelas, laboratorium, dan statistik fasilitas.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['fasilitas'],
                'sub_sections' => [],
            ],
            [
                'key' => 'spmb',
                'label' => 'SPMB / PPDB Online',
                'description' => 'Pusat informasi penerimaan murid baru, jalur seleksi, syarat, dan registrasi daring.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['spmb'],
                'sub_sections' => [],
            ],
            [
                'key' => 'kontak',
                'label' => 'Kontak & Buku Tamu',
                'description' => 'Informasi kontak sekolah, lokasi Google Maps, dan formulir pengiriman pesan publik.',
                'type' => 'menu',
                'aktif' => $fiturVisibilitas['kontak'],
                'sub_sections' => [],
            ],
        ];

        return view('central.tenants.show', compact('tenant', 'fiturVisibilitas', 'menuItems'));
    }

    /**
     * Sakelar Visibilitas Menu & Rute Tenant oleh Super Admin (AJAX/JSON).
     */
    public function toggleMenu(Request $request, Sekolah $tenant): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $kode = $request->input('kode_fitur', $request->input('key'));
        $isAktif = $request->has('is_aktif') ? $request->boolean('is_aktif') : $request->boolean('aktif');

        if (empty($kode)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode fitur atau key wajib diisi.',
            ], 422);
        }

        $slug_db = str_replace('-', '_', $tenant->slug);
        $dbName = 'tenant_'.$slug_db;

        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $namaMap = [
            'menu_profil' => 'Menu Induk Profil Sekolah',
            'profil' => 'Halaman Profil Sekolah',
            'profil_data_pokok' => 'Section Data Pokok Sekolah',
            'profil_sambutan_kepsek' => 'Section Kepala Sekolah & Sambutan',
            'profil_video' => 'Section Video Profil Sekolah',
            'sejarah' => 'Sejarah Sekolah',
            'visi_misi' => 'Visi & Misi',
            'struktur_organisasi' => 'Struktur Organisasi',
            'struktur_diagram' => 'Bagan Diagram Struktur',
            'struktur_pejabat' => 'Daftar Pejabat Struktural',
            'guru_staf' => 'Guru & Tenaga Kependidikan',
            'program_keahlian' => 'Program Keahlian / Jurusan',
            'berita' => 'Berita & Artikel',
            'pengumuman' => 'Pengumuman Resmi',
            'agenda' => 'Agenda & Kegiatan',
            'galeri' => 'Galeri Foto & Video',
            'fasilitas' => 'Sarana & Fasilitas',
            'prestasi' => 'Prestasi Siswa',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'spmb' => 'SPMB / PPDB Online',
            'kontak' => 'Kontak & Formulir Pesan',
        ];

        $urlMap = [
            'menu_profil' => '/profil',
            'profil' => '/profil',
            'sejarah' => '/profil/sejarah',
            'visi_misi' => '/profil/visi-misi',
            'struktur_organisasi' => '/profil/struktur',
            'guru_staf' => '/guru-staf',
            'program_keahlian' => '/program-keahlian',
            'berita' => '/berita',
            'pengumuman' => '/pengumuman',
            'agenda' => '/agenda',
            'galeri' => '/galeri',
            'fasilitas' => '/fasilitas',
            'prestasi' => '/prestasi',
            'ekstrakurikuler' => '/ekstrakurikuler',
            'spmb' => '/spmb',
            'kontak' => '/kontak',
        ];

        $featureName = $namaMap[$kode] ?? ucfirst(str_replace('_', ' ', $kode));

        DB::connection('tenant')->transaction(function () use ($kode, $isAktif, $featureName, $urlMap, $namaMap) {
            DB::connection('tenant')->table('pengaturan_fitur')->updateOrInsert(
                ['kode_fitur' => $kode],
                [
                    'nama_fitur' => $featureName,
                    'is_aktif' => $isAktif,
                    'updated_at' => now(),
                ]
            );

            if (isset($urlMap[$kode])) {
                DB::connection('tenant')->table('menus')->where(function ($q) use ($urlMap, $kode) {
                    $q->where('url', $urlMap[$kode])
                        ->orWhere('url', ltrim($urlMap[$kode], '/'));
                })->update(['is_aktif' => $isAktif, 'updated_at' => now()]);
            }

            // Cascade Logic untuk Menu Profil Induk
            if ($kode === 'menu_profil') {
                $subFeatures = [
                    'profil', 'profil_video', 'sejarah', 'visi_misi', 'struktur_organisasi', 'guru_staf',
                ];
                foreach ($subFeatures as $sub) {
                    DB::connection('tenant')->table('pengaturan_fitur')->updateOrInsert(
                        ['kode_fitur' => $sub],
                        [
                            'nama_fitur' => $namaMap[$sub] ?? $sub,
                            'is_aktif' => $isAktif,
                            'updated_at' => now(),
                        ]
                    );
                    if (isset($urlMap[$sub])) {
                        DB::connection('tenant')->table('menus')->where(function ($q) use ($urlMap, $sub) {
                            $q->where('url', $urlMap[$sub])
                                ->orWhere('url', ltrim($urlMap[$sub], '/'));
                        })->update(['is_aktif' => $isAktif, 'updated_at' => now()]);
                    }
                }
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Visibilitas {$featureName} berhasil diubah menjadi ".($isAktif ? 'Aktif (Tampil)' : 'Nonaktif (Disembunyikan)'),
                'is_aktif' => $isAktif,
            ]);
        }

        return back()->with('sukses', "Status visibilitas {$featureName} berhasil diperbarui.");
    }

    /**
     * Tampilkan formulir edit konfigurasi tenant sekolah (termasuk tema & warna eksklusif Super Admin).
     */
    public function edit(Sekolah $tenant): View
    {
        $tenant->load('domains');
        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];
        $primaryDomain = $tenant->domains->first()?->domain ?? '';

        // Ambil pengaturan tema & warna dari database tenant
        $slug_db = str_replace('-', '_', $tenant->slug);
        $dbName = 'tenant_'.$slug_db;

        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $pengaturanRaw = [];
        try {
            $pengaturanRaw = DB::connection('tenant')->table('pengaturan_umum')->pluck('nilai', 'kunci')->toArray();
        } catch (\Throwable $e) {
            Log::warning("Gagal membaca pengaturan_umum tenant {$dbName}: ".$e->getMessage());
        }

        return view('central.tenants.edit', compact('tenant', 'daftarJenjang', 'primaryDomain', 'pengaturanRaw'));
    }

    /**
     * Perbarui data konfigurasi tenant sekolah, domain, dan tema/warna.
     */
    public function update(Request $request, Sekolah $tenant): RedirectResponse
    {
        $primaryDomain = $tenant->domains()->first();

        $kunciWarna = [
            'warna_tema',
            'warna_aksen',
            'warna_judul',
            'warna_teks',
            'warna_teks_sekunder',
            'warna_latar_halaman',
            'warna_latar_section',
            'warna_kartu',
            'warna_border',
            'warna_tombol',
            'warna_tombol_teks',
            'warna_header',
            'warna_footer',
        ];

        $rules = [
            'nama_sekolah' => ['required', 'string', 'max:200'],
            'jenjang' => ['required', Rule::in(['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'])],
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9.-]+$/',
                Rule::unique('domain_sekolah', 'domain')->ignore($primaryDomain?->id),
            ],
            'status_aktif' => ['nullable', 'boolean'],
            'tgl_berakhir' => ['nullable', 'date'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'alamat' => ['nullable', 'string'],
            'skema_tema' => ['nullable', 'string', 'max:50'],
        ];

        foreach ($kunciWarna as $kunci) {
            $rules[$kunci] = ['nullable', 'string', 'max:25'];
        }

        $validated = $request->validate($rules);

        $tenant->update([
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang' => $validated['jenjang'],
            'status_aktif' => $request->boolean('status_aktif'),
            'tgl_berakhir' => $validated['tgl_berakhir'] ?? null,
            'data' => [
                'telepon' => $validated['telepon'] ?? '',
                'email' => $validated['email'] ?? '',
                'alamat' => $validated['alamat'] ?? '',
            ],
        ]);

        $cleanDomain = strtolower(trim($validated['domain']));
        if ($primaryDomain) {
            $primaryDomain->update(['domain' => $cleanDomain]);
        } else {
            DomainSekolah::create([
                'sekolah_id' => $tenant->id,
                'domain' => $cleanDomain,
            ]);
        }

        // Simpan tema & warna ke database tenant
        $slug_db = str_replace('-', '_', $tenant->slug);
        $dbName = 'tenant_'.$slug_db;

        try {
            Config::set('database.connections.tenant.database', $dbName);
            DB::purge('tenant');
            DB::reconnect('tenant');

            $temaData = array_merge($kunciWarna, ['skema_tema']);
            foreach ($temaData as $kunci) {
                if (array_key_exists($kunci, $validated) && $validated[$kunci] !== null) {
                    DB::connection('tenant')->table('pengaturan_umum')->updateOrInsert(
                        ['kunci' => $kunci],
                        [
                            'nilai' => $validated[$kunci],
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal menyimpan tema & warna tenant {$dbName}: ".$e->getMessage());
        }

        return redirect()->route('superadmin.tenants.show', $tenant)
            ->with('sukses', "Data tenant dan konfigurasi tema '{$tenant->nama_sekolah}' berhasil diperbarui.");
    }

    /**
     * Toggle cepat status aktif/suspend tenant sekolah.
     */
    public function toggleStatus(Sekolah $tenant): RedirectResponse
    {
        $tenant->status_aktif = ! $tenant->status_aktif;
        $tenant->save();

        $statusText = $tenant->status_aktif ? 'diaktifkan kembali' : 'dinonaktifkan (suspend)';

        return back()->with('sukses', "Status tenant '{$tenant->nama_sekolah}' berhasil {$statusText}.");
    }

    /**
     * Hapus tenant sekolah beserta seluruh data domain terkait.
     */
    public function destroy(Sekolah $tenant): RedirectResponse
    {
        $nama = $tenant->nama_sekolah;
        $tenant->delete();

        return redirect()->route('superadmin.tenants.index')
            ->with('sukses', "Tenant sekolah '{$nama}' telah dihapus dari sistem.");
    }
}
