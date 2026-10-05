<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\Fasilitas;
use App\Models\Tenant\FotoFasilitas;
use App\Models\Tenant\GaleriAlbum;
use App\Models\Tenant\GaleriItem;
use App\Models\Tenant\KategoriArtikel;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Post;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InformasiController extends Controller
{
    // ==========================================
    // 1. BERITA SEKOLAH
    // ==========================================
    public function berita(Request $request): View
    {
        $tenant = app('tenant');
        $query = Post::where('is_pengumuman', false)->with(['kategori', 'pengguna']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('ringkasan', 'like', "%{$q}%")
                    ->orWhere('isi_konten', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        if ($request->filled('status')) {
            $query->where('status_publikasi', $request->input('status'));
        }

        $beritaList = $query->orderBy('tgl_publikasi', 'desc')->paginate(10)->withQueryString();
        $kategoriList = KategoriArtikel::withCount('artikels')->orderBy('nama_kategori')->get();

        $halamanBerita = Page::firstOrCreate(
            ['slug' => 'berita'],
            [
                'judul' => 'Kabar Sekolah Terkini',
                'subjudul' => 'Dapatkan informasi resmi seputar kegiatan belajar mengajar, pencapaian siswa, inovasi kejuruan, dan agenda di '.$tenant->nama_sekolah,
                'gambar_banner' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        $isFiturAktif = PengaturanFitur::isAktif('berita', true);

        return view('tenant.admin.informasi.berita', compact(
            'beritaList',
            'kategoriList',
            'halamanBerita',
            'isFiturAktif'
        ));
    }

    public function storeBerita(Request $request, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:tenant.kategori_artikel,id'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'status_publikasi' => ['required', 'in:draft,published'],
            'tgl_publikasi' => ['nullable', 'date'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'berita', 'Sampul Berita '.$validated['judul']);
        }

        $slugBase = Str::slug($validated['judul']);
        $slug = $slugBase;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$counter}";
            $counter++;
        }

        Post::create([
            'pengguna_id' => $adminId,
            'kategori_id' => $validated['kategori_id'],
            'judul' => $validated['judul'],
            'slug' => $slug,
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['isi_konten']), 160),
            'isi_konten' => $validated['isi_konten'],
            'gambar_sampul' => $validated['gambar_sampul'] ?? null,
            'is_pengumuman' => false,
            'status_publikasi' => $validated['status_publikasi'],
            'tgl_publikasi' => $validated['tgl_publikasi'] ?? now(),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'berita'])
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function updateBerita(Request $request, Post $berita, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:tenant.kategori_artikel,id'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'status_publikasi' => ['required', 'in:draft,published'],
            'tgl_publikasi' => ['nullable', 'date'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'berita', 'Sampul Berita '.$validated['judul']);
        }

        if ($berita->judul !== $validated['judul']) {
            $slugBase = Str::slug($validated['judul']);
            $slug = $slugBase;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }
            $berita->slug = $slug;
        }

        $berita->update([
            'kategori_id' => $validated['kategori_id'],
            'judul' => $validated['judul'],
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['isi_konten']), 160),
            'isi_konten' => $validated['isi_konten'],
            'gambar_sampul' => $validated['gambar_sampul'] ?? $berita->gambar_sampul,
            'status_publikasi' => $validated['status_publikasi'],
            'tgl_publikasi' => $validated['tgl_publikasi'] ?? $berita->tgl_publikasi,
        ]);

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'berita'])
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroyBerita(Post $berita): RedirectResponse
    {
        $berita->delete();

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'berita'])
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function storeKategori(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:tenant.kategori_artikel,nama_kategori'],
        ]);

        KategoriArtikel::create([
            'nama_kategori' => $validated['nama_kategori'],
            'slug' => Str::slug($validated['nama_kategori']),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'kategori'])
            ->with('success', 'Kategori artikel baru berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, KategoriArtikel $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:tenant.kategori_artikel,nama_kategori,'.$kategori->id],
        ]);

        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
            'slug' => Str::slug($validated['nama_kategori']),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'kategori'])
            ->with('success', 'Kategori artikel berhasil diperbarui.');
    }

    public function destroyKategori(KategoriArtikel $kategori): RedirectResponse
    {
        if ($kategori->artikels()->count() > 0) {
            return redirect()
                ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'kategori'])
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa artikel berita.');
        }

        $kategori->delete();

        return redirect()
            ->route('tenant.admin.informasi.berita', ['tenant' => app('tenant')->slug, 'tab' => 'kategori'])
            ->with('success', 'Kategori artikel berhasil dihapus.');
    }

    // ==========================================
    // 2. PENGUMUMAN RESMI
    // ==========================================
    public function pengumuman(Request $request): View
    {
        $tenant = app('tenant');
        $query = Post::where('is_pengumuman', true)->with(['pengguna']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('ringkasan', 'like', "%{$q}%")
                    ->orWhere('isi_konten', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_publikasi', $request->input('status'));
        }

        $pengumumanList = $query->orderBy('tgl_publikasi', 'desc')->paginate(10)->withQueryString();

        $halamanPengumuman = Page::firstOrCreate(
            ['slug' => 'pengumuman'],
            [
                'judul' => 'Pengumuman & Surat Edaran',
                'subjudul' => 'Informasi penting kedinasan, kalender libur/KBM, kelulusan, dan kebijakan pimpinan '.$tenant->nama_sekolah,
                'gambar_banner' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        $isFiturAktif = PengaturanFitur::isAktif('pengumuman', true);

        return view('tenant.admin.informasi.pengumuman', compact(
            'pengumumanList',
            'halamanPengumuman',
            'isFiturAktif'
        ));
    }

    public function storePengumuman(Request $request, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'status_publikasi' => ['required', 'in:draft,published'],
            'tgl_publikasi' => ['nullable', 'date'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'pengumuman', 'Lampiran Pengumuman '.$validated['judul']);
        }

        $slugBase = Str::slug($validated['judul']);
        $slug = $slugBase;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$counter}";
            $counter++;
        }

        // Kategori ID default untuk pengumuman
        $kategoriDefault = KategoriArtikel::firstOrCreate(
            ['slug' => 'pengumuman-kedinasan'],
            ['nama_kategori' => 'Pengumuman Kedinasan']
        );

        Post::create([
            'pengguna_id' => $adminId,
            'kategori_id' => $kategoriDefault->id,
            'judul' => $validated['judul'],
            'slug' => $slug,
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['isi_konten']), 160),
            'isi_konten' => $validated['isi_konten'],
            'gambar_sampul' => $validated['gambar_sampul'] ?? null,
            'is_pengumuman' => true,
            'status_publikasi' => $validated['status_publikasi'],
            'tgl_publikasi' => $validated['tgl_publikasi'] ?? now(),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.pengumuman', ['tenant' => app('tenant')->slug, 'tab' => 'pengumuman'])
            ->with('success', 'Pengumuman resmi berhasil diterbitkan.');
    }

    public function updatePengumuman(Request $request, Post $pengumuman, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi_konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'status_publikasi' => ['required', 'in:draft,published'],
            'tgl_publikasi' => ['nullable', 'date'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'pengumuman', 'Lampiran Pengumuman '.$validated['judul']);
        }

        if ($pengumuman->judul !== $validated['judul']) {
            $slugBase = Str::slug($validated['judul']);
            $slug = $slugBase;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $pengumuman->id)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }
            $pengumuman->slug = $slug;
        }

        $pengumuman->update([
            'judul' => $validated['judul'],
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['isi_konten']), 160),
            'isi_konten' => $validated['isi_konten'],
            'gambar_sampul' => $validated['gambar_sampul'] ?? $pengumuman->gambar_sampul,
            'status_publikasi' => $validated['status_publikasi'],
            'tgl_publikasi' => $validated['tgl_publikasi'] ?? $pengumuman->tgl_publikasi,
        ]);

        return redirect()
            ->route('tenant.admin.informasi.pengumuman', ['tenant' => app('tenant')->slug, 'tab' => 'pengumuman'])
            ->with('success', 'Pengumuman resmi berhasil diperbarui.');
    }

    public function destroyPengumuman(Post $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return redirect()
            ->route('tenant.admin.informasi.pengumuman', ['tenant' => app('tenant')->slug, 'tab' => 'pengumuman'])
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    // ==========================================
    // 3. AGENDA & KEGIATAN
    // ==========================================
    public function agenda(Request $request): View
    {
        $tenant = app('tenant');
        $query = Agenda::with('pengguna');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhere('penyelenggara', 'like', "%{$q}%")
                    ->orWhere('ringkasan', 'like', "%{$q}%");
            });
        }

        $agendaList = $query->orderBy('tgl_mulai', 'desc')->paginate(10)->withQueryString();

        $halamanAgenda = Page::firstOrCreate(
            ['slug' => 'agenda'],
            [
                'judul' => 'Kalender & Agenda Kegiatan',
                'subjudul' => 'Jadwal lengkap asesmen akademik, sertifikasi kompetensi industri, pameran inovasi TEFA, dan agenda kegiatan '.$tenant->nama_sekolah,
                'gambar_banner' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        $isFiturAktif = PengaturanFitur::isAktif('agenda', true);

        return view('tenant.admin.informasi.agenda', compact(
            'agendaList',
            'halamanAgenda',
            'isFiturAktif'
        ));
    }

    public function storeAgenda(Request $request, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'jam_mulai' => ['nullable', 'string', 'max:50'],
            'jam_selesai' => ['nullable', 'string', 'max:50'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'link_pendaftaran' => ['nullable', 'url', 'max:255'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'agenda', 'Sampul Agenda '.$validated['judul']);
        }

        $slugBase = Str::slug($validated['judul']);
        $slug = $slugBase;
        $counter = 1;
        while (Agenda::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$counter}";
            $counter++;
        }

        Agenda::create([
            'pengguna_id' => $adminId,
            'judul' => $validated['judul'],
            'slug' => $slug,
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_selesai' => $validated['tgl_selesai'] ?? null,
            'jam_mulai' => $validated['jam_mulai'] ?? null,
            'jam_selesai' => $validated['jam_selesai'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'penyelenggara' => $validated['penyelenggara'] ?? null,
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['deskripsi_lengkap'] ?? ''), 160),
            'deskripsi_lengkap' => $validated['deskripsi_lengkap'] ?? '',
            'gambar_sampul' => $validated['gambar_sampul'] ?? null,
            'link_pendaftaran' => $validated['link_pendaftaran'] ?? null,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.agenda', ['tenant' => app('tenant')->slug, 'tab' => 'agenda'])
            ->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function updateAgenda(Request $request, Agenda $agenda, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tgl_mulai' => ['required', 'date'],
            'tgl_selesai' => ['nullable', 'date', 'after_or_equal:tgl_mulai'],
            'jam_mulai' => ['nullable', 'string', 'max:50'],
            'jam_selesai' => ['nullable', 'string', 'max:50'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'gambar_sampul' => ['nullable', 'string', 'max:500'],
            'link_pendaftaran' => ['nullable', 'url', 'max:255'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['gambar_sampul'])) {
            $validated['gambar_sampul'] = $mediaService->sinkronisasiOtomatisUrl($validated['gambar_sampul'], $adminId, 'agenda', 'Sampul Agenda '.$validated['judul']);
        }

        if ($agenda->judul !== $validated['judul']) {
            $slugBase = Str::slug($validated['judul']);
            $slug = $slugBase;
            $counter = 1;
            while (Agenda::where('slug', $slug)->where('id', '!=', $agenda->id)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }
            $agenda->slug = $slug;
        }

        $agenda->update([
            'judul' => $validated['judul'],
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_selesai' => $validated['tgl_selesai'] ?? null,
            'jam_mulai' => $validated['jam_mulai'] ?? null,
            'jam_selesai' => $validated['jam_selesai'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'penyelenggara' => $validated['penyelenggara'] ?? null,
            'ringkasan' => $validated['ringkasan'] ?? Str::limit(strip_tags($validated['deskripsi_lengkap'] ?? ''), 160),
            'deskripsi_lengkap' => $validated['deskripsi_lengkap'] ?? '',
            'gambar_sampul' => $validated['gambar_sampul'] ?? $agenda->gambar_sampul,
            'link_pendaftaran' => $validated['link_pendaftaran'] ?? null,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        return redirect()
            ->route('tenant.admin.informasi.agenda', ['tenant' => app('tenant')->slug, 'tab' => 'agenda'])
            ->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroyAgenda(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('tenant.admin.informasi.agenda', ['tenant' => app('tenant')->slug, 'tab' => 'agenda'])
            ->with('success', 'Agenda kegiatan berhasil dihapus.');
    }

    // ==========================================
    // 4. GALERI FOTO & VIDEO
    // ==========================================
    public function galeri(Request $request): View
    {
        $tenant = app('tenant');
        $query = GaleriAlbum::withCount('items');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_album', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }

        $albumList = $query->latest()->paginate(9)->withQueryString();
        $selectedAlbum = null;
        if ($request->filled('album_id')) {
            $selectedAlbum = GaleriAlbum::with('items')->find($request->input('album_id'));
        }

        $halamanGaleri = Page::firstOrCreate(
            ['slug' => 'galeri'],
            [
                'judul' => 'Galeri Foto & Video',
                'subjudul' => 'Merekam setiap momen bersejarah, kreasi siswa vokasi, pameran karya, dan interaksi hangat di lingkungan '.$tenant->nama_sekolah,
                'gambar_banner' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        $isFiturAktif = PengaturanFitur::isAktif('galeri', true);

        return view('tenant.admin.informasi.galeri', compact(
            'albumList',
            'selectedAlbum',
            'halamanGaleri',
            'isFiturAktif'
        ));
    }

    public function storeAlbum(Request $request, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'nama_album' => ['required', 'string', 'max:150'],
            'tipe' => ['required', 'in:foto,video'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'cover_album' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($validated['cover_album'])) {
            $validated['cover_album'] = $mediaService->sinkronisasiOtomatisUrl($validated['cover_album'], $adminId, 'galeri', 'Cover Album '.$validated['nama_album']);
        }

        $slugBase = Str::slug($validated['nama_album']);
        $slug = $slugBase;
        $counter = 1;
        while (GaleriAlbum::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$counter}";
            $counter++;
        }

        $album = GaleriAlbum::create([
            'nama_album' => $validated['nama_album'],
            'slug' => $slug,
            'tipe' => $validated['tipe'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'cover_album' => $validated['cover_album'] ?? null,
        ]);

        return redirect()
            ->route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'album', 'album_id' => $album->id])
            ->with('success', "Album '{$album->nama_album}' berhasil dibuat. Silakan tambahkan berkas media/foto ke dalamnya.");
    }

    public function updateAlbum(Request $request, GaleriAlbum $album, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'nama_album' => ['required', 'string', 'max:150'],
            'tipe' => ['required', 'in:foto,video'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'cover_album' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($validated['cover_album'])) {
            $validated['cover_album'] = $mediaService->sinkronisasiOtomatisUrl($validated['cover_album'], $adminId, 'galeri', 'Cover Album '.$validated['nama_album']);
        }

        if ($album->nama_album !== $validated['nama_album']) {
            $slugBase = Str::slug($validated['nama_album']);
            $slug = $slugBase;
            $counter = 1;
            while (GaleriAlbum::where('slug', $slug)->where('id', '!=', $album->id)->exists()) {
                $slug = "{$slugBase}-{$counter}";
                $counter++;
            }
            $album->slug = $slug;
        }

        $album->update([
            'nama_album' => $validated['nama_album'],
            'tipe' => $validated['tipe'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'cover_album' => $validated['cover_album'] ?? $album->cover_album,
        ]);

        return redirect()
            ->route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'album', 'album_id' => $album->id])
            ->with('success', "Album '{$album->nama_album}' berhasil diperbarui.");
    }

    public function destroyAlbum(GaleriAlbum $album): RedirectResponse
    {
        $album->items()->delete();
        $album->delete();

        return redirect()
            ->route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'album'])
            ->with('success', 'Album galeri beserta seluruh fotonya berhasil dihapus.');
    }

    public function storeItem(Request $request, GaleriAlbum $album, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'file_media_atau_link' => ['required', 'string', 'max:500'],
            'judul_item' => ['nullable', 'string', 'max:150'],
        ]);

        $fileUrl = $mediaService->sinkronisasiOtomatisUrl(
            $validated['file_media_atau_link'],
            $adminId,
            'galeri',
            $validated['judul_item'] ?? ('Item Galeri '.$album->nama_album)
        );

        GaleriItem::create([
            'album_id' => $album->id,
            'file_media_atau_link' => $fileUrl,
            'judul_item' => $validated['judul_item'] ?? null,
        ]);

        return redirect()
            ->route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'items', 'album_id' => $album->id])
            ->with('success', 'Media berhasil ditambahkan ke album.');
    }

    public function destroyItem(GaleriItem $item): RedirectResponse
    {
        $albumId = $item->album_id;
        $item->delete();

        return redirect()
            ->route('tenant.admin.informasi.galeri', ['tenant' => app('tenant')->slug, 'tab' => 'items', 'album_id' => $albumId])
            ->with('success', 'Media berhasil dihapus dari album.');
    }

    // ==========================================
    // 5. FASILITAS & SARANA PRASARANA
    // ==========================================
    public function fasilitas(Request $request): View
    {
        $tenant = app('tenant');
        $query = Fasilitas::with('fotoLainnya');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_fasilitas', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $fasilitasList = $query->latest()->paginate(9)->withQueryString();

        $halamanFasilitas = Page::firstOrCreate(
            ['slug' => 'fasilitas'],
            [
                'judul' => 'Fasilitas & Infrastruktur',
                'subjudul' => 'Menunjang pembelajaran teaching factory dengan peralatan modern: mesin CNC industri, bengkel otomotif EFI, studio multimedia, dan perpustakaan digital.',
                'gambar_banner' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        // Statistik Cepat Sarpras di PengaturanUmum
        $stats = [
            'ruang_kelas' => PengaturanUmum::ambil('stats_ruang_kelas', '41'),
            'bengkel_lab' => PengaturanUmum::ambil('stats_bengkel_lab', '7+'),
            'perpustakaan' => PengaturanUmum::ambil('stats_perpustakaan', '1'),
            'akses_internet' => PengaturanUmum::ambil('stats_akses_internet', '100%'),
        ];

        $isFiturAktif = PengaturanFitur::isAktif('fasilitas', true);

        return view('tenant.admin.informasi.fasilitas', compact(
            'fasilitasList',
            'halamanFasilitas',
            'stats',
            'isFiturAktif'
        ));
    }

    public function storeFasilitas(Request $request, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'foto_utama' => ['required', 'string', 'max:500'],
            'is_aktif' => ['nullable', 'boolean'],
            'foto_tambahan' => ['nullable', 'array'],
            'foto_tambahan.*' => ['nullable', 'string', 'max:500'],
            'keterangan_tambahan' => ['nullable', 'array'],
            'keterangan_tambahan.*' => ['nullable', 'string', 'max:200'],
        ]);

        $fotoUtamaUrl = $mediaService->sinkronisasiOtomatisUrl(
            $validated['foto_utama'],
            $adminId,
            'fasilitas',
            'Foto Utama '.$validated['nama_fasilitas']
        );

        $fasilitas = Fasilitas::create([
            'nama_fasilitas' => $validated['nama_fasilitas'],
            'deskripsi' => $validated['deskripsi'],
            'foto_utama' => $fotoUtamaUrl,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        if (! empty($validated['foto_tambahan'])) {
            foreach ($validated['foto_tambahan'] as $idx => $fotoUrl) {
                if (! empty($fotoUrl)) {
                    $ket = $validated['keterangan_tambahan'][$idx] ?? $validated['nama_fasilitas'];
                    $syncedUrl = $mediaService->sinkronisasiOtomatisUrl($fotoUrl, $adminId, 'fasilitas', 'Dokumentasi '.$ket);
                    FotoFasilitas::create([
                        'fasilitas_id' => $fasilitas->id,
                        'file_foto' => $syncedUrl,
                        'keterangan' => $ket,
                    ]);
                }
            }
        }

        return redirect()
            ->route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'fasilitas'])
            ->with('success', 'Data fasilitas berhasil ditambahkan.');
    }

    public function updateFasilitas(Request $request, Fasilitas $fasilitas, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'foto_utama' => ['required', 'string', 'max:500'],
            'is_aktif' => ['nullable', 'boolean'],
            'foto_tambahan' => ['nullable', 'array'],
            'foto_tambahan.*' => ['nullable', 'string', 'max:500'],
            'keterangan_tambahan' => ['nullable', 'array'],
            'keterangan_tambahan.*' => ['nullable', 'string', 'max:200'],
        ]);

        $fotoUtamaUrl = $mediaService->sinkronisasiOtomatisUrl(
            $validated['foto_utama'],
            $adminId,
            'fasilitas',
            'Foto Utama '.$validated['nama_fasilitas']
        );

        $fasilitas->update([
            'nama_fasilitas' => $validated['nama_fasilitas'],
            'deskripsi' => $validated['deskripsi'],
            'foto_utama' => $fotoUtamaUrl,
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        if (! empty($validated['foto_tambahan'])) {
            foreach ($validated['foto_tambahan'] as $idx => $fotoUrl) {
                if (! empty($fotoUrl)) {
                    $ket = $validated['keterangan_tambahan'][$idx] ?? $validated['nama_fasilitas'];
                    $syncedUrl = $mediaService->sinkronisasiOtomatisUrl($fotoUrl, $adminId, 'fasilitas', 'Dokumentasi '.$ket);
                    FotoFasilitas::create([
                        'fasilitas_id' => $fasilitas->id,
                        'file_foto' => $syncedUrl,
                        'keterangan' => $ket,
                    ]);
                }
            }
        }

        return redirect()
            ->route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'fasilitas'])
            ->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    public function destroyFasilitas(Fasilitas $fasilitas): RedirectResponse
    {
        $fasilitas->fotoLainnya()->delete();
        $fasilitas->delete();

        return redirect()
            ->route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'fasilitas'])
            ->with('success', 'Data fasilitas berhasil dihapus.');
    }

    public function destroyFotoFasilitas(FotoFasilitas $foto): RedirectResponse
    {
        $foto->delete();

        return back()->with('success', 'Foto dokumentasi fasilitas berhasil dihapus.');
    }

    public function updateStatsFasilitas(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'stats_ruang_kelas' => ['required', 'string', 'max:50'],
            'stats_bengkel_lab' => ['required', 'string', 'max:50'],
            'stats_perpustakaan' => ['required', 'string', 'max:50'],
            'stats_akses_internet' => ['required', 'string', 'max:50'],
        ]);

        foreach ($validated as $k => $v) {
            PengaturanUmum::simpan($k, $v);
        }

        return redirect()
            ->route('tenant.admin.informasi.fasilitas', ['tenant' => app('tenant')->slug, 'tab' => 'stats'])
            ->with('success', 'Angka statistik sarana prasarana berhasil diperbarui.');
    }

    // ==========================================
    // 6. HERO BANNER GLOBAL UPDATE PER MODUL
    // ==========================================
    public function updateHero(Request $request, string $modul, MediaService $mediaService): RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();

        $judul = $request->input('judul_hero', $request->input('judul'));
        $subjudul = $request->input('subjudul_hero', $request->input('subjudul'));

        $request->merge([
            'judul_hero' => $judul,
            'subjudul_hero' => $subjudul,
        ]);

        $validated = $request->validate([
            'judul_hero' => ['required', 'string', 'max:200'],
            'subjudul_hero' => ['nullable', 'string', 'max:500'],
            'gambar_banner' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($validated['gambar_banner'])) {
            $validated['gambar_banner'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['gambar_banner'],
                $adminId,
                $modul,
                'Hero Banner Halaman '.ucfirst($modul)
            );
        }

        Page::updateOrCreate(
            ['slug' => $modul],
            [
                'judul' => $validated['judul_hero'],
                'subjudul' => $validated['subjudul_hero'] ?? null,
                'gambar_banner' => $validated['gambar_banner'] ?? null,
                'pengguna_id' => $adminId,
            ]
        );

        $routeMap = [
            'berita' => 'tenant.admin.informasi.berita',
            'pengumuman' => 'tenant.admin.informasi.pengumuman',
            'agenda' => 'tenant.admin.informasi.agenda',
            'galeri' => 'tenant.admin.informasi.galeri',
            'fasilitas' => 'tenant.admin.informasi.fasilitas',
        ];

        $targetRoute = $routeMap[$modul] ?? 'tenant.admin.informasi.berita';

        return redirect()
            ->route($targetRoute, ['tenant' => app('tenant')->slug, 'tab' => 'hero'])
            ->with('success', 'Kustomisasi hero banner publik untuk '.ucfirst($modul).' berhasil disimpan.');
    }

    // ==========================================
    // 7. SAKELAR VISIBILITAS FITUR / MENU (AJAX & Form)
    // ==========================================
    public function toggleStatus(Request $request): JsonResponse|RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();
        $targetType = $request->input('target_type', 'fitur'); // 'fitur', 'berita', 'agenda', 'fasilitas'
        $kodeFitur = $request->input('kode_fitur', $request->input('fitur', 'berita'));

        if ($targetType === 'item') {
            $modelType = $request->input('model_type');
            $id = $request->input('id');

            if ($modelType === 'agenda') {
                $item = Agenda::findOrFail($id);
                $newStatus = $request->has('is_aktif') ? $request->boolean('is_aktif') : ! $item->is_aktif;
                $item->update(['is_aktif' => $newStatus]);

                return response()->json(['success' => true, 'is_aktif' => $newStatus]);
            }

            if ($modelType === 'fasilitas') {
                $item = Fasilitas::findOrFail($id);
                $newStatus = $request->has('is_aktif') ? $request->boolean('is_aktif') : ! $item->is_aktif;
                $item->update(['is_aktif' => $newStatus]);

                return response()->json(['success' => true, 'is_aktif' => $newStatus]);
            }

            if ($modelType === 'berita') {
                $item = Post::findOrFail($id);
                $newStatus = ($item->status_publikasi === 'published') ? 'draft' : 'published';
                $item->update(['status_publikasi' => $newStatus]);

                return response()->json(['success' => true, 'status_publikasi' => $newStatus, 'is_published' => $newStatus === 'published']);
            }
        }

        // Toggle Feature Flag
        $isAktif = $request->has('is_aktif')
            ? $request->boolean('is_aktif')
            : ! PengaturanFitur::isAktif($kodeFitur, true);

        $namaMap = [
            'berita' => 'Berita & Artikel',
            'pengumuman' => 'Pengumuman Resmi',
            'agenda' => 'Agenda & Event',
            'galeri' => 'Galeri Foto & Video',
            'kegiatan' => 'Dokumentasi Kegiatan',
            'fasilitas' => 'Fasilitas & Sarpras',
        ];

        $urlMap = [
            'berita' => '/berita',
            'pengumuman' => '/pengumuman',
            'agenda' => '/agenda',
            'galeri' => '/galeri',
            'kegiatan' => '/kegiatan',
            'fasilitas' => '/fasilitas',
        ];

        DB::connection('tenant')->transaction(function () use ($kodeFitur, $isAktif, $adminId, $namaMap, $urlMap) {
            PengaturanFitur::updateOrCreate(
                ['kode_fitur' => $kodeFitur],
                [
                    'nama_fitur' => $namaMap[$kodeFitur] ?? ucfirst($kodeFitur),
                    'is_aktif' => $isAktif,
                    'pengguna_id' => $adminId,
                ]
            );

            if (isset($urlMap[$kodeFitur])) {
                Menu::where(function ($q) use ($urlMap, $kodeFitur) {
                    $q->where('url', $urlMap[$kodeFitur])
                        ->orWhere('url', ltrim($urlMap[$kodeFitur], '/'));
                })->update(['is_aktif' => $isAktif]);
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Visibilitas '.($namaMap[$kodeFitur] ?? $kodeFitur).' berhasil diubah menjadi '.($isAktif ? 'Aktif (Tampil)' : 'Nonaktif (Sembunyi)'),
                'is_aktif' => $isAktif,
            ]);
        }

        return back()->with('success', 'Status visibilitas berhasil diperbarui.');
    }
}
