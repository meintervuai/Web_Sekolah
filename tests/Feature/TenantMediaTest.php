<?php

use App\Models\Central\Sekolah;
use App\Models\Tenant\Media;
use App\Models\Tenant\Pengguna;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    $this->admin = Pengguna::first();
    Storage::fake('public');
});

test('1. guest tidak dapat mengakses halaman manajemen media', function () {
    $response = $this->get('/smk-negeri-2-bandung/admin/media');

    $response->assertRedirect('/smk-negeri-2-bandung/admin/login');
});

test('2. admin sekolah dapat mengakses halaman manajemen media dan melihat daftar media', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->get('/smk-negeri-2-bandung/admin/media');

    $response->assertStatus(200);
    $response->assertSee('Pusat Manajemen Media');
    $response->assertSee('Cari');
    $response->assertSee('Unggah Berkas');
    $response->assertSee('Impor URL / YouTube');
});

test('3. admin sekolah dapat mengunggah gambar dan otomatis terkonversi ke webp', function () {
    $fakeImage = UploadedFile::fake()->image('kegiatan_prakerin.jpg', 640, 480);

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/media/upload', [
            'file' => $fakeImage,
            'kategori' => 'berita',
            'judul' => 'Dokumentasi Prakerin Industri',
            'alt_teks' => 'Siswa sedang praktik mesin bubut',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('sukses');

    $media = Media::where('judul', 'Dokumentasi Prakerin Industri')->first();
    expect($media)->not()->toBeNull();
    expect($media->tipe_media)->toBe('gambar');
    expect($media->ekstensi)->toBe('webp');
    expect($media->mime_type)->toBe('image/webp');
    expect($media->pengguna_id)->toBe($this->admin->id);
    expect($media->pengguna->id)->toBe($this->admin->id);
});

test('4. admin sekolah dapat mendaftarkan video YouTube sebagai media', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/media/import-url', [
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'judul' => 'Video Profil SMKN 2 Bandung',
            'kategori' => 'profil',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('sukses');

    $media = Media::where('judul', 'Video Profil SMKN 2 Bandung')->first();
    expect($media)->not()->toBeNull();
    expect($media->tipe_media)->toBe('youtube');
    expect($media->sumber)->toBe('youtube');
    expect($media->getYoutubeEmbedUrlAttribute())->toContain('youtube.com/embed/dQw4w9WgXcQ');
});

test('5. endpoint check-url memvalidasi tautan YouTube', function () {
    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/media/check-url', [
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

    $response->assertStatus(200);
    $response->assertJson([
        'valid' => true,
        'tipe' => 'youtube',
    ]);
});

test('6. admin sekolah dapat memperbarui nama judul dan kategori media', function () {
    $media = Media::first();

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->put("/smk-negeri-2-bandung/admin/media/{$media->id}", [
            'judul' => 'Judul Berkas Baru Terupdate',
            'kategori' => 'fasilitas',
            'alt_teks' => 'Deskripsi SEO Baru',
        ]);

    $response->assertRedirect();
    $media->refresh();

    expect($media->judul)->toBe('Judul Berkas Baru Terupdate');
    expect($media->kategori)->toBe('fasilitas');
    expect($media->alt_teks)->toBe('Deskripsi SEO Baru');
});

test('7. admin sekolah dapat menghapus berkas media', function () {
    $fakeImage = UploadedFile::fake()->image('hapus_saya.png', 200, 200);

    $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/media/upload', [
            'file' => $fakeImage,
            'judul' => 'Berkas Uji Hapus',
        ]);

    $media = Media::where('judul', 'Berkas Uji Hapus')->first();
    expect($media)->not()->toBeNull();

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->delete("/smk-negeri-2-bandung/admin/media/{$media->id}");

    $response->assertRedirect();
    expect(Media::find($media->id))->toBeNull();
});

test('8. relasi 100% database dua arah antara media dan pengguna bekerja', function () {
    $media = Media::first();
    expect($media->pengguna)->toBeInstanceOf(Pengguna::class);

    $admin = Pengguna::first();
    expect($admin->medias)->not()->toBeNull();
    expect($admin->medias->count())->toBeGreaterThan(0);
});

test('9. admin sekolah dapat menghapus berkas media secara massal (bulk delete)', function () {
    $img1 = UploadedFile::fake()->image('bulk_1.png', 100, 100);
    $img2 = UploadedFile::fake()->image('bulk_2.png', 100, 100);

    $this->actingAs($this->admin, 'tenant_admin')->post('/smk-negeri-2-bandung/admin/media/upload', ['file' => $img1, 'judul' => 'Bulk 1']);
    $this->actingAs($this->admin, 'tenant_admin')->post('/smk-negeri-2-bandung/admin/media/upload', ['file' => $img2, 'judul' => 'Bulk 2']);

    $m1 = Media::where('judul', 'Bulk 1')->first();
    $m2 = Media::where('judul', 'Bulk 2')->first();

    $response = $this->actingAs($this->admin, 'tenant_admin')
        ->post('/smk-negeri-2-bandung/admin/media/bulk-delete', [
            'ids' => "{$m1->id},{$m2->id}",
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('sukses');

    expect(Media::find($m1->id))->toBeNull();
    expect(Media::find($m2->id))->toBeNull();
});

test('10. fitur crop gambar bekerja secara non-destruktif dan REST API mengembalikan JSON response yang valid', function () {
    $fakeImage = UploadedFile::fake()->image('foto_utama.jpg', 800, 600);

    // 1. Upload file via REST API JSON
    $uploadResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson('/smk-negeri-2-bandung/admin/media/upload', [
            'file' => $fakeImage,
            'judul' => 'Foto Master Asli',
            'kategori' => 'profil',
        ]);

    $uploadResponse->assertStatus(200);
    $uploadResponse->assertJson(['sukses' => true]);
    $mediaMasterId = $uploadResponse->json('data.id');

    $masterMedia = Media::find($mediaMasterId);
    $masterPath = $masterMedia->path;

    // 2. Crop gambar via REST API
    $cropResponse = $this->actingAs($this->admin, 'tenant_admin')
        ->postJson("/smk-negeri-2-bandung/admin/media/{$masterMedia->id}/edit-image", [
            'crop_x' => 50,
            'crop_y' => 50,
            'crop_w' => 300,
            'crop_h' => 200,
            'rotate' => 0,
        ]);

    $cropResponse->assertStatus(200);
    $cropResponse->assertJson(['sukses' => true]);

    $croppedMediaId = $cropResponse->json('data.id');
    expect($croppedMediaId)->not()->toBe($masterMedia->id);

    // Pastikan berkas master asli tetap utuh di database & storage
    $masterMedia->refresh();
    expect($masterMedia->path)->toBe($masterPath);
    expect(Media::find($masterMedia->id))->not()->toBeNull();

    // Pastikan berkas crop tersimpan sebagai record WebP baru
    $croppedMedia = Media::find($croppedMediaId);
    expect($croppedMedia)->not()->toBeNull();
    expect($croppedMedia->ekstensi)->toBe('webp');
    expect($croppedMedia->dimensi)->toBe('300x200');
});
