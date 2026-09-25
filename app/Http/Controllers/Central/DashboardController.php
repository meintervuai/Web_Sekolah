<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan statistik dan monitoring tenant di dashboard Super Admin.
     */
    public function index(): View
    {
        $totalSekolah = Sekolah::count();
        $sekolahAktif = Sekolah::where('status_aktif', true)->count();
        $sekolahNonaktif = Sekolah::where('status_aktif', false)->count();
        $totalDomain = DomainSekolah::count();

        // Distribusi sekolah berdasarkan jenjang
        $jenjangCounts = Sekolah::selectRaw('jenjang, count(*) as total')
            ->groupBy('jenjang')
            ->pluck('total', 'jenjang')
            ->toArray();

        // Daftar 5 sekolah terbaru
        $sekolahTerbaru = Sekolah::with('domains')
            ->latest()
            ->take(5)
            ->get();

        return view('central.dashboard.index', compact(
            'totalSekolah',
            'sekolahAktif',
            'sekolahNonaktif',
            'totalDomain',
            'jenjangCounts',
            'sekolahTerbaru'
        ));
    }
}
