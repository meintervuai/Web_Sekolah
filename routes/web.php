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
            Route::patch('/{tenant}/toggle-menu', [TenantController::class, 'toggleMenu'])->name('toggle-menu');
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
        Route::get('/profil', [PageController::class, 'profil'])->name('tenant.profil')->middleware('tenant.feature:profil');
        Route::get('/profil/sejarah', [PageController::class, 'sejarah'])->name('tenant.profil.sejarah')->middleware('tenant.feature:sejarah');
        Route::get('/profil/visi-misi', [PageController::class, 'visiMisi'])->name('tenant.profil.visi-misi')->middleware('tenant.feature:visi_misi');
        Route::get('/profil/struktur', [PageController::class, 'struktur'])->name('tenant.profil.struktur')->middleware('tenant.feature:struktur_organisasi');

        // 3. Program Keahlian / Jurusan
        Route::get('/program-keahlian', [PageController::class, 'programKeahlian'])->name('tenant.program-keahlian')->middleware('tenant.feature:program_keahlian');
        Route::get('/program-keahlian/{slug}', [PageController::class, 'detailProgramKeahlian'])->name('tenant.program-keahlian.detail')->middleware('tenant.feature:program_keahlian');

        // 4. Berita
        Route::get('/berita', [PageController::class, 'berita'])->name('tenant.berita')->middleware('tenant.feature:berita');
        Route::get('/berita/{slug}', [PageController::class, 'detailBerita'])->name('tenant.berita.detail')->middleware('tenant.feature:berita');

        // 5. Agenda
        Route::get('/agenda', [PageController::class, 'agenda'])->name('tenant.agenda')->middleware('tenant.feature:agenda');
        Route::get('/agenda/{slug}', [PageController::class, 'detailAgenda'])->name('tenant.agenda.detail')->middleware('tenant.feature:agenda');

        // 6. Pengumuman
        Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('tenant.pengumuman')->middleware('tenant.feature:pengumuman');
        Route::get('/pengumuman/{slug}', [PageController::class, 'detailPengumuman'])->name('tenant.pengumuman.detail')->middleware('tenant.feature:pengumuman');

        // 7. Kegiatan
        Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('tenant.kegiatan')->middleware('tenant.feature:agenda,kegiatan');

        // 9. Ekstrakurikuler
        Route::get('/ekstrakurikuler', [PageController::class, 'ekstrakurikuler'])->name('tenant.ekstrakurikuler')->middleware('tenant.feature:ekstrakurikuler');
        Route::get('/ekstrakurikuler/{slug}', [PageController::class, 'detailEkstrakurikuler'])->name('tenant.ekstrakurikuler.detail')->middleware('tenant.feature:ekstrakurikuler');

        // 10. Guru & Staf
        Route::get('/guru-staf', [PageController::class, 'guruStaf'])->name('tenant.guru-staf')->middleware('tenant.feature:guru_staf,menu_profil');

        // 10.5 Fasilitas / Sarana Prasarana
        Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('tenant.fasilitas')->middleware('tenant.feature:fasilitas');

        // 11. Galeri
        Route::get('/galeri', [PageController::class, 'galeri'])->name('tenant.galeri')->middleware('tenant.feature:galeri');

        // 12. SPMB / PPDB
        Route::get('/spmb', [PageController::class, 'spmb'])->name('tenant.spmb')->middleware('tenant.feature:spmb');
        Route::get('/ppdb', [PageController::class, 'spmb'])->name('ppdb')->middleware('tenant.feature:spmb');

        // 13. Kontak (Halaman Dasar Wajib - Aktif Permanen)
        Route::get('/kontak', [PageController::class, 'kontak'])->name('tenant.kontak');
        Route::post('/kontak', [PageController::class, 'kirimKontak'])->name('tenant.kontak.kirim');

        // Backward Compatibility Sub-prefix Aliases
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah')->middleware('tenant.feature:sejarah,menu_profil');
            Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi')->middleware('tenant.feature:visi_misi,menu_profil');
            Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur')->middleware('tenant.feature:struktur_organisasi,menu_profil');
            Route::get('/guru', [PageController::class, 'guruStaf'])->name('guru')->middleware('tenant.feature:guru_staf,menu_profil');
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/jurusan', [PageController::class, 'programKeahlian'])->name('jurusan')->middleware('tenant.feature:program_keahlian');
            Route::get('/jurusan/{slug}', [PageController::class, 'detailProgramKeahlian'])->name('jurusan.detail')->middleware('tenant.feature:program_keahlian');
            Route::get('/kurikulum', [PageController::class, 'kurikulum'])->name('kurikulum');
            Route::get('/kalender', [PageController::class, 'agenda'])->name('kalender')->middleware('tenant.feature:agenda');
        });

        Route::prefix('informasi')->name('informasi.')->group(function () {
            Route::get('/berita', [PageController::class, 'berita'])->name('berita')->middleware('tenant.feature:berita');
            Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman')->middleware('tenant.feature:pengumuman');
            Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri')->middleware('tenant.feature:galeri');
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

                // Pengaturan Tampilan Sekolah (Tema & Warna - Super Admin Only)
                Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
                Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

                // Pengaturan Profil Sekolah & Konten Halaman CMS
                Route::prefix('profil')->name('profil.')->group(function () {
                    Route::get('/', [ProfilController::class, 'index'])->name('index');
                    Route::put('/identitas', [ProfilController::class, 'updateIdentitas'])->name('identitas.update');
                    Route::put('/halaman/{slug}', [ProfilController::class, 'updateHalaman'])->name('halaman.update');
                    Route::put('/struktur', [ProfilController::class, 'updateStruktur'])->name('struktur.update')->middleware('tenant.feature:struktur_organisasi');
                    Route::post('/pejabat', [ProfilController::class, 'storePejabat'])->name('pejabat.store')->middleware('tenant.feature:struktur_organisasi');
                    Route::put('/pejabat/{pejabat}', [ProfilController::class, 'updatePejabat'])->name('pejabat.update')->middleware('tenant.feature:struktur_organisasi');
                    Route::delete('/pejabat/{pejabat}', [ProfilController::class, 'destroyPejabat'])->name('pejabat.destroy')->middleware('tenant.feature:struktur_organisasi');
                    Route::put('/guru-hero', [ProfilController::class, 'updateGuruHero'])->name('guru.hero.update')->middleware('tenant.feature:guru_staf');
                    Route::post('/guru', [ProfilController::class, 'storeGuru'])->name('guru.store')->middleware('tenant.feature:guru_staf');
                    Route::put('/guru/{guru}', [ProfilController::class, 'updateGuru'])->name('guru.update')->middleware('tenant.feature:guru_staf');
                    Route::delete('/guru/{guru}', [ProfilController::class, 'destroyGuru'])->name('guru.destroy')->middleware('tenant.feature:guru_staf');
                    Route::post('/toggle-menu', [ProfilController::class, 'toggleMenu'])->name('toggle-menu');
                });

                // Pengaturan Struktur Organisasi & Guru Tenaga Kependidikan (GTK) CMS
                Route::prefix('gtk')->name('gtk.')->middleware('tenant.feature:guru_staf,struktur_organisasi')->group(function () {
                    Route::get('/', [GtkController::class, 'index'])->name('index');
                    Route::put('/struktur', [GtkController::class, 'updateStruktur'])->name('struktur.update')->middleware('tenant.feature:struktur_organisasi');
                    Route::post('/pejabat', [GtkController::class, 'storePejabat'])->name('pejabat.store')->middleware('tenant.feature:struktur_organisasi');
                    Route::put('/pejabat/{pejabat}', [GtkController::class, 'updatePejabat'])->name('pejabat.update')->middleware('tenant.feature:struktur_organisasi');
                    Route::delete('/pejabat/{pejabat}', [GtkController::class, 'destroyPejabat'])->name('pejabat.destroy')->middleware('tenant.feature:struktur_organisasi');
                    Route::put('/guru-hero', [GtkController::class, 'updateGuruHero'])->name('guru.hero.update')->middleware('tenant.feature:guru_staf');
                    Route::post('/guru', [GtkController::class, 'storeGuru'])->name('guru.store')->middleware('tenant.feature:guru_staf');
                    Route::put('/guru/{guru}', [GtkController::class, 'updateGuru'])->name('guru.update')->middleware('tenant.feature:guru_staf');
                    Route::delete('/guru/{guru}', [GtkController::class, 'destroyGuru'])->name('guru.destroy')->middleware('tenant.feature:guru_staf');
                });

                // Pengaturan Program Keahlian / Jurusan CMS
                Route::prefix('program-keahlian')->name('jurusan.')->middleware('tenant.feature:program_keahlian')->group(function () {
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
                    Route::prefix('berita')->name('berita')->middleware('tenant.feature:berita')->group(function () {
                        Route::get('/', [InformasiController::class, 'berita']);
                        Route::post('/', [InformasiController::class, 'storeBerita'])->name('.store');
                        Route::put('/{berita}', [InformasiController::class, 'updateBerita'])->name('.update');
                        Route::delete('/{berita}', [InformasiController::class, 'destroyBerita'])->name('.destroy');
                    });
                    Route::post('/kategori', [InformasiController::class, 'storeKategori'])->name('kategori.store')->middleware('tenant.feature:berita');
                    Route::put('/kategori/{kategori}', [InformasiController::class, 'updateKategori'])->name('kategori.update')->middleware('tenant.feature:berita');
                    Route::delete('/kategori/{kategori}', [InformasiController::class, 'destroyKategori'])->name('kategori.destroy')->middleware('tenant.feature:berita');

                    // 2. Pengumuman
                    Route::prefix('pengumuman')->name('pengumuman')->middleware('tenant.feature:pengumuman')->group(function () {
                        Route::get('/', [InformasiController::class, 'pengumuman']);
                        Route::post('/', [InformasiController::class, 'storePengumuman'])->name('.store');
                        Route::put('/{pengumuman}', [InformasiController::class, 'updatePengumuman'])->name('.update');
                        Route::delete('/{pengumuman}', [InformasiController::class, 'destroyPengumuman'])->name('.destroy');
                    });

                    // 3. Agenda
                    Route::prefix('agenda')->name('agenda')->middleware('tenant.feature:agenda')->group(function () {
                        Route::get('/', [InformasiController::class, 'agenda']);
                        Route::post('/', [InformasiController::class, 'storeAgenda'])->name('.store');
                        Route::put('/{agenda}', [InformasiController::class, 'updateAgenda'])->name('.update');
                        Route::delete('/{agenda}', [InformasiController::class, 'destroyAgenda'])->name('.destroy');
                    });

                    // 4. Galeri
                    Route::prefix('galeri')->name('galeri')->middleware('tenant.feature:galeri')->group(function () {
                        Route::get('/', [InformasiController::class, 'galeri']);
                        Route::post('/album', [InformasiController::class, 'storeAlbum'])->name('.album.store');
                        Route::put('/album/{album}', [InformasiController::class, 'updateAlbum'])->name('.album.update');
                        Route::delete('/album/{album}', [InformasiController::class, 'destroyAlbum'])->name('.album.destroy');
                        Route::post('/album/{album}/item', [InformasiController::class, 'storeItem'])->name('.item.store');
                        Route::delete('/item/{item}', [InformasiController::class, 'destroyItem'])->name('.item.destroy');
                    });

                    // 5. Fasilitas
                    Route::prefix('fasilitas')->name('fasilitas')->middleware('tenant.feature:fasilitas')->group(function () {
                        Route::get('/', [InformasiController::class, 'fasilitas']);
                        Route::post('/', [InformasiController::class, 'storeFasilitas'])->name('.store');
                        Route::put('/{fasilitas}', [InformasiController::class, 'updateFasilitas'])->name('.update');
                        Route::delete('/{fasilitas}', [InformasiController::class, 'destroyFasilitas'])->name('.destroy');
                        Route::delete('/foto/{foto}', [InformasiController::class, 'destroyFotoFasilitas'])->name('.foto.destroy');
                        Route::match(['post', 'put'], '/stats/update', [InformasiController::class, 'updateStatsFasilitas'])->name('.stats.update');
                    });

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
