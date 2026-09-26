<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Page;
use App\Models\Tenant\PengaturanUmum;
use App\Models\Tenant\StrukturOrganisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil sekolah (Sejarah, Visi-Misi, Sambutan Kepsek, & Struktur Organisasi).
     */
    public function index(): View
    {
        $tenant = app('tenant');

        $sejarah = Page::where('slug', 'sejarah')->first();
        $visiMisi = Page::where('slug', 'visi-misi')->first();
        $struktur = StrukturOrganisasi::orderBy('urutan')->get();

        $namaKepsek = PengaturanUmum::ambil('nama_kepsek', 'Dr. H. Hasanudin, M.Pd.');
        $nipKepsek = PengaturanUmum::ambil('nip_kepsek', '19680512 199303 1 004');
        $fotoKepsek = PengaturanUmum::ambil('foto_kepsek', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop');
        $sambutanKepsek = PengaturanUmum::ambil('sambutan_kepsek', '');

        // Ekstraksi nilai terstruktur dari Visi & Misi
        $teksVisi = 'Menjadi Lembaga Pendidikan Kejuruan Terdepan Berdaya Saing Global, Berkarakter Pancasila, Berwawasan Lingkungan, dan Berbasis Industri Unggul pada Tahun 2030.';
        $poinMisi = "Menyelenggarakan kurikulum berbasis kompetensi industri dan teaching factory (TEFA) yang adaptif dan inovatif.\nMembina karakter peserta didik yang bertakwa, berintegritas, mandiri, dan berbudaya kerja profesional.\nMeningkatkan kualitas sumber daya pendidik dan tenaga kependidikan bersertifikasi kompetensi industri.\nMemperluas jejaring kemitraan strategis dengan Dunia Usaha, Dunia Industri, dan Dunia Kerja (DUDIKA) dalam dan luar negeri.\nMenyediakan sarana dan prasarana pembelajaran mutakhir yang ramah lingkungan dan inklusif.";
        $teksTujuan = 'Mencetak lulusan BMW: Bekerja di industri ternama dengan upah layak, Melanjutkan pendidikan tinggi vokasi/akademik, atau Berwirausaha mandiri berbasis teknologi (technopreneur).';

        if ($visiMisi && $visiMisi->isi_konten) {
            $raw = $visiMisi->isi_konten;
            if (preg_match('/<p[^>]*class="[^"]*font-semibold[^"]*"[^>]*>(.*?)<\/p>/is', $raw, $m)) {
                $teksVisi = trim(trim(strip_tags($m[1])), '"“”');
            } elseif (preg_match('/Visi Sekolah<\/h3>\s*<p[^>]*>(.*?)<\/p>/is', $raw, $m)) {
                $teksVisi = trim(trim(strip_tags($m[1])), '"“”');
            }
            if (preg_match('/<ul[^>]*>(.*?)<\/ul>/is', $raw, $m)) {
                preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $m[1], $lis);
                if (!empty($lis[1])) {
                    $poinMisi = implode("\n", array_map(fn($item) => trim(strip_tags($item)), $lis[1]));
                }
            }
            if (preg_match('/Tujuan Satuan Pendidikan<\/h3>\s*<p[^>]*>(.*?)<\/p>/is', $raw, $m)) {
                $teksTujuan = trim(strip_tags($m[1]));
            }
        }

        return view('tenant.admin.profil.index', compact(
            'tenant',
            'sejarah',
            'visiMisi',
            'struktur',
            'namaKepsek',
            'nipKepsek',
            'fotoKepsek',
            'sambutanKepsek',
            'teksVisi',
            'poinMisi',
            'teksTujuan'
        ));
    }

    /**
     * Simpan pembaruan konten Visi-Misi, Sejarah, dan Sambutan Kepala Sekolah.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_kepsek' => ['required', 'string', 'max:150'],
            'nip_kepsek' => ['nullable', 'string', 'max:100'],
            'foto_kepsek' => ['nullable', 'string', 'max:500'],
            'foto_kepsek_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'sambutan_kepsek' => ['nullable', 'string'],
            'sejarah_judul' => ['required', 'string', 'max:250'],
            'sejarah_konten' => ['required', 'string'],
            'sejarah_banner' => ['nullable', 'string', 'max:500'],
            'sejarah_banner_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'visimisi_judul' => ['required', 'string', 'max:250'],
            'teks_visi' => ['required', 'string', 'max:1000'],
            'poin_misi' => ['required', 'string'],
            'teks_tujuan' => ['nullable', 'string', 'max:1000'],
            'visimisi_banner' => ['nullable', 'string', 'max:500'],
            'visimisi_banner_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto_kepsek_file')) {
            $validated['foto_kepsek'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('foto_kepsek_file'), 'kepsek', 800);
        }
        if ($request->hasFile('sejarah_banner_file')) {
            $validated['sejarah_banner'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('sejarah_banner_file'), 'sejarah', 1600);
        }
        if ($request->hasFile('visimisi_banner_file')) {
            $validated['visimisi_banner'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('visimisi_banner_file'), 'visi-misi', 1600);
        }

        // Susun HTML terstruktur untuk Visi Misi tanpa perlu user ketik h3 atau tag list manual
        $visiHtml = '<h3>Visi Sekolah</h3><p class="text-lg font-semibold text-slate-800">"' . e($validated['teks_visi']) . '"</p>';
        
        $misiLines = array_filter(array_map('trim', explode("\n", $validated['poin_misi'])));
        $misiHtml = '<h3 class="mt-6">Misi Sekolah</h3><ul class="list-disc pl-5 space-y-2">';
        foreach ($misiLines as $misi) {
            $misiHtml .= '<li>' . e($misi) . '</li>';
        }
        $misiHtml .= '</ul>';

        $tujuanHtml = '';
        if (!empty($validated['teks_tujuan'])) {
            $tujuanHtml = '<h3 class="mt-6">Tujuan Satuan Pendidikan</h3><p>' . nl2br(e($validated['teks_tujuan'])) . '</p>';
        }

        $visimisiKontenFinal = $visiHtml . $misiHtml . $tujuanHtml;

        // Simpan data kepala sekolah
        PengaturanUmum::simpan('nama_kepsek', $validated['nama_kepsek']);
        PengaturanUmum::simpan('nip_kepsek', $validated['nip_kepsek'] ?? '');
        PengaturanUmum::simpan('foto_kepsek', $validated['foto_kepsek'] ?? '');
        PengaturanUmum::simpan('sambutan_kepsek', $validated['sambutan_kepsek'] ?? '');

        // Simpan Halaman Sejarah
        Page::updateOrCreate(
            ['slug' => 'sejarah'],
            [
                'judul' => $validated['sejarah_judul'],
                'isi_konten' => $validated['sejarah_konten'],
                'gambar_banner' => $validated['sejarah_banner'] ?? null,
            ]
        );

        // Simpan Halaman Visi & Misi
        Page::updateOrCreate(
            ['slug' => 'visi-misi'],
            [
                'judul' => $validated['visimisi_judul'],
                'isi_konten' => $visimisiKontenFinal,
                'gambar_banner' => $validated['visimisi_banner'] ?? null,
            ]
        );

        return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Konten profil sekolah (Visi-Misi, Sejarah, & Sambutan Kepala Sekolah) berhasil diperbarui.');
    }

    /**
     * Tambah anggota struktur organisasi.
     */
    public function storeStruktur(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'foto' => ['nullable', 'string', 'max:500'],
            'foto_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'urutan' => ['required', 'integer'],
        ]);

        if ($request->hasFile('foto_file')) {
            $validated['foto_file'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('foto_file'), 'struktur', 600);
            $validated['foto'] = $validated['foto_file'];
        }
        unset($validated['foto_file']);

        StrukturOrganisasi::create($validated);

        return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Anggota struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Hapus anggota struktur organisasi.
     */
    public function destroyStruktur(int $id): RedirectResponse
    {
        $tenant = app('tenant');

        $item = StrukturOrganisasi::findOrFail($id);
        $item->delete();

        return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Anggota struktur organisasi berhasil dihapus.');
    }
}
