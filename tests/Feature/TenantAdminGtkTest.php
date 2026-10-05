<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\GuruStaf;
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

test('admin can access dedicated gtk index page with sub-tabs', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/gtk');

    $response->assertStatus(200);
    $response->assertSee('Struktur Organisasi &amp; Direktori GTK', false);
    $response->assertSee('1. Struktur Organisasi');
    $response->assertSee('2. Guru &amp; Tenaga Kependidikan', false);
    $response->assertSee('Kelola Struktur Organisasi &amp; Kustomisasi Hero Banner', false);
    $response->assertSee('Daftar Guru &amp; Tenaga Kependidikan (PTK)', false);
});

test('admin can update struktur hero title, description, and banner via gtk controller', function () {
    PengaturanFitur::on('tenant')->where('kode_fitur', 'struktur_organisasi')->update(['is_aktif' => true]);

    $payload = [
        'judul_struktur' => 'Struktur Organisasi Sekolah Vokasi Unggulan',
        'subjudul_struktur' => 'Bagan alur hierarki komando dan jajaran pimpinan sekolah.',
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
        ->put('/smk-negeri-2-bandung/admin/gtk/struktur', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=struktur');
    $response->assertSessionHas('success');

    $halaman = Page::where('slug', 'struktur')->first();
    expect($halaman)->not->toBeNull()
        ->and($halaman->judul)->toBe('Struktur Organisasi Sekolah Vokasi Unggulan')
        ->and($halaman->subjudul)->toBe('Bagan alur hierarki komando dan jajaran pimpinan sekolah.')
        ->and($halaman->pengguna_id)->toBe($this->admin->id);
});

test('admin can manage pejabat struktural with relations to guru_staf via gtk controller', function () {
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
        ->post('/smk-negeri-2-bandung/admin/gtk/pejabat', [
            'nama_lengkap' => 'Drs. H. Mulyana, M.M.',
            'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum',
            'guru_id' => $guru->id,
            'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e',
            'urutan' => 1,
        ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=struktur');

    $pejabat = StrukturOrganisasi::where('jabatan', 'Wakil Kepala Sekolah Bidang Kurikulum')->first();
    expect($pejabat)->not->toBeNull()
        ->and($pejabat->guru_id)->toBe($guru->id)
        ->and($pejabat->guru->nama_lengkap)->toBe('Drs. H. Mulyana, M.M.');

    // Update
    $responseUpdate = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/gtk/pejabat/{$pejabat->id}", [
            'nama_lengkap' => 'Drs. H. Mulyana, M.M., M.Pd.',
            'jabatan' => 'Wakil Kepala Sekolah Bidang Hubin & TEFA',
            'guru_id' => $guru->id,
            'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e',
            'urutan' => 2,
        ]);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=struktur');
    expect($pejabat->fresh()->jabatan)->toBe('Wakil Kepala Sekolah Bidang Hubin & TEFA');

    // Delete
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/gtk/pejabat/{$pejabat->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=struktur');
    expect(StrukturOrganisasi::find($pejabat->id))->toBeNull();
});

test('admin can update guru hero banner via gtk controller', function () {
    $payload = [
        'judul_guru' => 'Pendidik & Tenaga Kependidikan SMK 2',
        'subjudul_guru' => 'Guru tersertifikasi industri dan tenaga kependidikan profesional.',
        'gambar_banner_guru' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/gtk/guru-hero', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=guru');
    $response->assertSessionHas('success');

    $halaman = Page::where('slug', 'guru-staf')->first();
    expect($halaman)->not->toBeNull()
        ->and($halaman->judul)->toBe('Pendidik & Tenaga Kependidikan SMK 2')
        ->and($halaman->subjudul)->toBe('Guru tersertifikasi industri dan tenaga kependidikan profesional.')
        ->and($halaman->pengguna_id)->toBe($this->admin->id);
});

test('admin can perform CRUD operations on guru via gtk controller', function () {
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
        ->post('/smk-negeri-2-bandung/admin/gtk/guru', $storePayload);

    $responseStore->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=guru');
    $responseStore->assertSessionHas('success');

    $guru = GuruStaf::where('nip', '19850515 201001 1 015')->first();
    expect($guru)->not->toBeNull()
        ->and($guru->nama_lengkap)->toBe('Budi Santoso, S.Kom., M.T.')
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
        ->put("/smk-negeri-2-bandung/admin/gtk/guru/{$guru->id}", $updatePayload);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=guru');
    $responseUpdate->assertSessionHas('success');

    $guru->refresh();
    expect($guru->nama_lengkap)->toBe('Budi Santoso, S.Kom., M.T., Ph.D.')
        ->and($guru->jabatan)->toBe('Kepala Kompetensi Keahlian RPL');

    // 3. Delete Guru
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/gtk/guru/{$guru->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/gtk?tab=guru');
    $responseDelete->assertSessionHas('success');

    expect(GuruStaf::find($guru->id))->toBeNull();
});
