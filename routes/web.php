<?php

use App\Http\Controllers\Central\AuthController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Tenant\Admin\AgendaController;
use App\Http\Controllers\Tenant\Admin\BeritaController;
use App\Http\Controllers\Tenant\Admin\EkstrakurikulerController;
use App\Http\Controllers\Tenant\Admin\FasilitasController;
use App\Http\Controllers\Tenant\Admin\GaleriController;
use App\Http\Controllers\Tenant\Admin\GuruStafController;
use App\Http\Controllers\Tenant\Admin\JurusanController;
use App\Http\Controllers\Tenant\Admin\KontakController;
use App\Http\Controllers\Tenant\Admin\MediaController;
use App\Http\Controllers\Tenant\Admin\PengaturanController;
use App\Http\Controllers\Tenant\Admin\PengumumanController;
use App\Http\Controllers\Tenant\Admin\PrestasiController;
use App\Http\Controllers\Tenant\Admin\ProfilController;
use App\Http\Controllers\Tenant\Admin\SliderController;
use App\Http\Controllers\Tenant\Admin\SpmbController;
use App\Http\Controllers\Tenant\Admin\StrukturController;
use App\Http\Controllers\Tenant\Public\HomeController;
use App\Http\Controllers\Tenant\Public\PageController;
use App\Http\Middleware\TenantMiddleware;
use App\Models\Central\Sekolah;
use Illuminate\Support\Facades\Route;

// Grup Rute Super Admin (Central)
Route::prefix('superadmin')->name('superadmin.')->group(function () {

    // Redirect root /superadmin ke login atau dashboard
    Route::get('/', function () {
        return auth('superadmin')->check()
            ? redirect()->route('superadmin.dashboard')
            : redirect()->route('superadmin.login');
    })->name('index');

    // Rute Publik Super Admin (Guest)
    Route::middleware('guest:superadmin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Rute Terproteksi Super Admin (Auth)
    Route::middleware('auth:superadmin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Tenant / Sekolah
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/', [TenantController::class, 'index'])->name('index');
            Route::get('/create', [TenantController::class, 'create'])->name('create');
            Route::post('/', [TenantController::class, 'store'])->name('store');
            Route::get('/{tenant}', [TenantController::class, 'show'])->name('show');
            Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('edit');
            Route::put('/{tenant}', [TenantController::class, 'update'])->name('update');
            Route::patch('/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{tenant}', [TenantController::class, 'destroy'])->name('destroy');
        });
    });
});

// Rute Portal Utama Direktori Multi-Sekolah
Route::get('/', function () {
    $sekolahs = Sekolah::where('status_aktif', true)->with('domains')->get();

    return view('welcome', compact('sekolahs'));
})->name('landing');

// Shortcut Rute Global Admin Sekolah (/admin dan /admin/login)
Route::get('/admin', function () {
    if (app()->bound('tenant') && auth('tenant_admin')->check()) {
        return redirect('/'.app('tenant')->slug.'/admin/dashboard');
    }

    $sekolah = Sekolah::where('status_aktif', true)->first();
    if ($sekolah) {
        return redirect('/'.$sekolah->slug.'/admin/login');
    }

    return redirect()->route('superadmin.login');
})->name('admin.shortcut');

Route::get('/admin/login', function () {
    $sekolah = Sekolah::where('status_aktif', true)->first();
    if ($sekolah) {
        return redirect('/'.$sekolah->slug.'/admin/login');
    }

    return redirect()->route('superadmin.login');
})->name('admin.login.shortcut');

// Rute Publik Tenant
Route::prefix('{tenant}')
    ->middleware(TenantMiddleware::class)
    ->group(function () {
        // 1. Beranda
        Route::get('/', [HomeController::class, 'index'])->name('tenant.home');
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // 2. Profil Sekolah
        Route::get('/profil', [PageController::class, 'profil'])->name('tenant.profil');
        Route::get('/profil/sejarah', [PageController::class, 'sejarah'])->name('tenant.profil.sejarah');
        Route::get('/profil/visi-misi', [PageController::class, 'visiMisi'])->name('tenant.profil.visi-misi');
        Route::get('/profil/struktur', [PageController::class, 'struktur'])->name('tenant.profil.struktur');

        // 3. Program Keahlian / Jurusan
        Route::get('/program-keahlian', [PageController::class, 'programKeahlian'])->name('tenant.program-keahlian');
        Route::get('/program-keahlian/{slug}', [PageController::class, 'detailProgramKeahlian'])->name('tenant.program-keahlian.detail');

        // 4. Berita
        Route::get('/berita', [PageController::class, 'berita'])->name('tenant.berita');
        Route::get('/berita/{slug}', [PageController::class, 'detailBerita'])->name('tenant.berita.detail');

        // 5. Agenda
        Route::get('/agenda', [PageController::class, 'agenda'])->name('tenant.agenda');
        Route::get('/agenda/{slug}', [PageController::class, 'detailAgenda'])->name('tenant.agenda.detail');

        // 6. Pengumuman
        Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('tenant.pengumuman');
        Route::get('/pengumuman/{slug}', [PageController::class, 'detailPengumuman'])->name('tenant.pengumuman.detail');

        // 7. Prestasi
        Route::get('/prestasi', [PageController::class, 'prestasi'])->name('tenant.prestasi');
        Route::get('/prestasi/{slug}', [PageController::class, 'detailPrestasi'])->name('tenant.prestasi.detail');

        // 8. Kegiatan
        Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('tenant.kegiatan');

        // 9. Ekstrakurikuler
        Route::get('/ekstrakurikuler', [PageController::class, 'ekstrakurikuler'])->name('tenant.ekstrakurikuler');
        Route::get('/ekstrakurikuler/{slug}', [PageController::class, 'detailEkstrakurikuler'])->name('tenant.ekstrakurikuler.detail');

        // 10. Guru & Staf
        Route::get('/guru-staf', [PageController::class, 'guruStaf'])->name('tenant.guru-staf');

        // 11. Fasilitas
        Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('tenant.fasilitas');

        // 12. Galeri
        Route::get('/galeri', [PageController::class, 'galeri'])->name('tenant.galeri');

        // 13. SPMB / PPDB
        Route::get('/spmb', [PageController::class, 'spmb'])->name('tenant.spmb');
        Route::get('/ppdb', [PageController::class, 'spmb'])->name('ppdb');

        // 14. Kontak
        Route::get('/kontak', [PageController::class, 'kontak'])->name('tenant.kontak');
        Route::post('/kontak', [PageController::class, 'kirimKontak'])->name('tenant.kontak.kirim');

        // Backward Compatibility Sub-prefix Aliases
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
            Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi');
            Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur');
            Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('fasilitas');
            Route::get('/guru', [PageController::class, 'guruStaf'])->name('guru');
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/jurusan', [PageController::class, 'programKeahlian'])->name('jurusan');
            Route::get('/jurusan/{slug}', [PageController::class, 'detailProgramKeahlian'])->name('jurusan.detail');
            Route::get('/kurikulum', [PageController::class, 'kurikulum'])->name('kurikulum');
            Route::get('/kalender', [PageController::class, 'agenda'])->name('kalender');
        });

        Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
            Route::get('/ekstrakurikuler', [PageController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
            Route::get('/prestasi', [PageController::class, 'prestasi'])->name('prestasi');
            Route::get('/osis', [PageController::class, 'osis'])->name('osis');
        });

        Route::prefix('informasi')->name('informasi.')->group(function () {
            Route::get('/berita', [PageController::class, 'berita'])->name('berita');
            Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');
            Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
        });

        // 15. Panel Admin Sekolah (CMS)
        Route::prefix('admin')->name('tenant.admin.')->group(function () {
            // Guest Admin Sekolah (Login)
            Route::middleware('guest:tenant_admin')->group(function () {
                Route::get('/login', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'showLogin'])->name('login');
                Route::post('/login', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'login'])->name('login.submit');
            });

            // Terproteksi Admin Sekolah (Auth)
            Route::middleware('auth:tenant_admin')->group(function () {
                Route::post('/logout', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'logout'])->name('logout');
                Route::get('/dashboard', [App\Http\Controllers\Tenant\Admin\DashboardController::class, 'index'])->name('dashboard');

                // 1. Navigasi Beranda: Slider Banner & Pengaturan Beranda
                Route::resource('slider', SliderController::class)->except(['show']);
                Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
                Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

                // 2. Navigasi Profil: Visi Misi, Sejarah, & Sambutan Kepsek
                Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
                Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

                // Navigasi Struktur Organisasi: Bagan Diagram & Pejabat Struktural
                Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur.index');
                Route::post('/struktur/anggota', [StrukturController::class, 'storeAnggota'])->name('struktur.anggota.store');
                Route::put('/struktur/anggota/{id}', [StrukturController::class, 'updateAnggota'])->name('struktur.anggota.update');
                Route::delete('/struktur/anggota/{id}', [StrukturController::class, 'destroyAnggota'])->name('struktur.anggota.destroy');
                Route::post('/struktur/diagram', [StrukturController::class, 'storeDiagram'])->name('struktur.diagram.store');
                Route::delete('/struktur/diagram/{index}', [StrukturController::class, 'destroyDiagram'])->name('struktur.diagram.destroy');

                // Alias kompatibilitas rute profil struktur
                Route::post('/profil/struktur', [StrukturController::class, 'storeAnggota'])->name('profil.struktur.store');
                Route::delete('/profil/struktur/{id}', [StrukturController::class, 'destroyAnggota'])->name('profil.struktur.destroy');

                // 3. Navigasi Program Keahlian: Jurusan & Kompetensi Keahlian
                Route::resource('jurusan', JurusanController::class)->parameters(['jurusan' => 'jurusan'])->except(['show']);

                // 4. Navigasi Informasi: Berita, Pengumuman, Agenda, & Galeri
                Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita'])->except(['show']);
                Route::resource('pengumuman', PengumumanController::class)->parameters(['pengumuman' => 'pengumuman'])->except(['show']);
                Route::resource('agenda', AgendaController::class)->parameters(['agenda' => 'agenda'])->except(['show']);
                Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
                Route::post('/galeri/album', [GaleriController::class, 'storeAlbum'])->name('galeri.album.store');
                Route::post('/galeri/item', [GaleriController::class, 'storeItem'])->name('galeri.item.store');
                Route::delete('/galeri/album/{id}', [GaleriController::class, 'destroyAlbum'])->name('galeri.album.destroy');
                Route::delete('/galeri/item/{id}', [GaleriController::class, 'destroyItem'])->name('galeri.item.destroy');

                // 5. Navigasi Kesiswaan: Prestasi & Ekstrakurikuler
                Route::resource('prestasi', PrestasiController::class)->parameters(['prestasi' => 'prestasi'])->except(['show']);
                Route::resource('ekskul', EkstrakurikulerController::class)->parameters(['ekskul' => 'ekskul'])->except(['show']);

                // 6. Navigasi Guru & Staf
                Route::resource('guru', GuruStafController::class)->parameters(['guru' => 'guru'])->except(['show']);

                // 7. Navigasi Fasilitas
                Route::resource('fasilitas', FasilitasController::class)->parameters(['fasilitas' => 'fasilitas'])->except(['show']);

                // 8. Navigasi SPMB 2026
                Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');
                Route::put('/spmb', [SpmbController::class, 'update'])->name('spmb.update');

                // 9. Navigasi Kontak: Kontak, Jam Layanan, Medsos, & Inbox Pesan Masuk
                Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
                Route::put('/kontak', [KontakController::class, 'update'])->name('kontak.update');
                Route::patch('/kontak/pesan/{id}/toggle', [KontakController::class, 'toggleDibaca'])->name('kontak.pesan.toggle');
                Route::delete('/kontak/pesan/{id}', [KontakController::class, 'destroyPesan'])->name('kontak.pesan.destroy');

                // 10. Pengelola Media & Berkas (Crop Gambar, Rename, Upload, Galeri File)
                Route::get('/media', [MediaController::class, 'index'])->name('media.index');
                Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
                Route::post('/media/rename', [MediaController::class, 'rename'])->name('media.rename');
                Route::post('/media/crop', [MediaController::class, 'crop'])->name('media.crop');
                Route::delete('/media', [MediaController::class, 'destroy'])->name('media.destroy');
            });
        });
    });
