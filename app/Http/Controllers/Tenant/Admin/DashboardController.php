<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Agenda;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\PesanMasuk;
use App\Models\Tenant\Post;
use App\Models\Tenant\PrestasiSiswa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan metrik dan status CMS Sekolah.
     */
    public function index(): View
    {
        $tenant = app('tenant');

        // Statistik Konten
        $stat = [
            'total_berita' => Post::where('is_pengumuman', false)->count(),
            'total_pengumuman' => Post::where('is_pengumuman', true)->count(),
            'total_jurusan' => Jurusan::count(),
            'total_guru' => GuruStaf::count(),
            'total_agenda' => Agenda::count(),
            'total_prestasi' => PrestasiSiswa::count(),
            'pesan_belum_dibaca' => PesanMasuk::where('is_dibaca', false)->count(),
        ];

        // 5 Pesan Terkini
        $pesanTerbaru = PesanMasuk::latest()->take(5)->get();

        // 5 Artikel Terkini
        $artikelTerbaru = Post::with('kategori')->latest('tgl_publikasi')->take(5)->get();

        return view('tenant.admin.dashboard.index', compact('tenant', 'stat', 'pesanTerbaru', 'artikelTerbaru'));
    }
}
