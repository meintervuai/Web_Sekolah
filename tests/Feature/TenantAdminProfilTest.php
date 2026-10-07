<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Pengguna;
use App\Models\Tenant\StrukturOrganisasi;

/**
 * @property \App\Models\Central\Sekolah $sekolah
 * @property \App\Models\Tenant\Pengguna $admin
 */
beforeEach(function () {
    // Setup Tenant Context
    $this->sekolah = Sekolah::firstOrCreate(
        ['slug' => 'smk-negeri-2-bandung'],
        [
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]
    );

    app()->instance('tenant', $this->sekolah);

    // Setup Admin Pengguna
    $this->admin = Pengguna::firstOrCreate(
        ['email' => 'admin@smkn2bandung.sch.id'],
        [
            'nama' => 'Administrator Sekolah',
            'password' => bcrypt('password123'),
            'peran' => 'admin',
            'status_aktif' => true,
        ]
    );
});

test('admin can access profil index page with tabs', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/profil');

    $response->assertStatus(200);
    $response->assertSee('Pengaturan Profil &amp; Konten Sekolah', false);
    $response->assertSee('Data Pokok Satuan Pendidikan');
    $response->assertSee('Sejarah Sekolah');
    $response->assertSee('Visi, Misi &amp; Sasaran Mutu', false);
    $response->assertDontSee('5. Visibilitas Menu &amp; Rute', false);

    // Kontrol yang sudah dihapus tidak boleh muncul lagi di form admin
    $response->assertDontSee('pola_latar_profil');
    $response->assertDontSee('mode_tampilan_struktur');
});

test('admin can update school identity and headmaster information', function () {
    $payload = [
        'nama_sekolah' => 'SMK Negeri 2 Bandung Juara',
        'slogan' => 'Vokasi Kuat Menguatkan Indonesia',
        'npsn' => '20219146',
        'akreditasi' => 'A',
        'tahun_berdiri' => '1951',
        'alamat' => 'Jl. Ciliwung No. 4 Bandung',
        'no_telepon' => '022-7234285',
        'email_sekolah' => 'info@smkn2bandung.sch.id',
        'whatsapp' => '081222333444',
        'jam_layanan' => '07.00 - 16.00 WIB',
        'logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9',
        'instagram' => 'https://instagram.com/smkn2bandungjuara',
        'facebook' => 'https://facebook.com/smkn2bandungjuara',
        'twitter' => 'https://x.com/smkn2bandung',
        'youtube' => 'https://youtube.com/@smkn2bandung',
        'tiktok' => 'https://tiktok.com/@smkn2bandung',
        'nama_kepsek' => 'Dr. H. Hasanudin, M.Pd.',
        'nip_kepsek' => '19680512 199303 1 004',
        'foto_kepsek' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a',
        'sambutan_kepsek' => 'Selamat datang di portal resmi kami.',
        'video_profil' => 'https://www.youtube.com/watch?v=kYJydU5jUqM',
        'video_profil_judul' => 'Kilas Pembelajaran Vokasi TEFA',
        'video_profil_deskripsi' => 'Dokumentasi pembelajaran vokasi modern.',
        'judul_profil' => 'Profil Singkat & Budaya Kerja SMK 2',
        'subjudul_profil' => 'Subjudul hero profil baru.',
        'gambar_banner_profil' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b',
        'isi_konten_profil' => '<p>Uraian lengkap profil sekolah dengan WYSIWYG editor.</p>',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/identitas', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=datadiri');
    $response->assertSessionHas('success');

    expect(PengaturanUmum::ambil('nama_sekolah'))->toBe('SMK Negeri 2 Bandung Juara')
        ->and(PengaturanUmum::ambil('slogan'))->toBe('Vokasi Kuat Menguatkan Indonesia')
        ->and(PengaturanUmum::ambil('logo'))->toBe('https://images.unsplash.com/photo-1599305445671-ac291c95aaa9')
        ->and(PengaturanUmum::ambil('instagram'))->toBe('https://instagram.com/smkn2bandungjuara')
        ->and(PengaturanUmum::ambil('nama_kepsek'))->toBe('Dr. H. Hasanudin, M.Pd.');

    $pageProfil = Page::where('slug', 'profil')->first();
    expect($pageProfil)->not->toBeNull()
        ->and($pageProfil->judul)->toBe('Profil Singkat & Budaya Kerja SMK 2')
        ->and($pageProfil->isi_konten)->toBe('<p>Uraian lengkap profil sekolah dengan WYSIWYG editor.</p>')
        ->and($pageProfil->pengguna_id)->toBe($this->admin->id);

    // Relasi database: pengguna_id harus tercatat
    $record = PengaturanUmum::where('kunci', 'nama_sekolah')->first();
    expect($record->pengguna_id)->toBe($this->admin->id);
    $logoRecord = PengaturanUmum::where('kunci', 'logo')->first();
    expect($logoRecord->pengguna_id)->toBe($this->admin->id);
});

test('admin can update page profil banner and wysiwyg description separately', function () {
    $payload = [
        'form_type' => 'halaman_profil',
        'current_tab' => 'identitas',
        'judul_profil' => 'Keunggulan & Karakter Siswa',
        'subjudul_profil' => 'Penjelasan kurikulum industri berbasis TEFA.',
        'gambar_banner_profil' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b',
        'isi_konten_profil' => '<p>Budaya 5R dan kedisiplinan kerja industri.</p>',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/identitas', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=identitas');
    $response->assertSessionHas('success');

    $pageProfil = Page::where('slug', 'profil')->first();
    expect($pageProfil)->not->toBeNull()
        ->and($pageProfil->judul)->toBe('Keunggulan & Karakter Siswa')
        ->and($pageProfil->subjudul)->toBe('Penjelasan kurikulum industri berbasis TEFA.')
        ->and($pageProfil->isi_konten)->toBe('<p>Budaya 5R dan kedisiplinan kerja industri.</p>')
        ->and($pageProfil->pengguna_id)->toBe($this->admin->id);
});

test('admin can update sejarah content and visibility with WYSIWYG format', function () {
    $payload = [
        'judul' => 'Sejarah Panjang SMK Negeri 2 Bandung',
        'isi_konten' => '<h2>Awal Berdiri</h2><p>Didirikan pada tahun 1951 dengan dedikasi tinggi.</p>',
        'gambar_banner' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f',
        'is_aktif' => 1,
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/halaman/sejarah', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=sejarah');

    $page = Page::where('slug', 'sejarah')->first();
    expect($page)->not->toBeNull()
        ->and($page->judul)->toBe('Sejarah Panjang SMK Negeri 2 Bandung')
        ->and($page->isi_konten)->toContain('<h2>Awal Berdiri</h2>')
        ->and($page->pengguna_id)->toBe($this->admin->id);

    expect(PengaturanFitur::isAktif('sejarah'))->toBeTrue();
});

test('admin can update visi-misi content with WYSIWYG format', function () {
    $payload = [
        'judul' => 'Visi & Misi Unggulan 2026',
        'isi_konten' => '<h3>Visi Utama</h3><p>Mencetak talenta digital dan manufaktur berdaya saing global.</p>',
        'gambar_banner' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644',
        'is_aktif' => 1,
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/halaman/visi-misi', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=visimisi');

    $page = Page::where('slug', 'visi-misi')->first();
    expect($page)->not->toBeNull()
        ->and($page->judul)->toBe('Visi & Misi Unggulan 2026')
        ->and($page->pengguna_id)->toBe($this->admin->id);

    expect(PengaturanFitur::isAktif('visi_misi'))->toBeTrue();
});

test('admin can manage pejabat struktural with relations to guru_staf', function () {
    $guru = GuruStaf::firstOrCreate(
        ['nama_lengkap' => 'Drs. H. Mulyana, M.M.'],
        [
            'nip' => '19700101 199501 1 001',
            'jenis_kelamin' => 'L',
            'jabatan' => 'Guru Kejuruan',
            'status_aktif' => true,
        ]
    );

    // Create
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/profil/pejabat', [
            'nama_lengkap' => 'Drs. H. Mulyana, M.M.',
            'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum',
            'guru_id' => $guru->id,
            'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e',
            'urutan' => 1,
        ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=struktur');

    $pejabat = StrukturOrganisasi::where('jabatan', 'Wakil Kepala Sekolah Bidang Kurikulum')->first();
    expect($pejabat)->not->toBeNull()
        ->and($pejabat->guru_id)->toBe($guru->id)
        ->and($pejabat->guru->nama_lengkap)->toBe('Drs. H. Mulyana, M.M.');

    // Update
    $responseUpdate = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/profil/pejabat/{$pejabat->id}", [
            'nama_lengkap' => 'Drs. H. Mulyana, M.M., M.Pd.',
            'jabatan' => 'Wakil Kepala Sekolah Bidang Hubin & TEFA',
            'guru_id' => $guru->id,
            'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e',
            'urutan' => 2,
        ]);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=struktur');
    expect($pejabat->fresh()->jabatan)->toBe('Wakil Kepala Sekolah Bidang Hubin & TEFA');

    // Delete
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/profil/pejabat/{$pejabat->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=struktur');
    expect(StrukturOrganisasi::find($pejabat->id))->toBeNull();
});

test('admin can update struktur hero title, description, and banner and it appears on public page', function () {
    PengaturanFitur::on('tenant')->where('kode_fitur', 'struktur_organisasi')->update(['is_aktif' => true]);

    $payload = [
        'judul_struktur' => 'Struktur Organisasi Sekolah Vokasi',
        'subjudul_struktur' => 'Bagan alur komando dan jajaran pimpinan sekolah.',
        'gambar_banner_struktur' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0',
        'diagrams' => [
            [
                'judul' => 'Bagan Struktur Utama Manajemen Sekolah',
                'deskripsi' => 'Alur komando Kepala Sekolah hingga Koordinator Tata Usaha.',
                'gambar' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0',
            ],
        ],
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/struktur', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=struktur');
    $response->assertSessionHas('success');

    // Relasi database: pengguna_id harus tercatat, judul/subjudul/banner tersimpan
    $halaman = Page::where('slug', 'struktur')->first();
    expect($halaman)->not->toBeNull()
        ->and($halaman->judul)->toBe('Struktur Organisasi Sekolah Vokasi')
        ->and($halaman->subjudul)->toBe('Bagan alur komando dan jajaran pimpinan sekolah.')
        ->and($halaman->gambar_banner)->not->toBeNull()
        ->and($halaman->pengguna_id)->toBe($this->admin->id);

    // Judul dan banner harus tampil di halaman publik struktur
    $public = $this->get('/smk-negeri-2-bandung/profil/struktur');
    $public->assertStatus(200);
    $public->assertSee('Struktur Organisasi Sekolah Vokasi');
    $public->assertSee($halaman->gambar_banner, false);
});

test('admin cannot toggle visibility of sub-menu and is rejected', function () {
    // 1. Percobaan mematikan fitur Sejarah via toggle-menu endpoint oleh Admin Sekolah harus ditolak (403)
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/profil/toggle-menu', [
            'kode_fitur' => 'sejarah',
            'is_aktif' => false,
        ]);

    $response->assertStatus(403);
});

test('admin can fetch media list via json ajax and access admin root redirect', function () {
    // 1. Test GET /admin/media with JSON/Ajax
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->getJson('/smk-negeri-2-bandung/admin/media?tipe=semua&q=');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'success',
        'data',
        'current_page',
        'last_page',
        'total',
    ]);

    // 2. Test GET /admin root redirects to dashboard/profil
    $responseAdminRoot = $this->actingAs($this->admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin');

    $responseAdminRoot->assertRedirect('/smk-negeri-2-bandung/admin/profil');
});

test('admin can update guru-staf hero banner and it displays on public guru-staf page', function () {
    PengaturanFitur::on('tenant')->where('kode_fitur', 'guru_staf')->update(['is_aktif' => true]);

    $payload = [
        'judul_guru' => 'Pendidik & Tenaga Kependidikan Berprestasi',
        'subjudul_guru' => 'Guru tersertifikasi industri dan tenaga kependidikan profesional.',
        'gambar_banner_guru' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/guru-hero', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=guru');
    $response->assertSessionHas('success');

    // Page guru-staf updated
    $halaman = Page::where('slug', 'guru-staf')->first();
    expect($halaman)->not->toBeNull()
        ->and($halaman->judul)->toBe('Pendidik & Tenaga Kependidikan Berprestasi')
        ->and($halaman->subjudul)->toBe('Guru tersertifikasi industri dan tenaga kependidikan profesional.')
        ->and($halaman->gambar_banner)->toBe('https://images.unsplash.com/photo-1524178232363-1fb2b075b655')
        ->and($halaman->pengguna_id)->toBe($this->admin->id);

    // Verify public page /guru-staf
    $publicResponse = $this->get('/smk-negeri-2-bandung/guru-staf');
    $publicResponse->assertStatus(200);
    $publicResponse->assertSee('Pendidik &amp; Tenaga Kependidikan Berprestasi', false);
    $publicResponse->assertSee('Guru tersertifikasi industri dan tenaga kependidikan profesional.');
    $publicResponse->assertSee('https://images.unsplash.com/photo-1524178232363-1fb2b075b655');
});

test('admin can perform CRUD operations on guru and tenaga kependidikan', function () {
    // 1. Create Guru
    $storePayload = [
        'nama_lengkap' => 'Budi Santoso, S.Kom., M.T.',
        'nip' => '19850515 201001 1 015',
        'jenis_kelamin' => 'L',
        'jabatan' => 'Guru Produktif RPL',
        'mata_pelajaran' => 'Pemrograman Web & Mobile',
        'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb',
        'status_aktif' => 1,
    ];

    $responseStore = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/profil/guru', $storePayload);

    $responseStore->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=guru');
    $responseStore->assertSessionHas('success');

    $guru = GuruStaf::where('nip', '19850515 201001 1 015')->first();
    expect($guru)->not->toBeNull()
        ->and($guru->nama_lengkap)->toBe('Budi Santoso, S.Kom., M.T.')
        ->and($guru->jenis_kelamin)->toBe('L')
        ->and($guru->status_aktif)->toBeTrue();

    // 2. Update Guru
    $updatePayload = [
        'nama_lengkap' => 'Budi Santoso, S.Kom., M.T., Ph.D.',
        'nip' => '19850515 201001 1 015',
        'jenis_kelamin' => 'L',
        'jabatan' => 'Kepala Kompetensi Keahlian RPL',
        'mata_pelajaran' => 'Rekayasa Perangkat Lunak Lanjut',
        'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb',
        'status_aktif' => 1,
    ];

    $responseUpdate = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/profil/guru/{$guru->id}", $updatePayload);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=guru');
    $responseUpdate->assertSessionHas('success');

    $guru->refresh();
    expect($guru->nama_lengkap)->toBe('Budi Santoso, S.Kom., M.T., Ph.D.')
        ->and($guru->jabatan)->toBe('Kepala Kompetensi Keahlian RPL');

    // 3. Delete Guru
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/profil/guru/{$guru->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=guru');
    $responseDelete->assertSessionHas('success');

    expect(GuruStaf::find($guru->id))->toBeNull();
});

test('admin can perform CRUD operations on hero banner slider beranda', function () {
    // 1. Create Slider
    $storePayload = [
        'judul' => 'Inovasi Digital Pendidikan Vokasi Unggul',
        'subjudul' => 'Menghubungkan kurikulum industri masa depan dengan talenta siswa berdaya saing global.',
        'gambar' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
        'video' => null,
        'teks_tombol' => 'Jelajahi Program',
        'link_tombol' => '/jurusan',
        'urutan' => 1,
        'is_aktif' => 1,
    ];

    $responseStore = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/profil/slider', $storePayload);

    $responseStore->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=slider');
    $responseStore->assertSessionHas('success');

    $slider = \App\Models\Tenant\SliderBeranda::where('judul', 'Inovasi Digital Pendidikan Vokasi Unggul')->first();
    expect($slider)->not->toBeNull()
        ->and($slider->teks_tombol)->toBe('Jelajahi Program')
        ->and($slider->link_tombol)->toBe('/jurusan')
        ->and($slider->is_aktif)->toBeTrue();

    // 2. Update Slider
    $updatePayload = [
        'judul' => 'Mencetak Generasi Unggul Siap Kerja',
        'subjudul' => 'Pembelajaran berbasis proyek riil bersama mitra industri terkemuka.',
        'gambar' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
        'video' => null,
        'teks_tombol' => 'Daftar Sekarang',
        'link_tombol' => '/spmb',
        'urutan' => 2,
        'is_aktif' => 1,
    ];

    $responseUpdate = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/profil/slider/{$slider->id}", $updatePayload);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=slider');
    $responseUpdate->assertSessionHas('success');

    $slider->refresh();
    expect($slider->judul)->toBe('Mencetak Generasi Unggul Siap Kerja')
        ->and($slider->teks_tombol)->toBe('Daftar Sekarang')
        ->and($slider->urutan)->toBe(2);

    // 3. Check Homepage reflects the slider
    $homeResponse = $this->get('/smk-negeri-2-bandung');
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('Mencetak Generasi Unggul Siap Kerja');
    $homeResponse->assertSee('Daftar Sekarang');

    // 4. Delete Slider
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/profil/slider/{$slider->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=slider');
    $responseDelete->assertSessionHas('success');

    expect(\App\Models\Tenant\SliderBeranda::find($slider->id))->toBeNull();
});
