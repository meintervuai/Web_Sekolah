<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\PengaturanUmum;
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
        return view('public.pages.sejarah', ['sekolah' => $this->getSekolahData()]);
    }

    public function visiMisi()
    {
        return view('public.pages.visi-misi', ['sekolah' => $this->getSekolahData()]);
    }

    public function struktur()
    {
        return view('public.pages.struktur', ['sekolah' => $this->getSekolahData()]);
    }

    public function fasilitas()
    {
        return view('public.pages.fasilitas', ['sekolah' => $this->getSekolahData()]);
    }

    public function guru()
    {
        return view('public.pages.guru', ['sekolah' => $this->getSekolahData()]);
    }

    public function jurusan()
    {
        $jurusan = DB::connection('tenant')->table('jurusan')->where('is_aktif', true)->orderBy('urutan')->get();
        return view('public.pages.jurusan', ['sekolah' => $this->getSekolahData(), 'jurusan' => $jurusan]);
    }

    public function kurikulum()
    {
        return view('public.pages.kurikulum', ['sekolah' => $this->getSekolahData()]);
    }

    public function kalender()
    {
        return view('public.pages.kalender', ['sekolah' => $this->getSekolahData()]);
    }

    public function osis()
    {
        return view('public.pages.osis', ['sekolah' => $this->getSekolahData()]);
    }

    public function ekstrakurikuler()
    {
        return view('public.pages.ekstrakurikuler', ['sekolah' => $this->getSekolahData()]);
    }

    public function prestasi()
    {
        return view('public.pages.prestasi', ['sekolah' => $this->getSekolahData()]);
    }

    public function berita()
    {
        return view('public.pages.berita', ['sekolah' => $this->getSekolahData()]);
    }

    public function pengumuman()
    {
        return view('public.pages.pengumuman', ['sekolah' => $this->getSekolahData()]);
    }

    public function agenda()
    {
        return view('public.pages.agenda', ['sekolah' => $this->getSekolahData()]);
    }

    public function galeri()
    {
        return view('public.pages.galeri', ['sekolah' => $this->getSekolahData()]);
    }
}
