<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Pengguna;
use App\Models\Tenant\Post;
use App\Models\Tenant\SliderBeranda;
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

test('halaman pengaturan tampilan sekolah dilindungi middleware auth', function () {
    $response = $this->get('/smk-negeri-2-bandung/admin/pengaturan');

    $response->assertRedirect('/smk-negeri-2-bandung/admin/login');
});

test('admin sekolah dapat login dan langsung diarahkan ke halaman pengaturan tema', function () {
    $response = $this->post('/smk-negeri-2-bandung/admin/login', [
        'email' => 'admin@smkn2bdg.test',
        'password' => 'password',
    ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/pengaturan');
    $this->assertAuthenticatedAs(Pengguna::first(), 'tenant_admin');
});

test('login admin dengan remember me menyetel cookie dan session lifetime 24 jam', function () {
    expect(config('session.lifetime'))->toBe(1440);

    $response = $this->post('/smk-negeri-2-bandung/admin/login', [
        'email' => 'admin@smkn2bdg.test',
        'password' => 'password',
        'remember' => '1',
    ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/pengaturan');
    $this->assertAuthenticatedAs(Pengguna::first(), 'tenant_admin');

    // Memastikan guard remember cookie terkirim
    $user = Pengguna::first();
    expect($user->getRememberToken())->not()->toBeEmpty();
});

test('admin yang sudah login dan membuka halaman login diarahkan ke pengaturan tema', function () {
    $response = $this->actingAs(Pengguna::first(), 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/login');

    $response->assertRedirect('/smk-negeri-2-bandung/admin/pengaturan');
});

test('halaman pengaturan tema dapat dibuka oleh admin sekolah', function () {
    $response = $this->actingAs(Pengguna::first(), 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/pengaturan');

    $response->assertStatus(200);
    $response->assertSee('Tema & Warna');
    $response->assertSee('Pengaturan Tema & Warna Portal Sekolah', false);
    $response->assertSee('Rincian Warna per Bagian Tampilan', false);
    $response->assertDontSee('Identitas Pokok & Logo Sekolah', false);
    $response->assertDontSee('Statistik Sekolah (Tampil di Beranda)');
    $response->assertDontSee('Video Profil Sekolah (Publik)');
});

test('sidebar admin memuat menu pengaturan tema dan manajemen media', function () {
    $response = $this->actingAs(Pengguna::first(), 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/pengaturan');

    $response->assertStatus(200);
    $response->assertSee('Tema & Warna');
    $response->assertSee('Manajemen Media');
    $response->assertDontSee('Slider Banner Hero');
    $response->assertDontSee('Pesan Pengunjung');
    $response->assertDontSee('Dashboard');
});

test('seluruh route modul admin lama sudah dihapus dari sistem', function () {
    $user = Pengguna::first();

    $removedRoutes = [
        '/smk-negeri-2-bandung/admin/dashboard',
        '/smk-negeri-2-bandung/admin/slider',
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

    foreach ($removedRoutes as $url) {
        $this->actingAs($user, 'tenant_admin')->get($url)->assertStatus(404);
    }
});

test('penyimpanan palet tema portal sekolah tetap berjalan', function () {
    $user = Pengguna::first();

    $warnaTema = PengaturanUmum::ambil('warna_tema') ?: '#1E3A8A';
    $skemaTema = PengaturanUmum::ambil('skema_tema') ?: 'navy_classic';

    $response = $this->actingAs($user, 'tenant_admin')->put('/smk-negeri-2-bandung/admin/pengaturan', [
        'skema_tema' => $skemaTema,
        'warna_tema' => $warnaTema,
    ]);

    $response->assertRedirect('/smk-negeri-2-bandung/admin/pengaturan');
    expect(PengaturanUmum::ambil('warna_tema'))->toBe($warnaTema);
});

test('data konten sekolah tetap utuh di database tenant setelah modul admin dihapus', function () {
    expect(Pengguna::count())->toBeGreaterThan(0);
    expect(Jurusan::count())->toBeGreaterThan(0);
    expect(Post::count())->toBeGreaterThan(0);
    expect(SliderBeranda::count())->toBeGreaterThan(0);
});
