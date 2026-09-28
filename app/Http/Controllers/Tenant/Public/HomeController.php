<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\Ekstrakurikuler;
use App\Models\Tenant\Fasilitas;
use App\Models\Tenant\GaleriItem;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\Menu;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\Post;
use App\Models\Tenant\PrestasiSiswa;
use App\Models\Tenant\SliderBeranda;

class HomeController extends Controller
{
    public function index()
    {
        $sekolah = app('tenant');

        if (! $sekolah) {
            abort(404, 'Tenant tidak ditemukan.');
        }

        // Format data sekolah
        $sekolahData = [
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
            'deskripsi' => PengaturanUmum::ambil('deskripsi', 'Website resmi '.$sekolah->nama_sekolah),
            'sambutan' => PengaturanUmum::ambil('sambutan_kepsek', 'Selamat datang di website resmi '.$sekolah->nama_sekolah.'.'),
            'kepsek' => PengaturanUmum::ambil('nama_kepsek', 'Dr. H. Hasanudin, M.Pd.'),
            'nip_kepsek' => PengaturanUmum::ambil('nip_kepsek', '19680512 199303 1 004'),
            'foto_kepsek' => PengaturanUmum::ambil('foto_kepsek', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop'),
            'logo' => PengaturanUmum::ambil('logo', ''),
            'warna_tema' => PengaturanUmum::ambil('warna_tema', '#1E3A8A'),
            'warna_aksen' => PengaturanUmum::ambil('warna_aksen', '#0284C7'),
            // Media Sosial Resmi
            'instagram' => PengaturanUmum::ambil('instagram', 'https://instagram.com/smkn2bandung'),
            'facebook' => PengaturanUmum::ambil('facebook', 'https://facebook.com/smkn2bandung'),
            'twitter' => PengaturanUmum::ambil('twitter', 'https://x.com/smkn2bandung'),
            'youtube' => PengaturanUmum::ambil('youtube', 'https://youtube.com/@smkn2bandung'),
            'tiktok' => PengaturanUmum::ambil('tiktok', 'https://tiktok.com/@smkn2bandung'),
            // Statistik Resmi
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
            'peta_embed' => PengaturanUmum::ambil('peta_embed', ''),
        ];

        // Status Fitur (Feature Flags)
        $fiturList = PengaturanFitur::all()->pluck('is_aktif', 'kode_fitur')->toArray();

        // 1. Slider Beranda
        $slider = SliderBeranda::aktif()->get();
        if ($slider->isEmpty()) {
            $slider = collect([
                (object) [
                    'gambar' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1600&auto=format&fit=crop',
                    'judul' => 'Mencetak Generasi Vokasi Berdaya Saing Global',
                    'subjudul' => 'SMK Negeri 2 Bandung memadukan kurikulum industri, teknologi modern, dan karakter Profil Pelajar Pancasila.',
                    'link_tombol' => '/spmb',
                    'teks_tombol' => 'Info SPMB 2026',
                ],
            ]);
        }

        // 2. Jurusan / Program Keahlian
        $jurusan = Jurusan::where('is_aktif', true)->orderBy('urutan')->get();

        // 3. Berita Terbaru (Non-pengumuman)
        $berita = Post::published()
            ->where('is_pengumuman', false)
            ->with('kategori')
            ->orderBy('tgl_publikasi', 'desc')
            ->take(3)
            ->get();

        // 4. Pengumuman Penting
        $pengumuman = Post::published()
            ->where('is_pengumuman', true)
            ->orderBy('tgl_publikasi', 'desc')
            ->take(4)
            ->get();

        // 5. Agenda Terdekat
        $agenda = Agenda::aktif()
            ->orderBy('tgl_mulai', 'asc')
            ->take(3)
            ->get();

        // 6. Prestasi Siswa
        $prestasi = PrestasiSiswa::orderBy('tanggal', 'desc')->take(4)->get();

        // 7. Ekstrakurikuler
        $ekskul = Ekstrakurikuler::aktif()->take(4)->get();

        // 8. Fasilitas
        $fasilitas = Fasilitas::aktif()->take(4)->get();

        // 9. Galeri Foto
        $galeri = GaleriItem::with('album')->orderBy('created_at', 'desc')->take(6)->get();

        // 10. Navigasi Menus
        $menus = Menu::whereNull('parent_id')
            ->where('is_aktif', true)
            ->with(['children' => function ($query) {
                $query->where('is_aktif', true)->orderBy('urutan');
            }])
            ->orderBy('urutan')
            ->get();

        $sekolah = $sekolahData;

        return view('public.home', compact(
            'sekolah',
            'sekolahData',
            'fiturList',
            'slider',
            'jurusan',
            'berita',
            'pengumuman',
            'agenda',
            'prestasi',
            'ekskul',
            'fasilitas',
            'galeri',
            'menus'
        ));
    }
}
