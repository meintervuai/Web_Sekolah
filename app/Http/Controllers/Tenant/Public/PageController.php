<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Page;
use App\Models\Tenant\Post;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    private function getSekolahData()
    {
        $sekolah = app('tenant');
        return [
            'nama' => PengaturanUmum::ambil('nama_sekolah', $sekolah->nama_sekolah),
            'jenjang' => $sekolah->jenjang,
            'alamat' => PengaturanUmum::ambil('alamat', $sekolah->data['alamat'] ?? ''),
            'telepon' => PengaturanUmum::ambil('no_telepon', $sekolah->data['telepon'] ?? ''),
            'email' => PengaturanUmum::ambil('email_sekolah', $sekolah->data['email'] ?? ''),
            'logo' => PengaturanUmum::ambil('logo', ''),
            'warna_tema' => PengaturanUmum::ambil('warna_tema', '#4F46E5'),
        ];
    }

    public function sejarah()
    {
        $halaman = Page::where('slug', 'sejarah')->first();
        return view('public.pages.sejarah', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function visiMisi()
    {
        $halaman = Page::where('slug', 'visi-misi')->first();
        return view('public.pages.visi-misi', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function struktur()
    {
        $struktur = DB::connection('tenant')->table('struktur_organisasi')->orderBy('urutan')->get();
        return view('public.pages.struktur', ['sekolah' => $this->getSekolahData(), 'struktur' => $struktur]);
    }

    public function fasilitas()
    {
        $fasilitas = DB::connection('tenant')->table('fasilitas')->where('is_aktif', true)->get();
        return view('public.pages.fasilitas', ['sekolah' => $this->getSekolahData(), 'fasilitas' => $fasilitas]);
    }

    public function guru()
    {
        $guru = DB::connection('tenant')->table('guru_staf')->where('status_aktif', true)->get();
        return view('public.pages.guru', ['sekolah' => $this->getSekolahData(), 'guru' => $guru]);
    }

    public function jurusan()
    {
        $jurusan = DB::connection('tenant')->table('jurusan')->where('is_aktif', true)->orderBy('urutan')->get();
        return view('public.pages.jurusan', ['sekolah' => $this->getSekolahData(), 'jurusan' => $jurusan]);
    }

    public function detailJurusan($slug)
    {
        $jurusan = DB::connection('tenant')->table('jurusan')->where('slug', $slug)->first();
        if (!$jurusan) {
            abort(404);
        }
        return view('public.pages.jurusan_detail', ['sekolah' => $this->getSekolahData(), 'jurusan' => $jurusan]);
    }

    public function kurikulum()
    {
        $halaman = Page::where('slug', 'kurikulum')->first();
        return view('public.pages.kurikulum', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function kalender()
    {
        $kalender = DB::connection('tenant')->table('kalender_akademik')->orderBy('tgl_mulai')->get();
        $file_ganjil = PengaturanUmum::ambil('file_kalender_ganjil', null);
        $file_genap = PengaturanUmum::ambil('file_kalender_genap', null);
        
        return view('public.pages.kalender', [
            'sekolah' => $this->getSekolahData(),
            'kalender' => $kalender,
            'file_ganjil' => $file_ganjil,
            'file_genap' => $file_genap,
        ]);
    }

    public function berita()
    {
        $berita = Post::where('is_pengumuman', false)
            ->where('status_publikasi', 'published')
            ->orderBy('tgl_publikasi', 'desc')
            ->get();
        return view('public.pages.berita', ['sekolah' => $this->getSekolahData(), 'berita' => $berita]);
    }

    public function pengumuman()
    {
        $pengumuman = Post::where('is_pengumuman', true)
            ->where('status_publikasi', 'published')
            ->orderBy('tgl_publikasi', 'desc')
            ->get();
        return view('public.pages.pengumuman', ['sekolah' => $this->getSekolahData(), 'pengumuman' => $pengumuman]);
    }


    public function galeri()
    {
        $album = DB::connection('tenant')->table('galeri_album')->get();
        return view('public.pages.galeri', ['sekolah' => $this->getSekolahData(), 'album' => $album]);
    }

    public function ekstrakurikuler()
    {
        $ekstrakurikuler = DB::connection('tenant')->table('ekstrakurikuler')->where('is_aktif', true)->get();
        return view('public.pages.ekstrakurikuler', ['sekolah' => $this->getSekolahData(), 'ekstrakurikuler' => $ekstrakurikuler]);
    }

    public function prestasi()
    {
        $prestasi = DB::connection('tenant')->table('prestasi_siswa')->orderBy('tanggal', 'desc')->get();
        return view('public.pages.prestasi', ['sekolah' => $this->getSekolahData(), 'prestasi' => $prestasi]);
    }

    public function osis()
    {
        $halaman = Page::where('slug', 'osis')->first();
        return view('public.pages.osis', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }

    public function ppdb()
    {
        $halaman = Page::where('slug', 'ppdb')->first();
        return view('public.pages.ppdb', ['sekolah' => $this->getSekolahData(), 'halaman' => $halaman]);
    }
}
