<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\Pengguna;

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

    // Setup Dummy Guru untuk Kepala Program
    $this->guru = GuruStaf::firstOrCreate(
        ['nip' => '19800101 200501 1 001'],
        [
            'nama_lengkap' => 'Drs. H. Ahmad Junaedi, M.T.',
            'jenis_kelamin' => 'L',
            'jabatan' => 'Guru Produktif Teknik',
            'status_aktif' => true,
        ]
    );
});

test('admin can access program keahlian index page with tabs', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/program-keahlian');

    $response->assertStatus(200);
    $response->assertSee('Pengaturan Program Keahlian / Jurusan');
    $response->assertSee('Daftar Konsentrasi &amp; Program Keahlian', false);
    $response->assertSee('Kustomisasi Hero Banner (Halaman Program Keahlian Publik)');
    $response->assertDontSee('4. Visibilitas Menu &amp; Rute', false);
});

test('admin can update hero banner configuration for program keahlian', function () {
    $payload = [
        'judul_halaman' => 'Katalog Program Keahlian Vokasi',
        'subjudul_halaman' => 'Pilihan keahlian industri 4.0 berakreditasi A dengan fasilitas teaching factory.',
        'gambar_banner_jurusan' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/program-keahlian/hero', $payload);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/program-keahlian?tab=hero');
    $response->assertSessionHas('success');

    $page = Page::where('slug', 'program-keahlian')->first();
    expect($page)->not->toBeNull()
        ->and($page->judul)->toBe('Katalog Program Keahlian Vokasi')
        ->and($page->subjudul)->toBe('Pilihan keahlian industri 4.0 berakreditasi A dengan fasilitas teaching factory.');
});

test('admin can perform CRUD operations on program keahlian / jurusan', function () {
    // Pastikan tidak ada data sisa dari test run sebelumnya
    Jurusan::where('slug', 'teknik-mekatronika-industri')->delete();

    // 1. Create Jurusan
    $storePayload = [
        'nama_jurusan' => 'Teknik Mekatronika Industri',
        'singkatan' => 'TMI',
        'logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9',
        'slug' => 'teknik-mekatronika-industri',
        'guru_id' => $this->guru->id,
        'deskripsi_singkat' => 'Mempelajari otomasi industri, PLC, robotika, dan pneumatik.',
        'deskripsi_lengkap' => '<p>Uraian lengkap kompetensi keahlian teknik mekatronika.</p>',
        'ikon_atau_foto' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758',
        'jenjang' => 'SMK (3 Tahun)',
        'peluang_kerja' => 'Industri Manufaktur, Automation Engineer',
        'sertifikasi' => 'LSP-P1 Mekatronika / BNSP',
        'urutan' => 8,
        'is_aktif' => 1,
        'galeri_foto' => [
            'https://images.unsplash.com/photo-1581092335397-9583fe92d232',
        ],
        'galeri_judul' => [
            'Bengkel CNC & Lab PLC',
        ],
    ];

    $responseStore = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/program-keahlian', $storePayload);

    $responseStore->assertRedirect('/smk-negeri-2-bandung/admin/program-keahlian?tab=jurusan');
    $responseStore->assertSessionHas('success');

    $jurusan = Jurusan::with('fotos')->where('slug', 'teknik-mekatronika-industri')->first();
    expect($jurusan)->not->toBeNull()
        ->and($jurusan->nama_jurusan)->toBe('Teknik Mekatronika Industri')
        ->and($jurusan->singkatan)->toBe('TMI')
        ->and($jurusan->logo)->not->toBeEmpty()
        ->and($jurusan->guru_id)->toBe($this->guru->id)
        ->and($jurusan->is_aktif)->toBeTrue()
        ->and($jurusan->fotos->count())->toBe(1);

    // 2. Update Jurusan
    $updatePayload = [
        'nama_jurusan' => 'Teknik Mekatronika & Otomasi Industri',
        'singkatan' => 'TMOI',
        'logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9',
        'slug' => 'teknik-mekatronika-industri',
        'guru_id' => $this->guru->id,
        'deskripsi_singkat' => 'Mempelajari otomasi industri, PLC, robotika modern, sensorik dan pneumatik.',
        'deskripsi_lengkap' => '<p>Uraian lengkap kompetensi mekatronika revisi.</p>',
        'ikon_atau_foto' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758',
        'jenjang' => 'SMK (4 Tahun)',
        'peluang_kerja' => 'Industri Otomasi & Robotika Global',
        'sertifikasi' => 'BNSP / Festo Certified',
        'urutan' => 8,
        'is_aktif' => 1,
    ];

    $responseUpdate = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/program-keahlian/{$jurusan->id}", $updatePayload);

    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/program-keahlian?tab=jurusan');
    $responseUpdate->assertSessionHas('success');

    $jurusan->refresh();
    expect($jurusan->nama_jurusan)->toBe('Teknik Mekatronika & Otomasi Industri')
        ->and($jurusan->singkatan)->toBe('TMOI');

    // 3. Toggle Status per Jurusan
    $responseToggle = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/program-keahlian/toggle-status', [
            'target_type' => 'jurusan',
            'jurusan_id' => $jurusan->id,
            'is_aktif' => false,
        ]);

    $responseToggle->assertStatus(200);
    $jurusan->refresh();
    expect($jurusan->is_aktif)->toBeFalse();

    // 4. Delete Jurusan
    $responseDelete = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/program-keahlian/{$jurusan->id}");

    $responseDelete->assertRedirect('/smk-negeri-2-bandung/admin/program-keahlian?tab=jurusan');
    $responseDelete->assertSessionHas('success');

    expect(Jurusan::find($jurusan->id))->toBeNull();
});

test('admin cannot toggle global feature flag for program keahlian', function () {
    // Percobaan admin sekolah menonaktifkan fitur master program_keahlian harus ditolak (403)
    $responseOff = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/program-keahlian/toggle-status', [
            'target_type' => 'fitur',
            'is_aktif' => false,
        ]);

    $responseOff->assertStatus(403);
});
