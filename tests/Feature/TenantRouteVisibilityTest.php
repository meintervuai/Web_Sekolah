<?php

use App\Models\Central\Sekolah;
use App\Models\Central\SuperAdmin;
use App\Models\Tenant\PengaturanFitur;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

beforeEach(function () {
    Sekolah::firstOrCreate(
        ['slug' => 'smk-negeri-2-bandung'],
        [
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]
    );

    // Setup koneksi tenant
    Config::set('database.connections.tenant.database', 'tenant_smk_negeri_2_bandung');
    DB::purge('tenant');
    DB::reconnect('tenant');
});

test('rute publik mengembalikan 404 ketika fiturnya dinonaktifkan oleh superadmin', function () {
    $superadmin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-route-test@example.com'],
        [
            'nama' => 'Super Admin Test',
            'password' => Hash::make('secret123'),
        ]
    );

    $sekolah = Sekolah::where('slug', 'smk-negeri-2-bandung')->first();

    // 1. Nonaktifkan fitur 'sejarah' melalui endpoint Super Admin
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'sejarah',
            'type' => 'sub_section',
            'aktif' => false,
        ])->assertStatus(200);

    // Akses rute publik /smk-negeri-2-bandung/profil/sejarah -> harus 404
    $responseSejarah = $this->get('/smk-negeri-2-bandung/profil/sejarah');
    $responseSejarah->assertStatus(404);

    // 2. Nonaktifkan fitur 'berita'
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'berita',
            'type' => 'menu',
            'aktif' => false,
        ])->assertStatus(200);

    // Akses rute publik /smk-negeri-2-bandung/berita -> harus 404
    $responseBerita = $this->get('/smk-negeri-2-bandung/berita');
    $responseBerita->assertStatus(404);

    // 3. Kembalikan fitur ke aktif
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'sejarah',
            'type' => 'sub_section',
            'aktif' => true,
        ])->assertStatus(200);

    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'berita',
            'type' => 'menu',
            'aktif' => true,
        ])->assertStatus(200);

    // Setelah diaktifkan kembali -> harus 200
    $this->get('/smk-negeri-2-bandung/profil/sejarah')->assertStatus(200);
    $this->get('/smk-negeri-2-bandung/berita')->assertStatus(200);
});

test('rute admin sekolah dialihkan atau ditolak ketika fiturnya dinonaktifkan oleh superadmin', function () {
    $superadmin = SuperAdmin::firstOrCreate(
        ['email' => 'superadmin-route-test@example.com'],
        [
            'nama' => 'Super Admin Test',
            'password' => Hash::make('secret123'),
        ]
    );

    $admin = \App\Models\Tenant\Pengguna::first();
    $sekolah = Sekolah::where('slug', 'smk-negeri-2-bandung')->first();

    // 1. Nonaktifkan fitur 'berita' via Super Admin
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'berita',
            'type' => 'menu',
            'aktif' => false,
        ])->assertStatus(200);

    // Admin Sekolah mencoba akses /smk-negeri-2-bandung/admin/informasi/berita -> harus redirect ke profil dengan error
    $responseAdminBerita = $this->actingAs($admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/informasi/berita');
    $responseAdminBerita->assertRedirect('/smk-negeri-2-bandung/admin/profil');
    $responseAdminBerita->assertSessionHas('error');

    // 2. Nonaktifkan fitur 'agenda' via Super Admin
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'agenda',
            'type' => 'menu',
            'aktif' => false,
        ])->assertStatus(200);

    // Admin Sekolah mencoba akses /smk-negeri-2-bandung/admin/informasi/agenda -> harus redirect ke profil dengan error
    $responseAdminAgenda = $this->actingAs($admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/informasi/agenda');
    $responseAdminAgenda->assertRedirect('/smk-negeri-2-bandung/admin/profil');
    $responseAdminAgenda->assertSessionHas('error');

    // 3. Nonaktifkan fitur 'program_keahlian' via Super Admin
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'program_keahlian',
            'type' => 'menu',
            'aktif' => false,
        ])->assertStatus(200);

    // Admin Sekolah mencoba akses /smk-negeri-2-bandung/admin/program-keahlian -> harus redirect ke profil dengan error
    $responseAdminJurusan = $this->actingAs($admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/program-keahlian');
    $responseAdminJurusan->assertRedirect('/smk-negeri-2-bandung/admin/profil');
    $responseAdminJurusan->assertSessionHas('error');

    // 4. Kembalikan semua ke aktif
    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'berita',
            'type' => 'menu',
            'aktif' => true,
        ])->assertStatus(200);

    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'agenda',
            'type' => 'menu',
            'aktif' => true,
        ])->assertStatus(200);

    $this->actingAs($superadmin, 'superadmin')
        ->patchJson(route('superadmin.tenants.toggle-menu', $sekolah), [
            'key' => 'program_keahlian',
            'type' => 'menu',
            'aktif' => true,
        ])->assertStatus(200);
});
