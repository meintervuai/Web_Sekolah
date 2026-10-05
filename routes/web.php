<?php

use App\Http\Controllers\Central\AuthController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Tenant\Admin\GtkController;
use App\Http\Controllers\Tenant\Admin\InformasiController;
use App\Http\Controllers\Tenant\Admin\JurusanController;
use App\Http\Controllers\Tenant\Admin\MediaController;
use App\Http\Controllers\Tenant\Admin\PengaturanController;
use App\Http\Controllers\Tenant\Admin\ProfilController;
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
        return redirect('/'.app('tenant')->slug.'/admin/pengaturan');
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

        // 10.5 Fasilitas / Sarana Prasarana
        Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('tenant.fasilitas');

        // 11. Galeri
        Route::get('/galeri', [PageController::class, 'galeri'])->name('tenant.galeri');

        // 12. SPMB / PPDB
        Route::get('/spmb', [PageController::class, 'spmb'])->name('tenant.spmb');
        Route::get('/ppdb', [PageController::class, 'spmb'])->name('ppdb');

        // 13. Kontak
        Route::get('/kontak', [PageController::class, 'kontak'])->name('tenant.kontak');
        Route::post('/kontak', [PageController::class, 'kirimKontak'])->name('tenant.kontak.kirim');

        // Backward Compatibility Sub-prefix Aliases
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
            Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi');
            Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur');
            Route::get('/guru', [PageController::class, 'guruStaf'])->name('guru');
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/jurusan', [PageController::class, 'programKeahlian'])->name('jurusan');
            Route::get('/jurusan/{slug}', [PageController::class, 'detailProgramKeahlian'])->name('jurusan.detail');
            Route::get('/kurikulum', [PageController::class, 'kurikulum'])->name('kurikulum');
            Route::get('/kalender', [PageController::class, 'agenda'])->name('kalender');
        });

        Route::prefix('informasi')->name('informasi.')->group(function () {
            Route::get('/berita', [PageController::class, 'berita'])->name('berita');
            Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');
            Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
        });

        // 15. Panel Admin Sekolah (CMS)
        Route::prefix('admin')->name('tenant.admin.')->group(function () {
            // Guest Admin Sekolah (Login)
            Route::get('/login', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'showLogin'])->name('login');

            Route::middleware('guest:tenant_admin')->group(function () {
                Route::post('/login', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'login'])->name('login.submit');
            });

            // Terproteksi Admin Sekolah (Auth)
            Route::middleware('auth:tenant_admin')->group(function () {
                // Dashboard Redirect / Root Admin URL
                Route::get('/', function () {
                    return redirect()->route('tenant.admin.profil.index', ['tenant' => app('tenant')->slug]);
                })->name('dashboard');

                Route::post('/logout', [App\Http\Controllers\Tenant\Admin\AuthController::class, 'logout'])->name('logout');

                // Pengaturan Tampilan Sekolah (Tema & Warna)
                Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
                Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

                // Pengaturan Profil Sekolah & Konten Halaman CMS
                Route::prefix('profil')->name('profil.')->group(function () {
                    Route::get('/', [ProfilController::class, 'index'])->name('index');
                    Route::put('/identitas', [ProfilController::class, 'updateIdentitas'])->name('identitas.update');
                    Route::put('/halaman/{slug}', [ProfilController::class, 'updateHalaman'])->name('halaman.update');
                    Route::put('/struktur', [ProfilController::class, 'updateStruktur'])->name('struktur.update');
                    Route::post('/pejabat', [ProfilController::class, 'storePejabat'])->name('pejabat.store');
                    Route::put('/pejabat/{pejabat}', [ProfilController::class, 'updatePejabat'])->name('pejabat.update');
                    Route::delete('/pejabat/{pejabat}', [ProfilController::class, 'destroyPejabat'])->name('pejabat.destroy');
                    Route::put('/guru-hero', [ProfilController::class, 'updateGuruHero'])->name('guru.hero.update');
                    Route::post('/guru', [ProfilController::class, 'storeGuru'])->name('guru.store');
                    Route::put('/guru/{guru}', [ProfilController::class, 'updateGuru'])->name('guru.update');
                    Route::delete('/guru/{guru}', [ProfilController::class, 'destroyGuru'])->name('guru.destroy');
                    Route::post('/toggle-menu', [ProfilController::class, 'toggleMenu'])->name('toggle-menu');
                });

                // Pengaturan Struktur Organisasi & Guru Tenaga Kependidikan (GTK) CMS
                Route::prefix('gtk')->name('gtk.')->group(function () {
                    Route::get('/', [GtkController::class, 'index'])->name('index');
                    Route::put('/struktur', [GtkController::class, 'updateStruktur'])->name('struktur.update');
                    Route::post('/pejabat', [GtkController::class, 'storePejabat'])->name('pejabat.store');
                    Route::put('/pejabat/{pejabat}', [GtkController::class, 'updatePejabat'])->name('pejabat.update');
                    Route::delete('/pejabat/{pejabat}', [GtkController::class, 'destroyPejabat'])->name('pejabat.destroy');
                    Route::put('/guru-hero', [GtkController::class, 'updateGuruHero'])->name('guru.hero.update');
                    Route::post('/guru', [GtkController::class, 'storeGuru'])->name('guru.store');
                    Route::put('/guru/{guru}', [GtkController::class, 'updateGuru'])->name('guru.update');
                    Route::delete('/guru/{guru}', [GtkController::class, 'destroyGuru'])->name('guru.destroy');
                });

                // Pengaturan Program Keahlian / Jurusan CMS
                Route::prefix('program-keahlian')->name('jurusan.')->group(function () {
                    Route::get('/', [JurusanController::class, 'index'])->name('index');
                    Route::put('/hero', [JurusanController::class, 'updateHero'])->name('hero.update');
                    Route::post('/', [JurusanController::class, 'store'])->name('store');
                    Route::put('/{jurusan}', [JurusanController::class, 'update'])->name('update');
                    Route::delete('/{jurusan}', [JurusanController::class, 'destroy'])->name('destroy');
                    Route::post('/toggle-status', [JurusanController::class, 'toggleStatus'])->name('toggle-status');
                });

                // Pengaturan Informasi Sekolah CMS (Berita, Pengumuman, Agenda, Galeri, Fasilitas)
                Route::prefix('informasi')->name('informasi.')->group(function () {
                    // 1. Berita
                    Route::get('/berita', [InformasiController::class, 'berita'])->name('berita');
                    Route::post('/berita', [InformasiController::class, 'storeBerita'])->name('berita.store');
                    Route::put('/berita/{berita}', [InformasiController::class, 'updateBerita'])->name('berita.update');
                    Route::delete('/berita/{berita}', [InformasiController::class, 'destroyBerita'])->name('berita.destroy');
                    Route::post('/kategori', [InformasiController::class, 'storeKategori'])->name('kategori.store');
                    Route::put('/kategori/{kategori}', [InformasiController::class, 'updateKategori'])->name('kategori.update');
                    Route::delete('/kategori/{kategori}', [InformasiController::class, 'destroyKategori'])->name('kategori.destroy');

                    // 2. Pengumuman
                    Route::get('/pengumuman', [InformasiController::class, 'pengumuman'])->name('pengumuman');
                    Route::post('/pengumuman', [InformasiController::class, 'storePengumuman'])->name('pengumuman.store');
                    Route::put('/pengumuman/{pengumuman}', [InformasiController::class, 'updatePengumuman'])->name('pengumuman.update');
                    Route::delete('/pengumuman/{pengumuman}', [InformasiController::class, 'destroyPengumuman'])->name('pengumuman.destroy');

                    // 3. Agenda
                    Route::get('/agenda', [InformasiController::class, 'agenda'])->name('agenda');
                    Route::post('/agenda', [InformasiController::class, 'storeAgenda'])->name('agenda.store');
                    Route::put('/agenda/{agenda}', [InformasiController::class, 'updateAgenda'])->name('agenda.update');
                    Route::delete('/agenda/{agenda}', [InformasiController::class, 'destroyAgenda'])->name('agenda.destroy');

                    // 4. Galeri
                    Route::get('/galeri', [InformasiController::class, 'galeri'])->name('galeri');
                    Route::post('/galeri/album', [InformasiController::class, 'storeAlbum'])->name('galeri.album.store');
                    Route::put('/galeri/album/{album}', [InformasiController::class, 'updateAlbum'])->name('galeri.album.update');
                    Route::delete('/galeri/album/{album}', [InformasiController::class, 'destroyAlbum'])->name('galeri.album.destroy');
                    Route::post('/galeri/album/{album}/item', [InformasiController::class, 'storeItem'])->name('galeri.item.store');
                    Route::delete('/galeri/item/{item}', [InformasiController::class, 'destroyItem'])->name('galeri.item.destroy');

                    // 5. Fasilitas
                    Route::get('/fasilitas', [InformasiController::class, 'fasilitas'])->name('fasilitas');
                    Route::post('/fasilitas', [InformasiController::class, 'storeFasilitas'])->name('fasilitas.store');
                    Route::put('/fasilitas/{fasilitas}', [InformasiController::class, 'updateFasilitas'])->name('fasilitas.update');
                    Route::delete('/fasilitas/{fasilitas}', [InformasiController::class, 'destroyFasilitas'])->name('fasilitas.destroy');
                    Route::delete('/fasilitas/foto/{foto}', [InformasiController::class, 'destroyFotoFasilitas'])->name('fasilitas.foto.destroy');
                    Route::match(['post', 'put'], '/fasilitas/stats/update', [InformasiController::class, 'updateStatsFasilitas'])->name('fasilitas.stats.update');

                    // Global Hero & Feature Toggle
                    Route::match(['post', 'put'], '/hero/{modul}', [InformasiController::class, 'updateHero'])->name('hero');
                    Route::match(['post', 'put'], '/hero-update/{modul}', [InformasiController::class, 'updateHero'])->name('hero.update');
                    Route::post('/toggle-status', [InformasiController::class, 'toggleStatus'])->name('toggle-status');
                });

                // Manajemen Media & File Manager Induk
                Route::prefix('media')->name('media.')->group(function () {
                    Route::get('/', [MediaController::class, 'index'])->name('index');
                    Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
                    Route::post('/import-url', [MediaController::class, 'importUrl'])->name('import-url');
                    Route::post('/check-url', [MediaController::class, 'checkUrl'])->name('check-url');
                    Route::post('/bulk-delete', [MediaController::class, 'bulkDestroy'])->name('bulk-destroy');
                    Route::put('/{media}', [MediaController::class, 'update'])->name('update');
                    Route::post('/{media}/edit-image', [MediaController::class, 'editImage'])->name('edit-image');
                    Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
                });
            });
        });
    });
