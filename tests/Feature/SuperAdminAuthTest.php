<?php

use App\Models\Central\Sekolah;
use App\Models\Central\SuperAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// uses(RefreshDatabase::class);

beforeEach(function () {
    SuperAdmin::firstOrCreate(
        ['email' => 'superadmin@admin.com'],
        [
            'nama' => 'Super Administrator',
            'password' => Hash::make('password123'),
        ]
    );
});

test('guest diarahkan ke halaman login saat mengakses root superadmin', function () {
    $response = $this->get('/superadmin');

    $response->assertRedirect(route('superadmin.login'));
});

test('guest diarahkan ke halaman login saat mengakses dashboard superadmin', function () {
    $response = $this->get(route('superadmin.dashboard'));

    $response->assertRedirect(route('superadmin.login'));
});

test('halaman login superadmin dapat diakses oleh guest', function () {
    $response = $this->get(route('superadmin.login'));

    $response->assertStatus(200);
    $response->assertSee('Super Admin Portal');
    $response->assertSee('Masuk ke Dashboard');
});

test('superadmin dapat login dengan kredensial yang valid', function () {
    SuperAdmin::where('email', 'admin-test@example.com')->delete();

    $admin = SuperAdmin::create([
        'nama' => 'Test Admin',
        'email' => 'admin-test@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->post(route('superadmin.login.submit'), [
        'email' => 'admin-test@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('superadmin.dashboard'));
    $this->assertAuthenticatedAs($admin, 'superadmin');
});

test('superadmin gagal login dengan password salah', function () {
    SuperAdmin::where('email', 'admin-wrong@example.com')->delete();

    SuperAdmin::create([
        'nama' => 'Test Admin',
        'email' => 'admin-wrong@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->post(route('superadmin.login.submit'), [
        'email' => 'admin-wrong@example.com',
        'password' => 'passwordsalah',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest('superadmin');
});

test('superadmin yang terautentikasi dapat mengakses dashboard dan melihat statistik', function () {
    $admin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-stat@example.com'],
        [
            'nama' => 'Test Super Admin',
            'password' => Hash::make('secret123'),
        ]
    );

    $response = $this->actingAs($admin, 'superadmin')->get(route('superadmin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Selamat datang, Test Super Admin');
    $response->assertSee('Total Sekolah');
});

test('superadmin dapat melihat direktori tenant dan mendaftarkan sekolah baru', function () {
    $admin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-tenant@example.com'],
        [
            'nama' => 'Test Super Admin',
            'password' => Hash::make('secret123'),
        ]
    );

    // Hapus sekolah test jika ada sebelumnya
    $sekolahLama = Sekolah::where('slug', 'smk-bina-karya-informatika')->first();
    if ($sekolahLama) {
        $sekolahLama->domains()->delete();
        $sekolahLama->delete();
    }

    // Akses index
    $responseIndex = $this->actingAs($admin, 'superadmin')->get(route('superadmin.tenants.index'));
    $responseIndex->assertStatus(200);

    // Daftarkan sekolah baru
    $responseStore = $this->actingAs($admin, 'superadmin')->post(route('superadmin.tenants.store'), [
        'nama_sekolah' => 'SMK Bina Karya Informatika',
        'jenjang' => 'SMK',
        'domain' => 'smkbinakarya.test',
        'status_aktif' => 1,
        'telepon' => '021-98765432',
    ]);

    $responseStore->assertRedirect(route('superadmin.tenants.index'));
    $this->assertDatabaseHas('sekolah', [
        'nama_sekolah' => 'SMK Bina Karya Informatika',
        'jenjang' => 'SMK',
    ]);
    $this->assertDatabaseHas('domain_sekolah', [
        'domain' => 'smkbinakarya.test',
    ]);
});

test('superadmin dapat melakukan toggle status tenant sekolah', function () {
    $admin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-toggle@example.com'],
        [
            'nama' => 'Test Super Admin',
            'password' => Hash::make('secret123'),
        ]
    );

    $sekolah = Sekolah::firstOrCreate(
        ['slug' => 'sd-negeri-cibubur-03'],
        [
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SD Negeri Cibubur 03',
            'jenjang' => 'SD',
            'status_aktif' => true,
        ]
    );

    $response = $this->actingAs($admin, 'superadmin')
        ->patch(route('superadmin.tenants.toggle-status', $sekolah));

    $response->assertSessionHas('sukses');
});

test('superadmin dapat melihat detail tenant dan mengubah visibilitas menu rute', function () {
    $admin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-detail@example.com'],
        [
            'nama' => 'Test Super Admin',
            'password' => Hash::make('secret123'),
        ]
    );

    $sekolah = Sekolah::firstOrCreate(
        ['slug' => 'smk-negeri-2-bandung'],
        [
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]
    );

    // 1. Akses halaman detail tenant
    $responseShow = $this->actingAs($admin, 'superadmin')
        ->get(route('superadmin.tenants.show', $sekolah));

    $responseShow->assertStatus(200);
    $responseShow->assertSee('Kontrol Visibilitas Menu');
    $responseShow->assertSee('SMK Negeri 2 Bandung');

    // 2. Toggle menu visibilitas (nonaktifkan menu sejarah)
    $responseToggle = $this->actingAs($admin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'sejarah',
            'type' => 'sub_section',
            'aktif' => false,
        ]);

    $responseToggle->assertStatus(200);
    $responseToggle->assertJson(['success' => true]);

    // 3. Toggle menu utama (nonaktifkan menu_profil dan cascade sub-sections)
    $responseCascade = $this->actingAs($admin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'menu_profil',
            'type' => 'menu',
            'aktif' => false,
        ]);

    $responseCascade->assertStatus(200);
    $responseCascade->assertJson(['success' => true]);

    // Pulihkan kembali ke status aktif agar test lain tidak terpengaruh
    $this->actingAs($admin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'menu_profil',
            'type' => 'menu',
            'aktif' => true,
        ]);
});

test('superadmin dapat logout dan sesi dibersihkan', function () {
    $admin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-logout@example.com'],
        [
            'nama' => 'Test Super Admin',
            'password' => Hash::make('secret123'),
        ]
    );

    $response = $this->actingAs($admin, 'superadmin')->post(route('superadmin.logout'));

    $response->assertRedirect(route('superadmin.login'));
    $this->assertGuest('superadmin');
});
