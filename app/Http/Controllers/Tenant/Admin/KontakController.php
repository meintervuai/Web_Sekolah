<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\PesanMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KontakController extends Controller
{
    /**
     * Tampilkan pengaturan kontak & medsos serta daftar pesan masuk.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');

        $kontakData = [
            'alamat' => PengaturanUmum::ambil('alamat', ''),
            'no_telepon' => PengaturanUmum::ambil('no_telepon', ''),
            'email_sekolah' => PengaturanUmum::ambil('email_sekolah', ''),
            'whatsapp' => PengaturanUmum::ambil('whatsapp', '081222333444'),
            'jam_layanan' => PengaturanUmum::ambil('jam_layanan', 'Senin - Jumat: 07.00 - 16.00 WIB'),
            'peta_embed' => PengaturanUmum::ambil('peta_embed', ''),
            'instagram' => PengaturanUmum::ambil('instagram', 'https://instagram.com/smkn2bandung'),
            'tiktok' => PengaturanUmum::ambil('tiktok', 'https://tiktok.com/@smkn2bandung'),
            'youtube' => PengaturanUmum::ambil('youtube', 'https://youtube.com/@smkn2bandung'),
            'facebook' => PengaturanUmum::ambil('facebook', 'https://facebook.com/smkn2bandung'),
            'twitter' => PengaturanUmum::ambil('twitter', 'https://x.com/smkn2bandung'),
        ];

        $pesanList = PesanMasuk::orderBy('created_at', 'desc')->paginate(10);
        $totalPesan = PesanMasuk::count();
        $pesanBelumDibaca = PesanMasuk::where('is_dibaca', false)->count();

        return view('tenant.admin.kontak.index', compact('tenant', 'kontakData', 'pesanList', 'totalPesan', 'pesanBelumDibaca'));
    }

    /**
     * Simpan pengaturan kontak & media sosial resmi.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'email_sekolah' => ['nullable', 'email', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'jam_layanan' => ['nullable', 'string', 'max:150'],
            'peta_embed' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $val) {
            PengaturanUmum::simpan($key, $val);
        }

        return redirect()->route('tenant.admin.kontak.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pengaturan kontak, layanan, dan media sosial resmi berhasil diperbarui.');
    }

    /**
     * Tandai pesan sudah dibaca.
     */
    public function toggleDibaca(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $pesan = PesanMasuk::findOrFail($id);
        $pesan->update(['is_dibaca' => ! $pesan->is_dibaca]);

        return redirect()->route('tenant.admin.kontak.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Status pesan berhasil diperbarui.');
    }

    /**
     * Hapus pesan masuk.
     */
    public function destroyPesan(int $id): RedirectResponse
    {
        $tenant = app('tenant');
        $pesan = PesanMasuk::findOrFail($id);
        $pesan->delete();

        return redirect()->route('tenant.admin.kontak.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pesan masuk berhasil dihapus.');
    }
}
