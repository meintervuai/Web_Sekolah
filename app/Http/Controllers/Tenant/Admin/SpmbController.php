<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanFitur;
use App\Models\Tenant\PengaturanUmum;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpmbController extends Controller
{
    /**
     * Menampilkan dashboard manajemen SPMB / PPDB di Admin Panel.
     */
    public function index(Request $request): View
    {
        $tenant = app('tenant');
        $adminId = auth('tenant_admin')->id();

        // 1. Feature Flag Status
        $isFiturAktif = PengaturanFitur::isAktif('spmb', true);

        // 2. Data Halaman Statis SPMB (Hero Banner, Subjudul, Konten Kustom Tambahan)
        $halamanSpmb = Page::firstOrCreate(
            ['slug' => 'spmb'],
            [
                'judul' => 'Bergabung Bersama ' . $tenant->nama_sekolah,
                'subjudul' => 'Wujudkan cita-cita masa depanmu melalui pendidikan vokasi berkualitas, fasilitas teaching factory berstandar industri, dan jaringan kerja sama mitra DUDI nasional & internasional.',
                'gambar_banner' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop',
                'isi_konten' => '',
                'pengguna_id' => $adminId,
            ]
        );

        // 3. Konfigurasi SPMB dari Pengaturan Umum
        $spmbConfig = [
            'portal_nama' => PengaturanUmum::ambil('spmb_portal_nama', 'Portal PPDB Jawa Barat'),
            'portal_url' => PengaturanUmum::ambil('spmb_portal_url', 'https://ppdb.jabarprov.go.id'),
            'portal_deskripsi' => PengaturanUmum::ambil('spmb_portal_deskripsi', 'Seluruh pendaftaran dilaksanakan secara daring melalui sistem resmi Dinas Pendidikan Provinsi Jawa Barat.'),
            'portal_tombol' => PengaturanUmum::ambil('spmb_portal_tombol', 'Akses Portal PPDB Jabar'),
        ];

        // 4. Alur & Prosedur Pendaftaran Step-by-Step
        $alurListRaw = PengaturanUmum::ambil('spmb_alur_list', null);
        $alurList = $alurListRaw ? json_decode($alurListRaw, true) : [
            [
                'langkah' => 1,
                'judul' => 'Registrasi Akun PPDB Online',
                'deskripsi' => 'Siswa mendapatkan akun dari sekolah asal (SMP/MTs) dan login ke portal resmi PPDB Jawa Barat.',
            ],
            [
                'langkah' => 2,
                'judul' => 'Pemilihan Sekolah & Kompetensi Keahlian',
                'deskripsi' => 'Pilih ' . $tenant->nama_sekolah . ' dan tentukan prioritas Program Keahlian yang diminati.',
            ],
            [
                'langkah' => 3,
                'judul' => 'Unggah Berkas & Verifikasi Data',
                'deskripsi' => 'Upload dokumen persyaratan: KK, Akta Kelahiran, Nilai Rapor, Surat Sehat & Tidak Buta Warna (khusus jurusan keteknikan).',
            ],
            [
                'langkah' => 4,
                'judul' => 'Pengumuman & Daftar Ulang',
                'deskripsi' => 'Cek hasil seleksi secara online. Peserta yang dinyatakan lolos wajib melakukan daftar ulang di kampus sekolah.',
            ],
        ];

        // 5. Persyaratan Dokumen (WYSIWYG)
        $spmbSyaratKonten = PengaturanUmum::ambil('spmb_syarat_konten', null);
        if ($spmbSyaratKonten === null) {
            // Default template jika belum disetel
            $spmbSyaratKonten = '<ul>
<li>Ijazah SMP/MTs/Sederajat atau Surat Keterangan Lulus (SKL) asli.</li>
<li>Akta Kelahiran asli dan fotokopi legalisir.</li>
<li>Kartu Keluarga (KK) yang diterbitkan minimal 1 tahun sebelum tanggal pendaftaran.</li>
<li>Buku Rapor SMP/MTs semester 1 sampai semester 5.</li>
<li>Surat Keterangan Sehat dan Tidak Buta Warna dari dokter pemerintah/Puskesmas.</li>
<li>Surat Tanggung Jawab Mutlak (SPTJM) bermaterai dari orang tua/wali.</li>
</ul>';
        }

        return view('tenant.admin.spmb.index', compact(
            'halamanSpmb',
            'spmbConfig',
            'alurList',
            'spmbSyaratKonten',
            'isFiturAktif'
        ));
    }

    /**
     * Update Hero Banner & Subjudul Halaman SPMB.
     */
    public function updateHero(Request $request, MediaService $mediaService): RedirectResponse
    {
        $validated = $request->validate([
            'judul_halaman' => ['required', 'string', 'max:200'],
            'subjudul_halaman' => ['nullable', 'string', 'max:500'],
            'gambar_banner_spmb' => ['nullable', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();

        if (! empty($validated['gambar_banner_spmb'])) {
            $validated['gambar_banner_spmb'] = $mediaService->sinkronisasiOtomatisUrl(
                $validated['gambar_banner_spmb'],
                $adminId,
                'spmb',
                'Banner Hero SPMB PPDB'
            );
        }

        Page::updateOrCreate(
            ['slug' => 'spmb'],
            [
                'judul' => $validated['judul_halaman'],
                'subjudul' => $validated['subjudul_halaman'] ?? null,
                'gambar_banner' => $validated['gambar_banner_spmb'] ?? null,
                'pengguna_id' => $adminId,
            ]
        );

        return redirect()
            ->route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug, 'tab' => 'hero'])
            ->with('success', 'Pengaturan hero banner halaman SPMB & PPDB berhasil disimpan.');
    }

    /**
     * Update Alur & Prosedur Pendaftaran Step-by-Step.
     */
    public function updateAlur(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alur' => ['required', 'array'],
            'alur.*.langkah' => ['required', 'numeric', 'min:1'],
            'alur.*.judul' => ['required', 'string', 'max:150'],
            'alur.*.deskripsi' => ['required', 'string', 'max:500'],
        ]);

        $adminId = auth('tenant_admin')->id();

        PengaturanUmum::updateOrCreate(
            ['kunci' => 'spmb_alur_list'],
            [
                'nilai' => json_encode(array_values($validated['alur'])),
                'pengguna_id' => $adminId,
            ]
        );

        return redirect()
            ->route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug, 'tab' => 'alur'])
            ->with('success', 'Alur dan prosedur pendaftaran PPDB berhasil diperbarui.');
    }

    /**
     * Update Persyaratan Dokumen (WYSIWYG).
     */
    public function updateSyarat(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'syarat_konten' => ['nullable', 'string'],
        ]);

        $adminId = auth('tenant_admin')->id();

        PengaturanUmum::updateOrCreate(
            ['kunci' => 'spmb_syarat_konten'],
            [
                'nilai' => $validated['syarat_konten'] ?? '',
                'pengguna_id' => $adminId,
            ]
        );

        return redirect()
            ->route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug, 'tab' => 'syarat'])
            ->with('success', 'Persyaratan berkas dokumen pendaftaran PPDB berhasil disimpan.');
    }

    /**
     * Update Portal Pendaftaran Resmi (Eksternal).
     */
    public function updateSidebar(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'portal_nama' => ['required', 'string', 'max:150'],
            'portal_url' => ['required', 'url', 'max:255'],
            'portal_deskripsi' => ['nullable', 'string', 'max:500'],
            'portal_tombol' => ['nullable', 'string', 'max:100'],
        ]);

        $adminId = auth('tenant_admin')->id();

        $keys = [
            'portal_nama' => 'spmb_portal_nama',
            'portal_url' => 'spmb_portal_url',
            'portal_deskripsi' => 'spmb_portal_deskripsi',
            'portal_tombol' => 'spmb_portal_tombol',
        ];

        foreach ($keys as $field => $kunci) {
            if (array_key_exists($field, $validated)) {
                PengaturanUmum::updateOrCreate(
                    ['kunci' => $kunci],
                    [
                        'nilai' => $validated[$field],
                        'pengguna_id' => $adminId,
                    ]
                );
            }
        }

        return redirect()
            ->route('tenant.admin.spmb.index', ['tenant' => app('tenant')->slug, 'tab' => 'sidebar'])
            ->with('success', 'Informasi portal pendaftaran PPDB resmi berhasil disimpan.');
    }

    /**
     * Toggle status aktif fitur SPMB.
     */
    public function toggleStatus(Request $request): JsonResponse
    {
        $isAktif = $request->boolean('is_aktif');
        $adminId = auth('tenant_admin')->id();

        PengaturanFitur::updateOrCreate(
            ['kode_fitur' => 'spmb'],
            [
                'is_aktif' => $isAktif,
                'pengguna_id' => $adminId,
            ]
        );

        return response()->json([
            'success' => true,
            'is_aktif' => $isAktif,
            'message' => $isAktif ? 'Fitur SPMB / PPDB berhasil diaktifkan di portal publik.' : 'Fitur SPMB / PPDB berhasil dinonaktifkan dari portal publik.',
        ]);
    }
}
