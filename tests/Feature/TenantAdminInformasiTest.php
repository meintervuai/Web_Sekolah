<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\Fasilitas;
use App\Models\Tenant\GaleriAlbum;
use App\Models\Tenant\GaleriItem;
use App\Models\Tenant\KategoriArtikel;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Pengguna;
use App\Models\Tenant\Post;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->sekolah = Sekolah::firstOrCreate(
        ['slug' => 'smk-negeri-2-bandung'],
        [
            'id' => (string) Str::uuid(),
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
        ]
    );

    $this->tenantSlug = 'smk-negeri-2-bandung';
    $this->admin = Pengguna::first();

    PengaturanFitur::on('tenant')->whereIn('kode_fitur', ['berita', 'agenda', 'fasilitas', 'galeri', 'pengumuman'])->update(['is_aktif' => true]);
});

afterEach(function () {
    // Pastikan feature flags tetap aktif setelah pengujian agar tidak mengganggu test suite lain
    PengaturanFitur::updateOrCreate(
        ['kode_fitur' => 'berita'],
        ['nama_fitur' => 'Berita & Artikel', 'is_aktif' => true, 'pengguna_id' => $this->admin->id ?? 1]
    );
    PengaturanFitur::updateOrCreate(
        ['kode_fitur' => 'agenda'],
        ['nama_fitur' => 'Agenda & Event', 'is_aktif' => true, 'pengguna_id' => $this->admin->id ?? 1]
    );
    PengaturanFitur::updateOrCreate(
        ['kode_fitur' => 'fasilitas'],
        ['nama_fitur' => 'Fasilitas & Sarpras', 'is_aktif' => true, 'pengguna_id' => $this->admin->id ?? 1]
    );
    PengaturanFitur::updateOrCreate(
        ['kode_fitur' => 'galeri'],
        ['nama_fitur' => 'Galeri Foto & Video', 'is_aktif' => true, 'pengguna_id' => $this->admin->id ?? 1]
    );
    PengaturanFitur::updateOrCreate(
        ['kode_fitur' => 'pengumuman'],
        ['nama_fitur' => 'Pengumuman Resmi', 'is_aktif' => true, 'pengguna_id' => $this->admin->id ?? 1]
    );
});

test('admin dapat mengakses halaman manajemen berita, agenda, pengumuman, galeri, fasilitas', function () {
    $routes = [
        route('tenant.admin.informasi.berita', ['tenant' => $this->tenantSlug]),
        route('tenant.admin.informasi.pengumuman', ['tenant' => $this->tenantSlug]),
        route('tenant.admin.informasi.agenda', ['tenant' => $this->tenantSlug]),
        route('tenant.admin.informasi.galeri', ['tenant' => $this->tenantSlug]),
        route('tenant.admin.informasi.fasilitas', ['tenant' => $this->tenantSlug]),
    ];

    foreach ($routes as $url) {
        $response = $this->actingAs($this->admin, 'tenant_admin')->get($url);
        $response->assertStatus(200);
    }
});

test('admin dapat menambah, memperbarui, dan menghapus berita sekolah', function () {
    $kategori = KategoriArtikel::firstOrCreate(
        ['slug' => 'kegiatan-sekolah'],
        ['nama_kategori' => 'Kegiatan Sekolah']
    );

    // Create Berita
    $postData = [
        'judul' => 'Uji Kompetensi Keahlian Bersama Asosiasi Industri',
        'kategori_id' => $kategori->id,
        'ringkasan' => 'Pelaksanaan UKK berlangsung tertib dan sesuai standar industri.',
        'isi_konten' => '<p>Uji kompetensi diselenggarakan dengan mengundang asesor eksternal.</p>',
        'gambar_sampul' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=800',
        'status_publikasi' => 'published',
        'tgl_publikasi' => now()->toDateString(),
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.berita.store', ['tenant' => $this->tenantSlug]), $postData);
    $response->assertRedirect();
    $response->assertSessionHas('success');

    $berita = Post::where('judul', 'Uji Kompetensi Keahlian Bersama Asosiasi Industri')->first();
    expect($berita)->not->toBeNull();
    expect($berita->is_pengumuman)->toBeFalse();

    // Update Berita
    $updateData = array_merge($postData, [
        'judul' => 'Uji Kompetensi Keahlian Bersama Asosiasi Industri 2026',
    ]);

    $updateResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->put(route('tenant.admin.informasi.berita.update', ['tenant' => $this->tenantSlug, 'berita' => $berita->id]), $updateData);
    $updateResponse->assertRedirect();

    $berita->refresh();
    expect($berita->judul)->toBe('Uji Kompetensi Keahlian Bersama Asosiasi Industri 2026');

    // Delete Berita
    $deleteResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.berita.destroy', ['tenant' => $this->tenantSlug, 'berita' => $berita->id]));
    $deleteResponse->assertRedirect();
    expect(Post::find($berita->id))->toBeNull();
});

test('admin dapat menambah, memperbarui, dan menghapus pengumuman resmi', function () {
    $postData = [
        'judul' => 'Surat Edaran Libur Hari Besar Nasional',
        'ringkasan' => 'Diberitahukan kepada seluruh siswa dan wali murid mengenai jadwal libur.',
        'isi_konten' => '<p>Kegiatan KBM diliburkan pada tanggal terkait.</p>',
        'status_publikasi' => 'published',
        'tgl_publikasi' => now()->toDateString(),
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.pengumuman.store', ['tenant' => $this->tenantSlug]), $postData);
    $response->assertRedirect();
    $response->assertSessionHas('success');

    $pengumuman = Post::where('judul', 'Surat Edaran Libur Hari Besar Nasional')->first();
    expect($pengumuman)->not->toBeNull();
    expect($pengumuman->is_pengumuman)->toBeTrue();

    // Delete Pengumuman
    $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.pengumuman.destroy', ['tenant' => $this->tenantSlug, 'pengumuman' => $pengumuman->id]));
    expect(Post::find($pengumuman->id))->toBeNull();
});

test('admin dapat mengelola agenda kegiatan sekolah', function () {
    $agendaData = [
        'judul' => 'Pameran Teaching Factory dan Job Fair',
        'tgl_mulai' => now()->addDays(5)->toDateString(),
        'tgl_selesai' => now()->addDays(6)->toDateString(),
        'jam_mulai' => '08:00',
        'jam_selesai' => '16:00',
        'lokasi' => 'Aula Utama',
        'penyelenggara' => 'Humas & BKK',
        'ringkasan' => 'Menghadirkan puluhan industri mitra ternama.',
        'deskripsi_lengkap' => '<p>Terbuka untuk umum dan alumni.</p>',
        'is_aktif' => 1,
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.agenda.store', ['tenant' => $this->tenantSlug]), $agendaData);
    $response->assertRedirect();

    $agenda = Agenda::where('judul', 'Pameran Teaching Factory dan Job Fair')->first();
    expect($agenda)->not->toBeNull();

    // Update
    $updateData = array_merge($agendaData, ['judul' => 'Pameran TEFA & Career Expo 2026']);
    $this->actingAs($this->admin, 'tenant_admin')
        ->put(route('tenant.admin.informasi.agenda.update', ['tenant' => $this->tenantSlug, 'agenda' => $agenda->id]), $updateData);

    $agenda->refresh();
    expect($agenda->judul)->toBe('Pameran TEFA & Career Expo 2026');

    // Delete
    $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.agenda.destroy', ['tenant' => $this->tenantSlug, 'agenda' => $agenda->id]));
    expect(Agenda::find($agenda->id))->toBeNull();
});

test('admin dapat mengelola album galeri dan foto di dalamnya', function () {
    $albumData = [
        'nama_album' => 'Dokumentasi Gelar Inovasi Siswa',
        'tipe' => 'foto',
        'deskripsi' => 'Kumpulan dokumentasi prototipe teknologi siswa.',
        'cover_album' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=800',
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.galeri.album.store', ['tenant' => $this->tenantSlug]), $albumData);
    $response->assertRedirect();

    $album = GaleriAlbum::where('nama_album', 'Dokumentasi Gelar Inovasi Siswa')->first();
    expect($album)->not->toBeNull();

    // Tambah Item Foto ke Album
    $itemData = [
        'file_media_atau_link' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800',
        'judul_item' => 'Prototipe IoT Smart Farming Siswa',
    ];
    $itemResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.galeri.item.store', ['tenant' => $this->tenantSlug, 'album' => $album->id]), $itemData);
    $itemResponse->assertRedirect();

    $item = GaleriItem::where('album_id', $album->id)->first();
    expect($item)->not->toBeNull();

    // Hapus Item
    $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.galeri.item.destroy', ['tenant' => $this->tenantSlug, 'item' => $item->id]));
    expect(GaleriItem::find($item->id))->toBeNull();

    // Hapus Album
    $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.galeri.album.destroy', ['tenant' => $this->tenantSlug, 'album' => $album->id]));
    expect(GaleriAlbum::find($album->id))->toBeNull();
});

test('admin dapat mengelola fasilitas dan statistik sarpras', function () {
    $fasilitasData = [
        'nama_fasilitas' => 'Laboratorium Komputer & Jaringan Fiber Optic',
        'deskripsi' => 'Dilengkapi perangkat router cisco dan simulator splicing FO standar industri.',
        'foto_utama' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800',
        'is_aktif' => 1,
    ];

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.fasilitas.store', ['tenant' => $this->tenantSlug]), $fasilitasData);
    $response->assertRedirect();

    $fasilitas = Fasilitas::where('nama_fasilitas', 'Laboratorium Komputer & Jaringan Fiber Optic')->first();
    expect($fasilitas)->not->toBeNull();

    // Update Stats Sarpras
    $statsData = [
        'stats_ruang_kelas' => '42 Ruang',
        'stats_bengkel_lab' => '9 Lab',
        'stats_perpustakaan' => '1 Gedung',
        'stats_akses_internet' => '100% Fiber',
    ];
    $statsResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.fasilitas.stats.update', ['tenant' => $this->tenantSlug]), $statsData);
    $statsResponse->assertRedirect();

    expect(PengaturanUmum::ambil('stats_ruang_kelas'))->toBe('42 Ruang');

    // Hapus Fasilitas
    $this->actingAs($this->admin, 'tenant_admin')
        ->delete(route('tenant.admin.informasi.fasilitas.destroy', ['tenant' => $this->tenantSlug, 'fasilitas' => $fasilitas->id]));
    expect(Fasilitas::find($fasilitas->id))->toBeNull();
});

test('admin dapat mengupdate hero banner dan toggle status fitur via AJAX', function () {
    // Update Hero Banner
    $heroData = [
        'judul' => 'Agenda Resmi Sekolah Terupdate',
        'subjudul' => 'Ikuti seluruh kegiatan akademik dan ekstrakurikuler.',
        'gambar_banner' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600',
    ];
    $heroResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->post(route('tenant.admin.informasi.hero', ['tenant' => $this->tenantSlug, 'modul' => 'agenda']), $heroData);
    $heroResponse->assertRedirect();

    $page = Page::where('slug', 'agenda')->first();
    expect($page->judul)->toBe('Agenda Resmi Sekolah Terupdate');

    // Toggle Status Agenda Item (Published/Draft/Aktif)
    $agenda = \App\Models\Tenant\Agenda::create([
        'pengguna_id' => $this->admin->id,
        'judul' => 'Agenda Test Status ' . Str::random(5),
        'slug' => 'agenda-test-status-' . Str::random(8),
        'tgl_mulai' => now()->toDateString(),
        'is_aktif' => true,
    ]);

    $toggleItemResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson(route('tenant.admin.informasi.toggle-status', ['tenant' => $this->tenantSlug]), [
            'target_type' => 'agenda',
            'model_type' => 'agenda',
            'id' => $agenda->id,
        ]);
    $toggleItemResponse->assertStatus(200);
    $toggleItemResponse->assertJson(['success' => true, 'is_aktif' => false]);

    // Percobaan mengubah master feature flag modul oleh Admin Sekolah harus ditolak (403)
    $toggleFeatureResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson(route('tenant.admin.informasi.toggle-status', ['tenant' => $this->tenantSlug]), [
            'fitur' => 'agenda',
        ]);
    $toggleFeatureResponse->assertStatus(403);
});
