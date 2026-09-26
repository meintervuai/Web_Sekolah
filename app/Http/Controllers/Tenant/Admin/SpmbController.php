<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpmbController extends Controller
{
    /**
     * Tampilkan form pengaturan halaman SPMB / PPDB.
     */
    public function index(): View
    {
        $tenant = app('tenant');
        $spmb = Page::where('slug', 'spmb')->first();

        // Ekstraksi nilai terstruktur dari teks yang ada jika sudah tersimpan
        $pengantar = '';
        $jalurTahap1 = "Tahap 1: Jalur Afirmasi (KETM), Prioritas Terdekat (Zonasi), dan Perpindahan Tugas Orang Tua/Wali.";
        $jalurTahap2 = "Tahap 2: Jalur Prestasi Nilai Rapor Umum dan Jalur Prestasi Kejuaraan (Akademik/Non-Akademik).";
        $persyaratanUmum = "Lulus SMP/MTs sederajat tahun 2026 atau lulusan 2025 yang belum terdaftar di SMA/SMK.\nBerusia maksimal 21 tahun per 1 Juli 2026.\nMemiliki Ijazah / Surat Keterangan Lulus (SKL) dan Akta Kelahiran.\nTidak buta warna untuk program keahlian Teknik Mesin, TPFL, TJKT, DKV, dan Animasi.";
        $portalUrl = "https://ppdb.jabarprov.go.id";

        if ($spmb && $spmb->isi_konten) {
            $raw = $spmb->isi_konten;
            // Jika ada pengantar
            if (preg_match('/<p>(.*?)<\/p>/is', $raw, $m)) {
                $pengantar = trim(strip_tags($m[1]));
            }
            if (preg_match('/href="([^"]+)"/i', $raw, $m)) {
                $portalUrl = $m[1];
            }
            // Parse jalur
            if (preg_match('/Tahap 1:(.*?)(?:<\/li>|\n)/i', $raw, $m)) {
                $jalurTahap1 = 'Tahap 1:' . trim(strip_tags($m[1]));
            }
            if (preg_match('/Tahap 2:(.*?)(?:<\/li>|\n)/i', $raw, $m)) {
                $jalurTahap2 = 'Tahap 2:' . trim(strip_tags($m[1]));
            }
            // Parse persyaratan
            if (preg_match('/<ul[^>]*>(.*?)<\/ul>/is', $raw, $m)) {
                preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $m[1], $lis);
                if (!empty($lis[1])) {
                    $persyaratanUmum = implode("\n", array_map(fn($item) => trim(strip_tags($item)), $lis[1]));
                }
            }
        }

        return view('tenant.admin.spmb.index', compact(
            'tenant', 
            'spmb', 
            'pengantar', 
            'jalurTahap1', 
            'jalurTahap2', 
            'persyaratanUmum', 
            'portalUrl'
        ));
    }

    /**
     * Simpan pembaruan informasi halaman SPMB / PPDB.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'pengantar' => ['nullable', 'string', 'max:1000'],
            'jalur_tahap_1' => ['required', 'string', 'max:500'],
            'jalur_tahap_2' => ['required', 'string', 'max:500'],
            'persyaratan_umum' => ['required', 'string'],
            'portal_url' => ['nullable', 'url', 'max:255'],
            'gambar_banner' => ['nullable', 'string', 'max:500'],
            'gambar_banner_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar_banner_file')) {
            $validated['gambar_banner'] = \App\Services\ImageService::uploadAndConvertToWebp($request->file('gambar_banner_file'), 'spmb', 1600);
        }

        // Susun HTML secara otomatis dari input terstruktur, tanpa memaksa pengguna mengetik h3/ol/ul
        $pengantarHtml = !empty($validated['pengantar']) 
            ? '<p>' . nl2br(e($validated['pengantar'])) . '</p>' 
            : '<p>Penerimaan Peserta Didik Baru (PPDB) SMK Negeri 2 Bandung dilaksanakan secara objektif, transparan, dan akuntabel sesuai Petunjuk Teknis Dinas Pendidikan Provinsi Jawa Barat.</p>';

        $jalurHtml = '<h3>Jalur Penerimaan</h3><ol class="list-decimal pl-5 space-y-2">';
        $jalurHtml .= '<li>' . e($validated['jalur_tahap_1']) . '</li>';
        $jalurHtml .= '<li>' . e($validated['jalur_tahap_2']) . '</li>';
        $jalurHtml .= '</ol>';

        $syaratLines = array_filter(array_map('trim', explode("\n", $validated['persyaratan_umum'])));
        $syaratHtml = '<h3 class="mt-6">Persyaratan Umum</h3><ul class="list-disc pl-5 space-y-1">';
        foreach ($syaratLines as $syarat) {
            $syaratHtml .= '<li>' . e($syarat) . '</li>';
        }
        $syaratHtml .= '</ul>';

        $portalLink = $validated['portal_url'] ?: 'https://ppdb.jabarprov.go.id';
        $portalHtml = '<p class="mt-4">Pendaftaran resmi dapat diakses melalui portal Disdik Jabar: <a href="' . e($portalLink) . '" target="_blank" class="text-indigo-600 underline font-semibold">' . e($portalLink) . '</a></p>';

        $isiKontenFinal = $pengantarHtml . $jalurHtml . $syaratHtml . $portalHtml;

        Page::updateOrCreate(
            ['slug' => 'spmb'],
            [
                'judul' => $validated['judul'],
                'isi_konten' => $isiKontenFinal,
                'gambar_banner' => $validated['gambar_banner'] ?? null,
            ]
        );

        return redirect()->route('tenant.admin.spmb.index', ['tenant' => $tenant->slug])
            ->with('sukses', 'Informasi & Petunjuk Teknis SPMB berhasil diperbarui.');
    }
}
