<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Pengguna;
use App\Models\Tenant\StrukturOrganisasi;

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
    $response->assertSee('Struktur Organisasi');
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
        'nama_kepsek' => 'Dr. H. Hasanudin, M.Pd.',
        'nip_kepsek' => '19680512 199303 1 004',
        'foto_kepsek' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a',
        'sambutan_kepsek' => 'Selamat datang di portal resmi kami.',
        'video_profil' => 'https://www.youtube.com/watch?v=kYJydU5jUqM',
        'video_profil_judul' => 'Kilas Pembelajaran Vokasi TEFA',
        'video_profil_deskripsi' => 'Dokumentasi pembelajaran vokasi modern.',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/profil/identitas', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/profil?tab=identitas');
    $response->assertSessionHas('success');

    expect(PengaturanUmum::ambil('nama_sekolah'))->toBe('SMK Negeri 2 Bandung Juara')
        ->and(PengaturanUmum::ambil('slogan'))->toBe('Vokasi Kuat Menguatkan Indonesia')
        ->and(PengaturanUmum::ambil('logo'))->toBe('https://images.unsplash.com/photo-1599305445671-ac291c95aaa9')
        ->and(PengaturanUmum::ambil('nama_kepsek'))->toBe('Dr. H. Hasanudin, M.Pd.');

    // Relasi database: pengguna_id harus tercatat
    $record = PengaturanUmum::where('kunci', 'nama_sekolah')->first();
    expect($record->pengguna_id)->toBe($this->admin->id);
    $logoRecord = PengaturanUmum::where('kunci', 'logo')->first();
    expect($logoRecord->pengguna_id)->toBe($this->admin->id);
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

test('admin can toggle visibility of sub-menu and public route is protected', function () {
    // 1. Matikan fitur Sejarah via toggle-menu endpoint
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/profil/toggle-menu', [
            'kode_fitur' => 'sejarah',
            'is_aktif' => false,
        ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true, 'is_aktif' => false]);

    // Verifikasi di database
    expect(PengaturanFitur::isAktif('sejarah'))->toBeFalse();

    // 2. Coba akses rute publik Sejarah saat nonaktif -> Wajib 404
    $publicResponse = $this->get('/smk-negeri-2-bandung/profil/sejarah');
    $publicResponse->assertStatus(404);

    // 3. Aktifkan kembali fitur Sejarah
    $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/profil/toggle-menu', [
            'kode_fitur' => 'sejarah',
            'is_aktif' => true,
        ]);

    expect(PengaturanFitur::isAktif('sejarah'))->toBeTrue();

    // Rute publik Sejarah dapat diakses kembali
    $publicResponseActive = $this->get('/smk-negeri-2-bandung/profil/sejarah');
    $publicResponseActive->assertStatus(200);
    $publicResponseActive->assertSee('Sejarah');
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

