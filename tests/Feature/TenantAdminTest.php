<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\Pengguna;
use App\Models\Tenant\StrukturOrganisasi;
use Illuminate\Support\Str;

beforeEach(function () {
    // Setup Tenant Sekolah
    $this->sekolah = Sekolah::firstOrCreate(
        ['slug' => 'smk-negeri-2-bandung'],
        [
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]
    );
});

test('halaman login admin sekolah dapat diakses oleh guest', function () {
    $response = $this->get('/smk-negeri-2-bandung/admin/login');

    $response->assertStatus(200);
    $response->assertSee('Panel Admin Sekolah');
    $response->assertSee('SMK Negeri 2 Bandung');
});

test('dashboard admin sekolah dilindungi middleware auth tenant_admin', function () {
    $response = $this->get('/smk-negeri-2-bandung/admin/dashboard');

    $response->assertRedirect('/smk-negeri-2-bandung/admin/login');
});

test('halaman pengaturan sekolah dilindungi middleware auth', function () {
    $response = $this->get('/smk-negeri-2-bandung/admin/pengaturan');

    $response->assertRedirect('/smk-negeri-2-bandung/admin/login');
});

test('admin sekolah dapat login dengan kredensial yang valid', function () {
    $response = $this->post('/smk-negeri-2-bandung/admin/login', [
        'email' => 'admin@smkn2bdg.test',
        'password' => 'password',
    ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/dashboard');
    $this->assertAuthenticatedAs(Pengguna::first(), 'tenant_admin');
});

test('admin sekolah yang login dapat mengakses seluruh halaman pengaturan per navigasi', function () {
    $user = Pengguna::first();

    $routes = [
        '/smk-negeri-2-bandung/admin/dashboard',
        '/smk-negeri-2-bandung/admin/slider',
        '/smk-negeri-2-bandung/admin/pengaturan',
        '/smk-negeri-2-bandung/admin/profil',
        '/smk-negeri-2-bandung/admin/struktur',
        '/smk-negeri-2-bandung/admin/jurusan',
        '/smk-negeri-2-bandung/admin/berita',
        '/smk-negeri-2-bandung/admin/pengumuman',
        '/smk-negeri-2-bandung/admin/agenda',
        '/smk-negeri-2-bandung/admin/galeri',
        '/smk-negeri-2-bandung/admin/prestasi',
        '/smk-negeri-2-bandung/admin/ekskul',
        '/smk-negeri-2-bandung/admin/guru',
        '/smk-negeri-2-bandung/admin/fasilitas',
        '/smk-negeri-2-bandung/admin/spmb',
        '/smk-negeri-2-bandung/admin/kontak',
    ];

    foreach ($routes as $url) {
        $response = $this->actingAs($user, 'tenant_admin')->get($url);
        $response->assertStatus(200);
    }
});

test('admin sekolah dapat menambah dan menghapus anggota struktur organisasi pada menu struktur', function () {
    $user = Pengguna::first();

    $response = $this->actingAs($user, 'tenant_admin')->post('/smk-negeri-2-bandung/admin/struktur/anggota', [
        'nama_lengkap' => 'Dra. Hj. Test Pejabat, M.Pd.',
        'jabatan' => 'Wakasek Penguji',
        'urutan' => 99,
    ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/struktur');
    $item = StrukturOrganisasi::where('nama_lengkap', 'Dra. Hj. Test Pejabat, M.Pd.')->first();
    expect($item)->not->toBeNull();

    $delResponse = $this->actingAs($user, 'tenant_admin')->delete('/smk-negeri-2-bandung/admin/struktur/anggota/'.$item->id);
    $delResponse->assertRedirect('/smk-negeri-2-bandung/admin/struktur');
    expect(StrukturOrganisasi::find($item->id))->toBeNull();
});
