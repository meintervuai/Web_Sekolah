<?php

namespace App\Http\Controllers\Tenant\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Dummy data based on the database schema requirements
        $sekolah = [
            'nama' => 'SMK Negeri 2 Bandung',
            'alamat' => 'Jl. Ciliwung No.4, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114',
            'telepon' => '(022) 7234285',
            'email' => 'info@smkn2bandung.sch.id',
            'deskripsi' => 'Sekolah Menengah Kejuruan Negeri 2 Bandung berkomitmen mencetak lulusan yang unggul, berkarakter, dan siap kerja di era industri 4.0.',
            'sambutan' => 'Selamat datang di website resmi SMK Negeri 2 Bandung. Kami terus berinovasi dalam memberikan pendidikan vokasi terbaik bagi putra-putri bangsa.',
            'kepsek' => 'Hasanudin, S.Pd., M.Pd.'
        ];

        $slider = [
            [
                'gambar' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop',
                'judul' => 'Generasi Vokasi Berprestasi',
                'subjudul' => 'Membangun masa depan gemilang dengan keterampilan kompeten dan karakter kuat.'
            ],
            [
                'gambar' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2086&auto=format&fit=crop',
                'judul' => 'Fasilitas Praktik Modern',
                'subjudul' => 'Didukung dengan laboratorium dan bengkel berstandar industri.'
            ]
        ];

        $jurusan = [
            ['nama' => 'Teknik Komputer dan Jaringan', 'ikon' => '🖥️', 'deskripsi' => 'Mempelajari perangkat keras, perakitan komputer, jaringan, dan keamanan siber.'],
            ['nama' => 'Rekayasa Perangkat Lunak', 'ikon' => '💻', 'deskripsi' => 'Fokus pada pengembangan aplikasi berbasis web, mobile, dan desktop.'],
            ['nama' => 'Teknik Mesin', 'ikon' => '⚙️', 'deskripsi' => 'Pembelajaran teknik pemesinan, CNC, dan perancangan manufaktur.'],
            ['nama' => 'Otomatisasi Tata Kelola Perkantoran', 'ikon' => '📄', 'deskripsi' => 'Administrasi bisnis, kearsipan digital, dan manajemen perkantoran.'],
        ];

        $berita = [
            ['judul' => 'Prestasi Juara 1 Lomba LKS Tingkat Provinsi', 'tanggal' => '12 Sep 2026', 'gambar' => 'https://images.unsplash.com/photo-1567168544813-cc03465b4fa8?q=80&w=800&auto=format&fit=crop'],
            ['judul' => 'Kunjungan Industri ke PT. Telkom Indonesia', 'tanggal' => '05 Sep 2026', 'gambar' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=800&auto=format&fit=crop'],
            ['judul' => 'Penerimaan Peserta Didik Baru (PPDB) 2026 Dibuka', 'tanggal' => '01 Sep 2026', 'gambar' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop'],
        ];

        return view('public.home', compact('sekolah', 'slider', 'jurusan', 'berita'));
    }
}
