<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\PengaturanUmum;

class HomeController extends Controller
{
    public function index()
    {
        $sekolah = app('tenant');

        if (!$sekolah) {
            abort(404, 'Tenant tidak ditemukan.');
        }

        // Format data for the view using PengaturanUmum
        $sekolahData = [
            'nama' => PengaturanUmum::ambil('nama_sekolah', $sekolah->nama_sekolah),
            'jenjang' => $sekolah->jenjang,
            'slogan' => PengaturanUmum::ambil('slogan', $sekolah->jenjang === 'SMK' ? 'Sekolah Pusat Keunggulan' : 'Membangun Generasi Berprestasi'),
            'alamat' => PengaturanUmum::ambil('alamat', $sekolah->data['alamat'] ?? ''),
            'telepon' => PengaturanUmum::ambil('no_telepon', $sekolah->data['telepon'] ?? ''),
            'email' => PengaturanUmum::ambil('email_sekolah', $sekolah->data['email'] ?? ''),
            'deskripsi' => PengaturanUmum::ambil('deskripsi', 'Website resmi ' . $sekolah->nama_sekolah),
            'sambutan' => PengaturanUmum::ambil('sambutan_kepsek', 'Selamat datang di website resmi ' . $sekolah->nama_sekolah . '.'),
            'kepsek' => PengaturanUmum::ambil('nama_kepsek', 'Kepala Sekolah'),
            'foto_kepsek' => PengaturanUmum::ambil('foto_kepsek', ''),
            'logo' => PengaturanUmum::ambil('logo', ''),
            'warna_tema' => PengaturanUmum::ambil('warna_tema', '#4F46E5'),
            'stat_siswa' => PengaturanUmum::ambil('stat_siswa', '0'),
            'stat_guru' => PengaturanUmum::ambil('stat_guru', '0'),
            'stat_prestasi' => PengaturanUmum::ambil('stat_prestasi', '0'),
            'stat_alumni' => PengaturanUmum::ambil('stat_alumni', '0'),
        ];

        // Fetch from tenant database (fallback to empty arrays if tables are not fully populated)
        $slider = DB::connection('tenant')->table('slider_beranda')->where('is_aktif', true)->orderBy('urutan')->get();
        
        if ($slider->isEmpty()) {
            // Default slider if empty
            $slider = collect([
                (object)[
                    'gambar' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop',
                    'judul' => 'Generasi Vokasi Berprestasi',
                    'subjudul' => 'Membangun masa depan gemilang dengan keterampilan kompeten dan karakter kuat.',
                    'link_tombol' => '#',
                    'teks_tombol' => 'Jelajahi'
                ]
            ]);
        }

        $jurusan = DB::connection('tenant')->table('jurusan')->where('is_aktif', true)->orderBy('urutan')->get();
        $berita = DB::connection('tenant')->table('artikel')
                    ->where('status_publikasi', 'published')
                    ->orderBy('tgl_publikasi', 'desc')
                    ->take(3)
                    ->get();

        $menus = \App\Models\Tenant\Menu::whereNull('parent_id')
                    ->where('is_aktif', true)
                    ->with(['children' => function ($query) {
                        $query->where('is_aktif', true)->orderBy('urutan');
                    }])
                    ->orderBy('urutan')
                    ->get();

        $galeri = DB::connection('tenant')->table('galeri_item')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();

        return view('public.home', [
            'sekolah' => $sekolahData,
            'slider' => $slider,
            'jurusan' => $jurusan,
            'berita' => $berita,
            'menus' => $menus,
            'galeri' => $galeri
        ]);
    }
}
