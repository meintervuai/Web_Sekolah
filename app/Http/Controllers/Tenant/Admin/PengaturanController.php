<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\PengaturanUmum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /**
     * Halaman pengaturan tema dialihkan atau dibatasi karena tema dikelola eksklusif oleh Super Admin.
     */
    public function index(): RedirectResponse
    {
        $tenant = app('tenant');

        return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenant->slug])
            ->with('info', 'Pengaturan tema dan palet warna portal dikelola secara terpusat oleh Super Admin.');
    }

    /**
     * Mencegah pembaruan tema dari admin sekolah.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenant->slug])
            ->with('error', 'Akses ditolak: Konfigurasi tema hanya dapat diubah oleh Super Admin.');
    }
}
