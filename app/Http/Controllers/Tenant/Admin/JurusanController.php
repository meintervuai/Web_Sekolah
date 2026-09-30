<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\GuruStaf;
use App\Models\Tenant\Jurusan;
use App\Models\Tenant\Menu;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JurusanController extends Controller
{
    /**
     * Menampilkan dashboard manajemen Program Keahlian / Jurusan.
     */
    public function index(Request $request): View
    {
        $sekolah = app('tenant');

        // 1. Data Halaman Statis Hero Banner Program Keahlian
        $halamanJurusan = Page::firstOrCreate(
            ['slug' => 'program-keahlian'],
            [
                'judul' => 'Program Keahlian Unggulan',
                'subjudul' => 'SMK Negeri 2 Bandung menyelenggarakan 7 konsentrasi keahlian di bidang teknologi dan rekayasa dengan fasilitas modern dan kemitraan puluhan industri terkemuka.',
                'gambar_banner' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => auth('tenant_admin')->id(),
            ]
        );

        // 2. Daftar Program Keahlian / Jurusan dengan Relasi Kepala Program (Guru & Staf) dan Galeri Foto
        $jurusanList = Jurusan::with(['kepalaProgram', 'fotos'])
            ->orderBy('urutan')
            ->get();

        // 3. Daftar Guru & Staf untuk Dropdown Kepala Program Keahlian
        $guruList = GuruStaf::where('status_aktif', true)
            ->orderBy('nama_lengkap')
            ->get();

        // 4. Feature Flag Status
        $isFiturAktif = PengaturanFitur::isAktif('program_keahlian', true);

        return view('tenant.admin.jurusan.index', compact(
            'halamanJurusan',
            'jurusanList',
            'guruList',
            'isFiturAktif'
        ));
    }

    /**
     * Simpan kustomisasi hero banner halaman Program Keahlian publik.
     */
    public function updateHero(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'judul_halaman' => ['required', 'string', 'max:200'],
            'subjudul_halaman' => ['nullable', 'string', 'max:500'],
            'gambar_banner_jurusan' => ['nullable', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['gambar_banner_jurusan'])) {
            $validated['gambar_banner_jurusan'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['gambar_banner_jurusan'],
                $adminId,
                'jurusan',
                'Banner Hero Program Keahlian'
            );
        }

        Page::updateOrCreate(
            ['slug' => 'program-keahlian'],
            [
                'judul' => $validated['judul_halaman'],
                'subjudul' => $validated['subjudul_halaman'] ?? null,
                'gambar_banner' => $validated['gambar_banner_jurusan'] ?? null,
                'pengguna_id' => $adminId,
            ]
        );

        return redirect()
            ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'hero'])
            ->with('success', 'Pengaturan hero banner halaman Program Keahlian berhasil disimpan.');
    }

    /**
     * Tambah data Program Keahlian / Jurusan baru.
     */
    public function store(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:150'],
            'singkatan' => ['nullable', 'string', 'max:20'],
            'logo' => ['nullable', 'string', 'max:500'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:tenant.jurusan,slug'],
            'guru_id' => ['nullable', 'exists:tenant.guru_staf,id'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'informasi_tambahan' => ['nullable', 'string'],
            'ikon_atau_foto' => ['nullable', 'string', 'max:500'],
            'jenjang' => ['nullable', 'string', 'max:50'],
            'peluang_kerja' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'galeri_foto' => ['nullable', 'array'],
            'galeri_foto.*' => ['nullable', 'string', 'max:500'],
            'galeri_judul' => ['nullable', 'array'],
            'galeri_judul.*' => ['nullable', 'string', 'max:150'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_jurusan']);
        }

        // Pastikan slug unik
        $baseSlug = $validated['slug'];
        $count = 1;
        while (Jurusan::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$baseSlug}-{$count}";
            $count++;
        }

        if (! empty($validated['logo'])) {
            $validated['logo'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['logo'],
                $adminId,
                'jurusan',
                'Logo ' . $validated['nama_jurusan']
            );
        }

        if (! empty($validated['ikon_atau_foto'])) {
            $validated['ikon_atau_foto'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['ikon_atau_foto'],
                $adminId,
                'jurusan',
                'Foto ' . $validated['nama_jurusan']
            );
        }

        $validated['urutan'] = $validated['urutan'] ?? (Jurusan::max('urutan') + 1);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $jurusan = Jurusan::create($validated);

        // Simpan galeri multi-foto
        if ($request->has('galeri_foto') && is_array($request->input('galeri_foto'))) {
            foreach ($request->input('galeri_foto') as $idx => $fotoUrl) {
                if (! empty($fotoUrl)) {
                    $fotoClean = $mediaService->sinkronisasiOtomatisUrl(
                        $fotoUrl,
                        $adminId,
                        'jurusan',
                        'Dokumentasi ' . $validated['nama_jurusan']
                    );
                    $judulFoto = $request->input("galeri_judul.{$idx}") ?? null;
                    $jurusan->fotos()->create([
                        'file_foto' => $fotoClean,
                        'judul' => $judulFoto,
                        'urutan' => $idx + 1,
                    ]);
                }
            }
        }

        return redirect()
            ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'jurusan'])
            ->with('success', "Program Keahlian {$validated['nama_jurusan']} berhasil ditambahkan.");
    }

    /**
     * Update data Program Keahlian / Jurusan.
     */
    public function update(Request $request, Jurusan $jurusan, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jurusan' => ['required', 'string', 'max:150'],
            'singkatan' => ['nullable', 'string', 'max:20'],
            'logo' => ['nullable', 'string', 'max:500'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:tenant.jurusan,slug,' . $jurusan->id],
            'guru_id' => ['nullable', 'exists:tenant.guru_staf,id'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'informasi_tambahan' => ['nullable', 'string'],
            'ikon_atau_foto' => ['nullable', 'string', 'max:500'],
            'jenjang' => ['nullable', 'string', 'max:50'],
            'peluang_kerja' => ['nullable', 'string', 'max:255'],
            'sertifikasi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_aktif' => ['nullable', 'boolean'],
            'galeri_foto' => ['nullable', 'array'],
            'galeri_foto.*' => ['nullable', 'string', 'max:500'],
            'galeri_judul' => ['nullable', 'array'],
            'galeri_judul.*' => ['nullable', 'string', 'max:150'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_jurusan']);
        }

        if (! empty($validated['logo'])) {
            $validated['logo'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['logo'],
                $adminId,
                'jurusan',
                'Logo ' . $validated['nama_jurusan']
            );
        }

        if (! empty($validated['ikon_atau_foto'])) {
            $validated['ikon_atau_foto'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['ikon_atau_foto'],
                $adminId,
                'jurusan',
                'Foto ' . $validated['nama_jurusan']
            );
        }

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $jurusan->update($validated);

        // Sinkronisasi galeri multi-foto
        $jurusan->fotos()->delete();
        if ($request->has('galeri_foto') && is_array($request->input('galeri_foto'))) {
            foreach ($request->input('galeri_foto') as $idx => $fotoUrl) {
                if (! empty($fotoUrl)) {
                    $fotoClean = $mediaService->sinkronisasiOtomatisUrl(
                        $fotoUrl,
                        $adminId,
                        'jurusan',
                        'Dokumentasi ' . $validated['nama_jurusan']
                    );
                    $judulFoto = $request->input("galeri_judul.{$idx}") ?? null;
                    $jurusan->fotos()->create([
                        'file_foto' => $fotoClean,
                        'judul' => $judulFoto,
                        'urutan' => $idx + 1,
                    ]);
                }
            }
        }

        return redirect()
            ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'jurusan'])
            ->with('success', "Program Keahlian {$jurusan->nama_jurusan} berhasil diperbarui.");
    }

    /**
     * Hapus data Program Keahlian / Jurusan.
     */
    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        $nama = $jurusan->nama_jurusan;
        $jurusan->delete();

        return redirect()
            ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'jurusan'])
            ->with('success', "Program Keahlian {$nama} berhasil dihapus.");
    }

    /**
     * Toggle sakelar visibilitas fitur Program Keahlian atau per jurusan (AJAX/Form).
     */
    public function toggleStatus(Request $request): JsonResponse|RedirectResponse
    {
        $adminId = auth('tenant_admin')->id();
        $targetType = $request->input('target_type', 'fitur'); // 'fitur' atau 'jurusan'

        if ($targetType === 'jurusan') {
            $jurusanId = $request->input('jurusan_id');
            $jurusan = Jurusan::findOrFail($jurusanId);
            $newStatus = $request->has('is_aktif') ? $request->boolean('is_aktif') : ! $jurusan->is_aktif;
            $jurusan->update(['is_aktif' => $newStatus]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Status Program Keahlian {$jurusan->nama_jurusan} berhasil diubah.",
                    'is_aktif' => $newStatus,
                ]);
            }

            return redirect()
                ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'jurusan'])
                ->with('success', "Status {$jurusan->nama_jurusan} berhasil diubah.");
        }

        // Toggle Feature Flag 'program_keahlian'
        $isAktif = $request->has('is_aktif')
            ? $request->boolean('is_aktif')
            : ! PengaturanFitur::isAktif('program_keahlian', true);

        DB::connection('tenant')->transaction(function () use ($isAktif, $adminId) {
            PengaturanFitur::updateOrCreate(
                ['kode_fitur' => 'program_keahlian'],
                [
                    'nama_fitur' => 'Program Keahlian / Jurusan',
                    'is_aktif' => $isAktif,
                    'pengguna_id' => $adminId,
                ]
            );

            // Sinkronkan status menu navigasi Program Keahlian di tabel menus
            Menu::where(function ($q) {
                $q->where('url', '/program-keahlian')
                    ->orWhere('url', 'program-keahlian')
                    ->orWhere('name', 'like', '%Program Keahlian%')
                    ->orWhere('name', 'like', '%Jurusan%');
            })->update(['is_aktif' => $isAktif]);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Visibilitas Menu & Rute Program Keahlian berhasil diubah menjadi ' . ($isAktif ? 'Aktif (Tampil)' : 'Nonaktif (Sembunyi)'),
                'is_aktif' => $isAktif,
            ]);
        }

        return redirect()
            ->route('tenant.admin.jurusan.index', ['tenant' => app('tenant')->slug, 'tab' => 'visibilitas'])
            ->with('success', 'Status visibilitas Program Keahlian berhasil diperbarui.');
    }
}
