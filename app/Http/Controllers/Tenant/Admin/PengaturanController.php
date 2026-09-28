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
            'hero_banner' => ['nullable', 'string', 'max:500'],
            'hero_banner_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'hero_banner_video' => ['nullable', 'string', 'max:500'],
            'hero_banner_video_file' => ['nullable', 'mimes:mp4,webm,ogg', 'max:25600'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:30'],
            'akreditasi' => ['nullable', 'string', 'max:50'],
            'tahun_berdiri' => ['nullable', 'string', 'max:10'],
            'deskripsi' => ['nullable', 'string'],
            // Pengaturan Tema & Palet Warna Mandiri
            'skema_tema' => ['nullable', 'string', 'max:50'],
            'warna_tema' => ['nullable', 'string', 'max:25'],
            'warna_aksen' => ['nullable', 'string', 'max:25'],
            'warna_teks' => ['nullable', 'string', 'max:25'],
            'warna_kartu' => ['nullable', 'string', 'max:25'],
            'warna_tombol' => ['nullable', 'string', 'max:25'],
            'warna_tombol_teks' => ['nullable', 'string', 'max:25'],
            'warna_header' => ['nullable', 'string', 'max:25'],
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
        } elseif (empty($validated['logo'])) {
            // Jika tidak upload file baru dan input URL kosong, pertahankan logo yang sudah ada sebelumnya
            $existingLogo = PengaturanUmum::ambil('logo') ?: ($tenant->data['logo'] ?? null);
            if (! empty($existingLogo)) {
                $validated['logo'] = $existingLogo;
            }
        }
        unset($validated['logo_file']);

        if ($request->hasFile('hero_banner_file')) {
            $validated['hero_banner'] = ImageService::uploadAndConvertToWebp($request->file('hero_banner_file'), 'hero_banner', 1600);
        } elseif (empty($validated['hero_banner'])) {
            $existingBanner = PengaturanUmum::ambil('hero_banner');
            if (! empty($existingBanner)) {
                $validated['hero_banner'] = $existingBanner;
            }
        }
        unset($validated['hero_banner_file']);

        if ($request->hasFile('hero_banner_video_file')) {
            $bannerVidFile = $request->file('hero_banner_video_file');
            $vidFilename = 'hero-banner-video-'.time().'.'.$bannerVidFile->getClientOriginalExtension();
            $vidPath = $bannerVidFile->storeAs('uploads/video', $vidFilename, 'public');
            $validated['hero_banner_video'] = Storage::url($vidPath);
        } elseif (empty($validated['hero_banner_video'])) {
            $existingBannerVid = PengaturanUmum::ambil('hero_banner_video');
            if (! empty($existingBannerVid)) {
                $validated['hero_banner_video'] = $existingBannerVid;
            }
        }
        unset($validated['hero_banner_video_file']);

        if ($request->hasFile('video_profil_file')) {
            $videoFile = $request->file('video_profil_file');
            $filename = 'video-profil-'.time().'.'.$videoFile->getClientOriginalExtension();
            $path = $videoFile->storeAs('uploads/video', $filename, 'public');
            $validated['video_profil'] = Storage::url($path);
        } elseif (empty($validated['video_profil'])) {
            $existingVideo = PengaturanUmum::ambil('video_profil');
            if (! empty($existingVideo)) {
                $validated['video_profil'] = $existingVideo;
            }
        }
        unset($validated['video_profil_file']);

        // Sinkronisasi nama sekolah, jenjang, dan logo ke entitas tenant pusat
        $tenantData = $tenant->data ?? [];
        if (! empty($validated['logo'])) {
            $tenantData['logo'] = $validated['logo'];
        }

        $tenant->update([
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang' => $validated['jenjang'],
            'data' => $tenantData,
        ]);

        foreach ($validated as $kunci => $nilai) {
            PengaturanUmum::simpan($kunci, $nilai);
        }

        return redirect()->route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Identitas pokok sekolah dan statistik beranda berhasil disimpan.');
    }
}
