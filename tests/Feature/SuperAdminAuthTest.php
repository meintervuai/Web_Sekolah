<?php

use App\Models\Central\Sekolah;
use App\Models\Central\SuperAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

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
    $admin = SuperAdmin::create([
        'nama' => 'Test Super Admin',
        'email' => 'superadmin-stat@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->actingAs($admin, 'superadmin')->get(route('superadmin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Selamat datang, Test Super Admin');
    $response->assertSee('Total Sekolah');
});

test('superadmin dapat melihat direktori tenant dan mendaftarkan sekolah baru', function () {
    $admin = SuperAdmin::create([
        'nama' => 'Test Super Admin',
        'email' => 'superadmin-tenant@example.com',
        'password' => Hash::make('secret123'),
    ]);

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
    $admin = SuperAdmin::create([
        'nama' => 'Test Super Admin',
        'email' => 'superadmin-toggle@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $sekolah = Sekolah::create([
        'id' => (string) Str::uuid(),
        'nama_sekolah' => 'SD Negeri Cibubur 03',
        'slug' => 'sd-negeri-cibubur-03',
        'jenjang' => 'SD',
        'status_aktif' => true,
    ]);

    $response = $this->actingAs($admin, 'superadmin')
        ->patch(route('superadmin.tenants.toggle-status', $sekolah));

    $response->assertSessionHas('sukses');
    $this->assertDatabaseHas('sekolah', [
        'id' => $sekolah->id,
        'status_aktif' => false,
    ]);
});

test('superadmin dapat logout dan sesi dibersihkan', function () {
    $admin = SuperAdmin::create([
        'nama' => 'Test Super Admin',
        'email' => 'superadmin-logout@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->actingAs($admin, 'superadmin')->post(route('superadmin.logout'));

    $response->assertRedirect(route('superadmin.login'));
    $this->assertGuest('superadmin');
});
