<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\PengaturanUmum;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /**
     * Tampilkan formulir pengaturan identitas pokok dan statistik sekolah.
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
     * Simpan perubahan pengaturan identitas pokok dan statistik sekolah.
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
            // Statistik Sekolah
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
            // Video Profil Sekolah (Link YouTube/Embed atau Upload Berkas Video)
            'video_profil' => ['nullable', 'string', 'max:500'],
            'video_profil_file' => ['nullable', 'mimes:mp4,webm,ogg', 'max:25600'],
            'video_profil_judul' => ['nullable', 'string', 'max:200'],
            'video_profil_deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('logo_file')) {
            $validated['logo'] = ImageService::uploadAndConvertToWebp($request->file('logo_file'), 'logo', 600);
        }
        unset($validated['logo_file']);

        if ($request->hasFile('video_profil_file')) {
            $videoFile = $request->file('video_profil_file');
            $filename = 'video-profil-'.time().'.'.$videoFile->getClientOriginalExtension();
            $path = $videoFile->storeAs('uploads/video', $filename, 'public');
            $validated['video_profil'] = Storage::url($path);
        }
        unset($validated['video_profil_file']);

        // Sinkronisasi nama sekolah dan jenjang ke entitas tenant pusat
        $tenant->update([
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang' => $validated['jenjang'],
        ]);

        foreach ($validated as $kunci => $nilai) {
            PengaturanUmum::simpan($kunci, $nilai);
        }

        return redirect()->route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Identitas pokok sekolah dan statistik beranda berhasil disimpan.');
    }
}
