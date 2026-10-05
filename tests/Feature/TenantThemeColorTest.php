<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Pengguna;
use Illuminate\Support\Str;

if (! function_exists('kunciTemaWarna')) {
    /** 13 kunci warna tema yang diatur dari panel admin. */
    function kunciTemaWarna(): array
    {
        return [
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
    }
}

/** Palet uji coba: warna identitas memakai #BE123C. */
$paletUji = [
    'skema_tema' => 'custom',
    'warna_tema' => '#BE123C',
    'warna_aksen' => '#F43F5E',
    'warna_judul' => '#4C0519',
    'warna_teks' => '#3F0B1A',
    'warna_teks_sekunder' => '#7C5160',
    'warna_latar_halaman' => '#FDF6F7',
    'warna_latar_section' => '#FBEAEE',
    'warna_kartu' => '#FFFFFF',
    'warna_border' => '#F2D7DD',
    'warna_tombol' => '#BE123C',
    'warna_tombol_teks' => '#FFFFFF',
    'warna_header' => '#881337',
    'warna_footer' => '#6B0E2B',
];

beforeEach(function () use ($paletUji) {
    $sekolah = Sekolah::where('slug', 'smk-negeri-2-bandung')->first();
    if ($sekolah) {
        $sekolah->update(['status_aktif' => true]);
    } else {
        Sekolah::create([
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'slug' => 'smk-negeri-2-bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]);
    }

    // Simpan nilai awal agar dikembalikan setelah pengujian
    $this->nilaiAwalTema = PengaturanUmum::whereIn('kunci', array_keys($paletUji))
        ->pluck('nilai', 'kunci')
        ->toArray();

    foreach ($paletUji as $kunci => $nilai) {
        PengaturanUmum::simpan($kunci, $nilai);
    }
});

afterEach(function () {
    foreach ($this->nilaiAwalTema as $kunci => $nilai) {
        PengaturanUmum::simpan($kunci, $nilai);
    }
});

test('palet uji #BE123C tersuntik ke variabel CSS seluruh halaman publik', function () {
    foreach (['/smk-negeri-2-bandung', '/smk-negeri-2-bandung/berita', '/smk-negeri-2-bandung/kontak'] as $url) {
        $response = $this->get($url);
        $response->assertStatus(200);

        $html = preg_replace('/\s+/', '', $response->getContent());

        expect($html)
            ->toContain('--theme-color:#BE123C;')
            ->toContain('--theme-accent:#F43F5E;')
            ->toContain('--theme-heading:#4C0519;')
            ->toContain('--theme-text:#3F0B1A;')
            ->toContain('--theme-text-muted:#7C5160;')
            ->toContain('--theme-page-bg:#FDF6F7;')
            ->toContain('--theme-section-bg:#FBEAEE;')
            ->toContain('--theme-card-bg:#FFFFFF;')
            ->toContain('--theme-border:#F2D7DD;')
            ->toContain('--theme-btn-bg:#BE123C;')
            ->toContain('--theme-btn-text:#FFFFFF;')
            ->toContain('--theme-header-bg:#881337;')
            ->toContain('--theme-footer-bg:#6B0E2B;');
    }
});

test('kelas tema global dipakai pada kerangka halaman publik', function () {
    $response = $this->get('/smk-negeri-2-bandung');
    $response->assertStatus(200);

    $response->assertSee('theme-page-bg', false);
    $response->assertSee('theme-header', false);
    $response->assertSee('theme-footer', false);

    // Stylesheet publik (app.css + public.css) tetap ter-load pada halaman
    expect(preg_replace('/\s+/', '', $response->getContent()))->toContain('rel="stylesheet"');
});

test('stylesheet publik memuat kelas global warna dan pemetaan warna netral', function () {
    $css = file_get_contents(resource_path('css/public.css'));

    expect($css)
        ->toContain('--theme-color')
        ->toContain('--theme-heading')
        ->toContain('--theme-text-muted')
        ->toContain('--theme-page-bg')
        ->toContain('--theme-section-bg')
        ->toContain('--theme-card-bg')
        ->toContain('--theme-border')
        ->toContain('--theme-footer-bg')
        ->toContain('.theme-page-bg')
        ->toContain('.theme-section-bg')
        ->toContain('.theme-card')
        ->toContain('.theme-heading')
        ->toContain('.theme-text-body')
        ->toContain('.theme-text-muted')
        ->toContain('.theme-border')
        ->toContain('.theme-badge')
        ->toContain('.theme-icon-box')
        ->toContain('.theme-btn-ghost')
        ->toContain('.theme-header')
        ->toContain('.theme-footer')
        ->toContain('.theme-table-head')
        ->toContain('.theme-input');
});

test('panel tema di central super admin menampilkan formulir 13 warna dan preset', function () {
    $superadmin = \App\Models\Central\SuperAdmin::firstOrCreate(
        ['email' => 'superadmin@admin.com'],
        ['nama' => 'Super Administrator', 'password' => \Illuminate\Support\Facades\Hash::make('password123')]
    );
    $tenant = Sekolah::where('slug', 'smk-negeri-2-bandung')->first();

    $response = $this->actingAs($superadmin, 'superadmin')
        ->get("/superadmin/tenants/{$tenant->id}/edit");

    $response->assertStatus(200);
    $response->assertSee('4. Konfigurasi Tema', false);
    $response->assertSee('Pilih Skema / Preset Cepat', false);
    $response->assertSee('Rincian 13 Palet Warna Presisi', false);

    foreach (kunciTemaWarna() as $kunci) {
        $response->assertSee('name="'.$kunci.'"', false);
    }
});

test('admin tenant dialihkan saat mencoba mengakses atau memperbarui tema secara langsung', function () use ($paletUji) {
    $adminTenant = Pengguna::first();

    $responseIndex = $this->actingAs($adminTenant, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/pengaturan');
    $responseIndex->assertRedirect('/smk-negeri-2-bandung/admin/profil');

    $responseUpdate = $this->actingAs($adminTenant, 'tenant_admin')
        ->put('/smk-negeri-2-bandung/admin/pengaturan', $paletUji);
    $responseUpdate->assertRedirect('/smk-negeri-2-bandung/admin/profil');
});

test('super admin berhasil menyimpan 13 warna tema ke database tenant', function () use ($paletUji) {
    $superadmin = \App\Models\Central\SuperAdmin::firstOrCreate(
        ['email' => 'superadmin@admin.com'],
        ['nama' => 'Super Administrator', 'password' => \Illuminate\Support\Facades\Hash::make('password123')]
    );
    $tenant = Sekolah::where('slug', 'smk-negeri-2-bandung')->first();

    $payload = array_merge([
        'nama_sekolah' => $tenant->nama_sekolah,
        'jenjang' => $tenant->jenjang,
        'domain' => 'smkn2bdg.sch.id',
        'status_aktif' => true,
    ], $paletUji);

    $response = $this->actingAs($superadmin, 'superadmin')
        ->put("/superadmin/tenants/{$tenant->id}", $payload);

    $response->assertRedirect("/superadmin/tenants/{$tenant->id}");

    foreach ($paletUji as $kunci => $nilai) {
        expect(PengaturanUmum::ambil($kunci))->toBe($nilai);
    }
});

test('pemetaan palet Tailwind v4 menutup kelas warna yang lolos dari tema', function () {
    $css = file_get_contents(resource_path('css/public.css'));

    expect($css)
        ->toContain('--theme-identity-900')
        ->toContain('--theme-neutral-300')
        ->toContain('--color-blue-300: var(--theme-identity-300)')
        ->toContain('--color-blue-900: var(--theme-identity-900)')
        ->toContain('--color-indigo-950: var(--theme-identity-950)')
        ->toContain('--color-sky-300: var(--theme-accent-300)')
        ->toContain('--color-amber-400: var(--theme-accent-400)')
        ->toContain('--color-orange-500: var(--theme-accent-500)')
        ->toContain('--color-slate-300: var(--theme-neutral-300)')
        ->toContain('--color-slate-900: var(--theme-neutral-900)')
        ->toContain('[class*="radial-gradient(#38bdf8"]')
        ->toContain('--color-purple-600: var(--theme-identity-600)')
        ->toContain('--color-violet-900: var(--theme-identity-900)')
        ->toContain('--color-fuchsia-500: var(--theme-identity-500)')
        ->toContain('--color-pink-600: var(--theme-identity-600)')
        ->toContain('--color-green-500: var(--theme-accent-500)')
        ->toContain('--color-emerald-500: var(--theme-accent-500)')
        ->toContain('--color-lime-400: var(--theme-accent-400)')
        ->toContain('--color-teal-600: var(--theme-accent-600)')
        ->toContain('--color-cyan-300: var(--theme-accent-300)')
        ->toContain('--color-yellow-400: var(--theme-accent-400)')
        ->toContain('--color-red-600: var(--theme-accent-600)')
        ->toContain('--color-rose-500: var(--theme-accent-500)')
        ->toContain('--color-gray-100: var(--theme-neutral-100)')
        ->toContain('--color-zinc-300: var(--theme-neutral-300)')
        ->toContain('--color-stone-200: var(--theme-neutral-200)')
        ->toContain('--color-neutral-400: var(--theme-neutral-400)')
        ->toContain('--color-white: var(--theme-fg-zona)')
        ->toContain('5%, var(--theme-page-bg))');

    // Tanpa literal putih hardcoded lagi - semuanya kunci panel,
    // termasuk dasar campuran color-mix (dasar terang = warna_latar_halaman).
    expect($css)->not->toContain('rgba(255, 255, 255, 0.88)')
        ->and($css)->not->toContain('PENGECUALIAN ZONA GELAP')
        ->and($css)->not->toContain('jangan override')
        ->and($css)->not->toContain(', white');

    // Pratinjau langsung panel admin juga bebas putih literal:
    // teks header/footer mengikuti btnText, badge mengikuti pageBg.
    $panel = file_get_contents(resource_path('views/tenant/admin/pengaturan/index.blade.php'));
    expect($panel)->not->toContain('rgba(255, 255, 255')
        ->and($panel)->not->toContain(', white)');
});

test('auto-kontras mempertahankan warna teks pilihan admin selama masih terbaca', function () {
    $response = $this->get('/smk-negeri-2-bandung');
    $response->assertStatus(200);

    $html = preg_replace('/\s+/', '', $response->getContent());

    // Kartu putih: judul/isi/sekunder marun gelap lolos AA -> tidak diubah.
    expect($html)
        ->toContain('--theme-fg-kartu-heading:#4C0519;')
        ->toContain('--theme-fg-kartu-text:#3F0B1A;')
        ->toContain('--theme-fg-kartu-muted:#7C5160;')
        ->toContain('--theme-fg-header:#FFFFFF;')
        ->toContain('--theme-fg-footer:#FFFFFF;')
        ->toContain('--theme-fg-tombol:#FFFFFF;')
        ->toContain('--theme-fg-badge:#A20F33;')
        ->toContain('--theme-fg-link:#F43F5E;');
});

test('teks pada kartu gelap dan header terang dipaksa otomatis oleh luminans', function () {
    // Kartu hijau zamrud: judul/isi/sekunder marun gelap hanya 1.0-2.0:1.
    PengaturanUmum::simpan('warna_kartu', '#052E1F');
    // Header nyaris putih: teks tombol putih hanya 1.1:1.
    PengaturanUmum::simpan('warna_header', '#F1F5F9');

    $response = $this->get('/smk-negeri-2-bandung');
    $response->assertStatus(200);

    $html = preg_replace('/\s+/', '', $response->getContent());

    expect($html)
        ->toContain('--theme-fg-kartu-heading:#FFFFFF;')
        ->toContain('--theme-fg-kartu-text:#FFFFFF;')
        ->toContain('--theme-fg-kartu-muted:#FFFFFF;')
        ->toContain('--theme-fg-header:#0F172A;')
        // Permukaan lain tidak ikut berubah (isolasi per permukaan).
        ->toContain('--theme-fg-footer:#FFFFFF;');
});

test('scope auto-kontras terpasang pada seluruh permukaan di public.css', function () {
    $css = file_get_contents(resource_path('css/public.css'));

    expect($css)
        ->toContain('@property --kontras-aman')
        ->toContain('@property --kontras-terang')
        ->toContain('calc(var(--theme-fg-kartu-text) contrast(var(--theme-card-bg)) >= 4.5)')
        ->toContain('calc(var(--theme-fg-header) contrast(var(--theme-header-bg)) >= 4.5)')
        ->toContain('calc(var(--theme-fg-footer) contrast(var(--theme-footer-bg)) >= 4.5)')
        ->toContain('--fg-zona-efektif: color-mix(in srgb, var(--theme-fg-footer)')
        ->toContain('.theme-page-bg {')
        ->toContain('.theme-header,');
});
