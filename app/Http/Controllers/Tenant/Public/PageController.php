<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\Ekstrakurikuler;
use App\Models\Tenant\Fasilitas;
use App\Models\Tenant\GaleriAlbum;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\KategoriArtikel;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\PesanMasuk;
use App\Models\Tenant\Post;
use App\Models\Tenant\PrestasiSiswa;
use App\Models\Tenant\StrukturOrganisasi;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private function getSekolahData(): array
    {
        $sekolah = app('tenant');

        return [
            'nama' => PengaturanUmum::ambil('nama_sekolah', $sekolah->nama_sekolah),
            'jenjang' => $sekolah->jenjang,
            'slogan' => PengaturanUmum::ambil('slogan', 'Sekolah Pusat Keunggulan - Unggul, Berkarakter & Berdaya Saing Global'),
            'npsn' => PengaturanUmum::ambil('npsn', $sekolah->data['npsn'] ?? '20219146'),
            'akreditasi' => PengaturanUmum::ambil('akreditasi', $sekolah->data['akreditasi'] ?? 'A'),
            'tahun_berdiri' => PengaturanUmum::ambil('tahun_berdiri', '1951'),
            'alamat' => PengaturanUmum::ambil('alamat', $sekolah->data['alamat'] ?? ''),
            'telepon' => PengaturanUmum::ambil('no_telepon', $sekolah->data['telepon'] ?? ''),
            'email' => PengaturanUmum::ambil('email_sekolah', $sekolah->data['email'] ?? ''),
            'whatsapp' => PengaturanUmum::ambil('whatsapp', '081222333444'),
            'jam_layanan' => PengaturanUmum::ambil('jam_layanan', 'Senin - Jumat: 07.00 - 16.00 WIB'),
            'logo' => PengaturanUmum::ambil('logo', ''),
            'warna_tema' => PengaturanUmum::ambil('warna_tema', '#1E3A8A'),
            'warna_aksen' => PengaturanUmum::ambil('warna_aksen', '#0284C7'),
            'peta_embed' => PengaturanUmum::ambil('peta_embed', ''),
            'nama_kepsek' => PengaturanUmum::ambil('nama_kepsek', 'Dr. H. Hasanudin, M.Pd.'),
            'nip_kepsek' => PengaturanUmum::ambil('nip_kepsek', '19680512 199303 1 004'),
            'foto_kepsek' => PengaturanUmum::ambil('foto_kepsek', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop'),
            'sambutan_kepsek' => PengaturanUmum::ambil('sambutan_kepsek', ''),
            // Statistik
            'stat_guru' => PengaturanUmum::ambil('stat_guru', '98'),
            'stat_guru_label' => PengaturanUmum::ambil('stat_guru_label', 'Guru & Tenaga Kependidikan'),
            'stat_siswa' => PengaturanUmum::ambil('stat_siswa', '1972'),
            'stat_siswa_label' => PengaturanUmum::ambil('stat_siswa_label', 'Siswa Aktif'),
            'stat_rombel' => PengaturanUmum::ambil('stat_rombel', '54'),
            'stat_rombel_label' => PengaturanUmum::ambil('stat_rombel_label', 'Rombongan Belajar'),
            'stat_kelas' => PengaturanUmum::ambil('stat_kelas', '41'),
            'stat_kelas_label' => PengaturanUmum::ambil('stat_kelas_label', 'Ruang Kelas'),
            'stat_jurusan' => PengaturanUmum::ambil('stat_jurusan', '7'),
            'stat_jurusan_label' => PengaturanUmum::ambil('stat_jurusan_label', 'Program Keahlian'),
            'stat_mitra' => PengaturanUmum::ambil('stat_mitra', '85'),
            'stat_mitra_label' => PengaturanUmum::ambil('stat_mitra_label', 'Mitra Industri (DUDI)'),
            'stat_sumber_label' => PengaturanUmum::ambil('stat_sumber_label', 'Dapodik Kemendikbudristek TA 2025/2026'),
        ];
    }

    private function checkFitur(string $kode): void
    {
        if (! PengaturanFitur::isAktif($kode)) {
            abort(404, 'Halaman ini saat ini tidak diaktifkan oleh sekolah.');
        }
    }

    // 1. PROFIL SEKOLAH LENGKAP
    public function profil()
    {
        $this->checkFitur('profil');
        $sekolah = $this->getSekolahData();
        $sejarah = Page::where('slug', 'sejarah')->first();
        $visiMisi = Page::where('slug', 'visi-misi')->first();
        $profil = Page::where('slug', 'profil')->first();
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();

        return view('public.pages.profil', compact('sekolah', 'sejarah', 'visiMisi', 'profil', 'struktur'));
    }

    public function sejarah()
    {
        $this->checkFitur('profil');
        $halaman = Page::where('slug', 'sejarah')->first();

        return view('public.pages.sejarah', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function visiMisi()
    {
        $this->checkFitur('profil');
        $halaman = Page::where('slug', 'visi-misi')->first();

        return view('public.pages.visi-misi', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function struktur()
    {
        $this->checkFitur('profil');
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();

        return view('public.pages.struktur', ['sekolah' => $this->getSekolahData(), 'struktur' => $struktur]);
    }

    // 2. PROGRAM KEAHLIAN / JURUSAN
    public function programKeahlian()
    {
        $this->checkFitur('program_keahlian');
        $jurusan = Jurusan::where('is_aktif', true)->orderBy('urutan')->get();

        return view('public.pages.jurusan', ['sekolah' => $this->getSekolahData(), 'jurusan' => $jurusan]);
    }

    public function detailProgramKeahlian(string $slug)
    {
        $this->checkFitur('program_keahlian');
        $jurusan = Jurusan::where('slug', $slug)->firstOrFail();
        $jurusanLainnya = Jurusan::where('id', '!=', $jurusan->id)->where('is_aktif', true)->orderBy('urutan')->get();

        return view('public.pages.jurusan_detail', [
            'sekolah' => $this->getSekolahData(),
            'jurusan' => $jurusan,
            'jurusanLainnya' => $jurusanLainnya,
        ]);
    }

    // 3. BERITA
    public function berita(Request $request)
    {
        $this->checkFitur('berita');
        $query = Post::published()->where('is_pengumuman', false)->with('kategori');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('ringkasan', 'like', "%{$q}%")
                    ->orWhere('isi_konten', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($k) use ($request) {
                $k->where('slug', $request->input('kategori'));
            });
        }

        $berita = $query->orderBy('tgl_publikasi', 'desc')->paginate(9)->withQueryString();
        $kategoriList = KategoriArtikel::withCount(['artikels' => function ($q) {
            $q->where('status_publikasi', 'published')->where('is_pengumuman', false);
        }])->get();

        $featured = Post::published()->where('is_pengumuman', false)->orderBy('tgl_publikasi', 'desc')->first();

        return view('public.pages.berita', [
            'sekolah' => $this->getSekolahData(),
            'berita' => $berita,
            'kategoriList' => $kategoriList,
            'featured' => $featured,
        ]);
    }

    public function detailBerita(string $slug)
    {
        $this->checkFitur('berita');
        $post = Post::published()->where('is_pengumuman', false)->where('slug', $slug)->with('kategori')->firstOrFail();
        $post->increment('jumlah_dilihat');

        $related = Post::published()
            ->where('is_pengumuman', false)
            ->where('id', '!=', $post->id)
            ->where('kategori_id', $post->kategori_id)
            ->take(3)
            ->get();

        return view('public.pages.berita_detail', [
            'sekolah' => $this->getSekolahData(),
            'post' => $post,
            'related' => $related,
        ]);
    }

    // 4. AGENDA
    public function agenda(Request $request)
    {
        $this->checkFitur('agenda');
        $query = Agenda::aktif();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhere('penyelenggara', 'like', "%{$q}%");
            });
        }

        $filter = $request->input('filter', 'mendatang');
        if ($filter === 'mendatang') {
            $query->where('tgl_mulai', '>=', now()->toDateString())->orderBy('tgl_mulai', 'asc');
        } elseif ($filter === 'lampau') {
            $query->where('tgl_mulai', '<', now()->toDateString())->orderBy('tgl_mulai', 'desc');
        } else {
            $query->orderBy('tgl_mulai', 'desc');
        }

        $agenda = $query->paginate(8)->withQueryString();

        return view('public.pages.agenda', [
            'sekolah' => $this->getSekolahData(),
            'agenda' => $agenda,
            'filter' => $filter,
        ]);
    }

    public function detailAgenda(string $slug)
    {
        $this->checkFitur('agenda');
        $agenda = Agenda::aktif()->where('slug', $slug)->firstOrFail();
        $agendaLainnya = Agenda::aktif()->where('id', '!=', $agenda->id)->orderBy('tgl_mulai', 'asc')->take(3)->get();

        return view('public.pages.agenda_detail', [
            'sekolah' => $this->getSekolahData(),
            'agenda' => $agenda,
            'agendaLainnya' => $agendaLainnya,
        ]);
    }

    // 5. PENGUMUMAN
    public function pengumuman(Request $request)
    {
        $this->checkFitur('pengumuman');
        $query = Post::published()->where('is_pengumuman', true);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('ringkasan', 'like', "%{$q}%");
            });
        }

        $pengumuman = $query->orderBy('tgl_publikasi', 'desc')->paginate(8)->withQueryString();

        return view('public.pages.pengumuman', [
            'sekolah' => $this->getSekolahData(),
            'pengumuman' => $pengumuman,
        ]);
    }

    public function detailPengumuman(string $slug)
    {
        $this->checkFitur('pengumuman');
        $post = Post::published()->where('is_pengumuman', true)->where('slug', $slug)->firstOrFail();
        $post->increment('jumlah_dilihat');

        $pengumumanLainnya = Post::published()
            ->where('is_pengumuman', true)
            ->where('id', '!=', $post->id)
            ->orderBy('tgl_publikasi', 'desc')
            ->take(3)
            ->get();

        return view('public.pages.pengumuman_detail', [
            'sekolah' => $this->getSekolahData(),
            'post' => $post,
            'pengumumanLainnya' => $pengumumanLainnya,
        ]);
    }

    // 6. PRESTASI
    public function prestasi(Request $request)
    {
        $this->checkFitur('prestasi');
        $query = PrestasiSiswa::query();

        if ($tingkat = $request->input('tingkat')) {
            $query->where('tingkat', $tingkat);
        }

        if ($tahun = $request->input('tahun')) {
            $query->where('tahun', $tahun);
        }

        $prestasi = $query->orderBy('tanggal', 'desc')->paginate(9)->withQueryString();
        $daftarTingkat = PrestasiSiswa::select('tingkat')->distinct()->whereNotNull('tingkat')->pluck('tingkat');
        $daftarTahun = PrestasiSiswa::select('tahun')->distinct()->whereNotNull('tahun')->orderBy('tahun', 'desc')->pluck('tahun');

        return view('public.pages.prestasi', [
            'sekolah' => $this->getSekolahData(),
            'prestasi' => $prestasi,
            'daftarTingkat' => $daftarTingkat,
            'daftarTahun' => $daftarTahun,
        ]);
    }

    public function detailPrestasi(string $slug)
    {
        $this->checkFitur('prestasi');
        $prestasi = PrestasiSiswa::where('slug', $slug)->firstOrFail();
        $prestasiLainnya = PrestasiSiswa::where('id', '!=', $prestasi->id)->orderBy('tanggal', 'desc')->take(3)->get();

        return view('public.pages.prestasi_detail', [
            'sekolah' => $this->getSekolahData(),
            'prestasi' => $prestasi,
            'prestasiLainnya' => $prestasiLainnya,
        ]);
    }

    // 7. KEGIATAN
    public function kegiatan()
    {
        $this->checkFitur('kegiatan');
        $album = GaleriAlbum::with('items')->latest()->get();
        $agenda = Agenda::aktif()->orderBy('tgl_mulai', 'desc')->take(6)->get();

        return view('public.pages.kegiatan', [
            'sekolah' => $this->getSekolahData(),
            'album' => $album,
            'agenda' => $agenda,
        ]);
    }

    // 8. EKSTRAKURIKULER
    public function ekstrakurikuler()
    {
        $this->checkFitur('ekstrakurikuler');
        $ekskul = Ekstrakurikuler::aktif()->get();

        return view('public.pages.ekstrakurikuler', ['sekolah' => $this->getSekolahData(), 'ekstrakurikuler' => $ekskul]);
    }

    public function detailEkstrakurikuler(string $slug)
    {
        $this->checkFitur('ekstrakurikuler');
        $ekskul = Ekstrakurikuler::aktif()->where('slug', $slug)->firstOrFail();
        $ekskulLainnya = Ekstrakurikuler::aktif()->where('id', '!=', $ekskul->id)->get();

        return view('public.pages.ekstrakurikuler_detail', [
            'sekolah' => $this->getSekolahData(),
            'ekskul' => $ekskul,
            'ekskulLainnya' => $ekskulLainnya,
        ]);
    }

    // 9. GURU & STAF
    public function guruStaf(Request $request)
    {
        $this->checkFitur('guru_staf');
        $query = GuruStaf::aktif();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('jabatan', 'like', "%{$q}%")
                    ->orWhere('mata_pelajaran', 'like', "%{$q}%");
            });
        }

        $guru = $query->paginate(12)->withQueryString();

        return view('public.pages.guru', ['sekolah' => $this->getSekolahData(), 'guru' => $guru]);
    }

    // 10. FASILITAS
    public function fasilitas()
    {
        $this->checkFitur('fasilitas');
        $fasilitas = Fasilitas::aktif()->with('fotoLainnya')->get();

        return view('public.pages.fasilitas', ['sekolah' => $this->getSekolahData(), 'fasilitas' => $fasilitas]);
    }

    // 11. GALERI
    public function galeri()
    {
        $this->checkFitur('galeri');
        $album = GaleriAlbum::with('items')->get();

        return view('public.pages.galeri', ['sekolah' => $this->getSekolahData(), 'album' => $album]);
    }

    // 12. SPMB
    public function spmb()
    {
        $this->checkFitur('spmb');
        $halaman = Page::where('slug', 'spmb')->first();

        return view('public.pages.spmb', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    // 13. KONTAK & PENGIRIMAN PESAN
    public function kontak()
    {
        $this->checkFitur('kontak');

        return view('public.pages.kontak', ['sekolah' => $this->getSekolahData()]);
    }

    public function kirimKontak(Request $request)
    {
        $this->checkFitur('kontak');

        $validated = $request->validate([
            'nama_pengirim' => ['required', 'string', 'max:150'],
            'email_pengirim' => ['required', 'email', 'max:150'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'subjek' => ['required', 'string', 'max:200'],
            'pesan' => ['required', 'string', 'min:10', 'max:3000'],
        ], [
            'nama_pengirim.required' => 'Nama lengkap wajib diisi.',
            'email_pengirim.required' => 'Alamat email wajib diisi.',
            'email_pengirim.email' => 'Format email tidak valid.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'pesan.required' => 'Pesan tidak boleh kosong.',
            'pesan.min' => 'Pesan minimal terdiri dari 10 karakter.',
        ]);

        PesanMasuk::create($validated);

        return back()->with('sukses', 'Terima kasih! Pesan Anda telah berhasil terkirim kepada tim humas sekolah.');
    }

    // Legacy / Submenu Helpers
    public function kurikulum()
    {
        $halaman = Page::where('slug', 'kurikulum')->first();

        return view('public.pages.kurikulum', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function osis()
    {
        $halaman = Page::where('slug', 'osis')->first();

        return view('public.pages.osis', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function kalender()
    {
        return redirect()->route('tenant.agenda');
    }
}
