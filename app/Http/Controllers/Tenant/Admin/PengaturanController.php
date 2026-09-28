<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\PengaturanUmum;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /**
     * Tampilkan formulir pengaturan identitas, kontak, medsos, dan tema sekolah.
     */
    public function index(): View
    {
        $tenant = app('tenant');

        // Ambil semua data pengaturan dalam key => value
        $pengaturanRaw = PengaturanUmum::all()->pluck('nilai', 'kunci')->toArray();

        // Data statistik otomatis dari database (mencegah duplikasi input manual)
        $countGuru = GuruStaf::count();
        $countJurusan = Jurusan::where('is_aktif', true)->count();

        return view('tenant.admin.pengaturan.index', compact('tenant', 'pengaturanRaw', 'countGuru', 'countJurusan'));
    }

    /**
     * Simpan perubahan pengaturan umum sekolah.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            // Identitas Pokok & Logo
            'nama_sekolah' => ['required', 'string', 'max:200'],
            'jenjang' => ['required', 'string', 'max:20'],
            'logo' => ['nullable', 'string', 'max:500'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:30'],
            'akreditasi' => ['nullable', 'string', 'max:50'],
            'tahun_berdiri' => ['nullable', 'string', 'max:10'],
            'deskripsi' => ['nullable', 'string'],
            // Kontak & Layanan
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'email_sekolah' => ['nullable', 'email', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'jam_layanan' => ['nullable', 'string', 'max:150'],
            'peta_embed' => ['nullable', 'string'],
            // Kepala Sekolah
            'nama_kepsek' => ['nullable', 'string', 'max:150'],
            'nip_kepsek' => ['nullable', 'string', 'max:100'],
            'foto_kepsek' => ['nullable', 'string', 'max:500'],
            'foto_kepsek_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'sambutan_kepsek' => ['nullable', 'string'],
            // Media Sosial Resmi
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            // Statistik
            'stat_guru' => ['nullable', 'string', 'max:10'],
            'stat_guru_label' => ['nullable', 'string', 'max:100'],
            'stat_siswa' => ['nullable', 'string', 'max:10'],
            'stat_siswa_label' => ['nullable', 'string', 'max:100'],
            'stat_rombel' => ['nullable', 'string', 'max:10'],
            'stat_rombel_label' => ['nullable', 'string', 'max:100'],
            'stat_kelas' => ['nullable', 'string', 'max:10'],
            'stat_kelas_label' => ['nullable', 'string', 'max:100'],
            'stat_jurusan' => ['nullable', 'string', 'max:10'],
            'stat_jurusan_label' => ['nullable', 'string', 'max:100'],
            'stat_mitra' => ['nullable', 'string', 'max:10'],
            'stat_mitra_label' => ['nullable', 'string', 'max:100'],
            'stat_sumber_label' => ['nullable', 'string', 'max:200'],
            // Tampilan & Tema
            'warna_tema' => ['nullable', 'string', 'max:30'],
            'warna_aksen' => ['nullable', 'string', 'max:30'],
        ]);

        if ($request->hasFile('logo_file')) {
            $validated['logo'] = ImageService::uploadAndConvertToWebp($request->file('logo_file'), 'logo', 600);
        }
        unset($validated['logo_file']);

        if ($request->hasFile('foto_kepsek_file')) {
            $validated['foto_kepsek'] = ImageService::uploadAndConvertToWebp($request->file('foto_kepsek_file'), 'kepsek', 600);
        }
        unset($validated['foto_kepsek_file']);

        foreach ($validated as $kunci => $nilai) {
            PengaturanUmum::simpan($kunci, $nilai);
        }

        return redirect()->route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Pengaturan informasi sekolah dan logo berhasil diperbarui.');
    }
}
