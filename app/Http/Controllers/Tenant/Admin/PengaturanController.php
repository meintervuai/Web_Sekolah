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
     * Tampilkan formulir pengaturan tema dan palet warna portal sekolah.
     */
    public function index(): View
    {
        $tenant = app('tenant');

        // Ambil seluruh konfigurasi tampilan dalam bentuk key => value
        $pengaturanRaw = PengaturanUmum::all()->pluck('nilai', 'kunci')->toArray();

        return view('tenant.admin.pengaturan.index', compact('tenant', 'pengaturanRaw'));
    }

    /**
     * Simpan perubahan tema dan palet warna portal sekolah.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        // 13 kunci warna tema: identitas, tipografi, latar, garis, tombol, header & footer
        $kunciWarna = [
            'warna_tema',
            'warna_aksen',
            'warna_judul',
            'warna_teks',
            'warna_teks_sekunder',
            'warna_latar_halaman',
            'warna_latar_section',
            'warna_kartu',
            'warna_border',
            'warna_tombol',
            'warna_tombol_teks',
            'warna_header',
            'warna_footer',
        ];

        $aturan = ['skema_tema' => ['nullable', 'string', 'max:50']];

        foreach ($kunciWarna as $kunci) {
            $aturan[$kunci] = ['nullable', 'string', 'max:25'];
        }

        $validated = $request->validate($aturan, [
            'skema_tema.max' => 'Nama skema tema maksimal 50 karakter.',
        ]);

        foreach ($validated as $kunci => $nilai) {
            PengaturanUmum::simpan($kunci, $nilai);
        }

        return redirect()->route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Tema dan palet warna portal sekolah berhasil disimpan.');
    }
}
