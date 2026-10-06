<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\Ekstrakurikuler;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\Post;

/**
 * @property string $tenantSlug
 */
beforeEach(function () {
    // Tenant slug for SMK Negeri 2 Bandung
    $this->tenantSlug = 'smk-negeri-2-bandung';

    Sekolah::firstOrCreate(
        ['slug' => $this->tenantSlug],
        [
            'nama_sekolah' => 'SMK Negeri 2 Bandung',
            'jenjang' => 'SMK',
            'status_aktif' => true,
            'data' => [
                'npsn' => '20219146',
                'akreditasi' => 'A',
                'alamat' => 'Jl. Ciliwung No. 4, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114',
                'telepon' => '(022) 7234285',
                'email' => 'humas@smkn2bandung.sch.id',
            ],
        ]
    );

    \Illuminate\Support\Facades\DB::connection('tenant')->table('pengaturan_fitur')->update(['is_aktif' => true]);
});

test('0. root url menampilkan portal direktori sekolah dan tidak redirect otomatis', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Portal Sekolah');
    $response->assertSee('SMK Negeri 2 Bandung');
});

test('0b. shortcut admin mengarahkan ke tenant admin login', function () {
    $firstActive = Sekolah::where('status_aktif', true)->first();
    $response = $this->get('/admin');
    $response->assertRedirect('/'.($firstActive?->slug ?? $this->tenantSlug).'/admin/login');
});

test('1. beranda sekolah dapat diakses dan menampilkan identitas smkn 2 bandung', function () {
    $response = $this->get('/'.$this->tenantSlug);
    $response->assertStatus(200);
    $response->assertSee('SMK Negeri 2 Bandung');
    $response->assertSee('20219146'); // NPSN
});

test('2. halaman profil sekolah lengkap dapat diakses', function () {
    PengaturanFitur::on('tenant')->where('kode_fitur', 'profil')->update(['is_aktif' => true]);

    Page::updateOrCreate(
        ['slug' => 'profil'],
        [
            'judul' => 'Profil SMK Negeri 2 Bandung',
            'isi_konten' => '<p>Budaya industri dan karakter kerja berstandar global.</p>',
        ]
    );

    $response = $this->get('/'.$this->tenantSlug.'/profil');
    $response->assertStatus(200);
    $response->assertSee('Profil SMK Negeri 2 Bandung');
    $response->assertSee('Budaya industri dan karakter kerja berstandar global.', false);
    $response->assertSee('Sejarah Singkat');
    $response->assertSee('Visi');
    $response->assertSee('Misi');
});

test('2b. halaman struktur organisasi publik dapat diakses dan menampilkan kedua mode tampilan', function () {
    // Regression: view publik struktur pernah gagal kompilasi (500) karena @if tidak tertutup.
    PengaturanFitur::on('tenant')->whereIn('kode_fitur', ['struktur_organisasi', 'struktur_pejabat', 'struktur_diagram'])->update(['is_aktif' => true]);

    $response = $this->get('/'.$this->tenantSlug.'/profil/struktur');
    $response->assertStatus(200);
    $response->assertSee('Pilihan Tampilan Struktur');
    $response->assertSee('Jajaran Pejabat');
    $response->assertSee('Bagan Diagram Struktur');
});

test('3. halaman program keahlian dan detail jurusan dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/program-keahlian');
    $response->assertStatus(200);
    $response->assertSee('Program Keahlian');
    $response->assertSee('Teknik Mesin');

    // Detail jurusan
    $jurusan = Jurusan::on('tenant')->first();
    if ($jurusan) {
        $detail = $this->get('/'.$this->tenantSlug.'/program-keahlian/'.$jurusan->slug);
        $detail->assertStatus(200);
        $detail->assertSee($jurusan->nama_jurusan);
    }
});

test('4. halaman berita dan detail berita dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/berita');
    $response->assertStatus(200);
    $response->assertSee('Kabar Sekolah Terkini');

    // Detail berita
    $post = Post::on('tenant')->published()->where('is_pengumuman', false)->first();
    if ($post) {
        $detail = $this->get('/'.$this->tenantSlug.'/berita/'.$post->slug);
        $detail->assertStatus(200);
        $detail->assertSee($post->judul);
    }
});

test('5. halaman agenda dan detail agenda dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/agenda');
    $response->assertStatus(200);
    $response->assertSee('Kalender');
    $response->assertSee('Agenda');

    // Detail agenda
    $agenda = Agenda::on('tenant')->aktif()->first();
    if ($agenda) {
        $detail = $this->get('/'.$this->tenantSlug.'/agenda/'.$agenda->slug);
        $detail->assertStatus(200);
        $detail->assertSee($agenda->judul);
    }
});

test('6. halaman pengumuman dan detail pengumuman dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/pengumuman');
    $response->assertStatus(200);
    $response->assertSee('Pengumuman');

    // Detail pengumuman
    $pengumuman = Post::on('tenant')->published()->where('is_pengumuman', true)->first();
    if ($pengumuman) {
        $detail = $this->get('/'.$this->tenantSlug.'/pengumuman/'.$pengumuman->slug);
        $detail->assertStatus(200);
        $detail->assertSee($pengumuman->judul);
    }
});


test('8. halaman kegiatan dokumentasi sekolah dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/kegiatan');
    $response->assertStatus(200);
    $response->assertSee('Aktivitas');
    $response->assertSee('Kegiatan Sekolah');
});

test('9. halaman ekstrakurikuler dan detail ekskul dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/ekstrakurikuler');
    $response->assertStatus(200);
    $response->assertSee('Ekstrakurikuler Sekolah');

    // Detail ekskul
    $ekskul = Ekstrakurikuler::on('tenant')->first();
    if ($ekskul) {
        $detail = $this->get('/'.$this->tenantSlug.'/ekstrakurikuler/'.$ekskul->slug);
        $detail->assertStatus(200);
        $detail->assertSee($ekskul->nama_ekskul);
    }
});

test('10. halaman direktori guru dan staf dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/guru-staf');
    $response->assertStatus(200);
    $response->assertSee('Guru');
    $response->assertSee('Tenaga Kependidikan');
});

test('11. halaman sarana dan fasilitas dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/fasilitas');
    $response->assertStatus(200);
    $response->assertSee('Fasilitas');
    $response->assertSee('Infrastruktur');
});

test('12. halaman galeri foto dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/galeri');
    $response->assertStatus(200);
    $response->assertSee('Galeri Foto');
});

test('13. halaman informasi spmb dan ppdb dapat diakses', function () {
    $response = $this->get('/'.$this->tenantSlug.'/spmb');
    $response->assertStatus(200);
    $response->assertSee('Bergabung Bersama SMK Negeri 2 Bandung');

    // Alias ppdb juga harus bekerja
    $alias = $this->get('/'.$this->tenantSlug.'/ppdb');
    $alias->assertStatus(200);
    $alias->assertSee('Bergabung Bersama SMK Negeri 2 Bandung');
});

test('14. halaman kontak dapat diakses dan form pengiriman pesan berhasil disimpan', function () {
    $response = $this->get('/'.$this->tenantSlug.'/kontak');
    $response->assertStatus(200);
    $response->assertSee('Hubungi Kami');
    $response->assertSee('Kirim Pesan atau Pertanyaan');

    // Test submit valid contact message
    $postData = [
        'nama_pengirim' => 'Rian Pratama',
        'email_pengirim' => 'rian.pratama@example.com',
        'no_telepon' => '081234567890',
        'subjek' => 'Pertanyaan Kemitraan Prakerin Vokasi',
        'pesan' => 'Halo tim humas SMKN 2 Bandung, kami dari perusahaan teknologi ingin mengajukan kerja sama prakerin untuk jurusan RPL dan TKJ.',
    ];

    $submit = $this->post('/'.$this->tenantSlug.'/kontak', $postData);
    $submit->assertRedirect();
    $submit->assertSessionHas('sukses');

    // Pastikan tersimpan di database tenant tabel pesan_masuk
    $this->assertDatabaseHas('pesan_masuk', [
        'email_pengirim' => 'rian.pratama@example.com',
        'subjek' => 'Pertanyaan Kemitraan Prakerin Vokasi',
    ], 'tenant');
});

test('15. feature flag menonaktifkan rute publik dengan respons 404 ketika dimatikan', function () {
    // Matikan fitur agenda sementara
    PengaturanFitur::on('tenant')->where('kode_fitur', 'agenda')->update(['is_aktif' => false]);

    $response = $this->get('/'.$this->tenantSlug.'/agenda');
    $response->assertStatus(404);

    // Kembalikan lagi ke aktif
    PengaturanFitur::on('tenant')->where('kode_fitur', 'agenda')->update(['is_aktif' => true]);

    $responseActive = $this->get('/'.$this->tenantSlug.'/agenda');
    $responseActive->assertStatus(200);
});
