<?php

namespace App\Support;

/**
 * Kontras WCAG 2.1 untuk auto-contrast teks portal sekolah.
 *
 * Prinsip: teks pada suatu latar harus tetap terbaca. Jika warna teks
 * pilihan panel (warna_judul/warna_teks/warna_tombol_teks) kontrasnya
 * memadai (>= 4.5:1) terhadap latarnya, warna itu dipertahankan.
 * Jika tidak, sistem memilih warna kandidat dengan kontras terbaik
 * (putih atau tinta gelap) sehingga tidak ada teks "nabrak" latarnya.
 */
class WarnaKontras
{
    /** Ambang minimum kontras teks normal menurut WCAG AA. */
    public const MIN_KONTRAS = 4.5;

    /** Kandidat cadangan bila warna panel gagal kontras. */
    public const PUTIH = '#FFFFFF';

    public const TINTA = '#0F172A';

    /**
     * Relative luminance (WCAG 2.1) dari warna hex #RGB/#RRGGBB.
     */
    public static function luminans(string $hex): float
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return 1.0; // anggap terang bila format tak dikenal
        }

        $kanal = [];

        for ($i = 0; $i < 3; $i++) {
            $c = hexdec(substr($hex, $i * 2, 2)) / 255;
            $kanal[] = $c <= 0.03928
                ? $c / 12.92
                : (($c + 0.055) / 1.055) ** 2.4;
        }

        return 0.2126 * $kanal[0] + 0.7152 * $kanal[1] + 0.0722 * $kanal[2];
    }

    /**
     * Rasio kontras WCAG antara dua warna (1..21).
     */
    public static function rasio(string $a, string $b): float
    {
        $la = self::luminans($a);
        $lb = self::luminans($b);

        $terang = max($la, $lb);
        $gelap = min($la, $lb);

        return ($terang + 0.05) / ($gelap + 0.05);
    }

    /**
     * Pilih warna teks terbaik untuk latar $bg.
     *
     * Urutan preferensi:
     * 1. $pilihanPanel jika kontrasnya >= $min (menghormati
     *    kustomisasi admin ketika tetap terbaca);
     * 2. kandidat lain dengan kontras tertinggi (argmax), tie-break
     *    mengikuti urutan kandidat; default argmax putih vs tinta.
     *
     * Tombol/tautan memakai $min lebih longgar (3.0 / 2.0) karena
     * teksnya lebih besar atau bergaris bawah.
     *
     * @param  array<int, string>  $kandidat  Cadangan argmax; default putih vs tinta.
     */
    public static function pilihTeks(string $bg, string $pilihanPanel, float $min = self::MIN_KONTRAS, array $kandidat = [self::PUTIH, self::TINTA]): string
    {
        if (self::rasio($bg, $pilihanPanel) >= $min) {
            return $pilihanPanel;
        }

        $terbaik = self::PUTIH;
        $skorTerbaik = self::rasio($bg, $terbaik);

        foreach ($kandidat as $k) {
            $skor = self::rasio($bg, $k);

            if ($skor > $skorTerbaik) {
                $terbaik = $k;
                $skorTerbaik = $skor;
            }
        }

        return $terbaik;
    }

    /**
     * Interpolasi dua warna hex (mis. latar badge = aksen + halaman).
     * $porsiA = bagian warna A dalam persen (0-100).
     */
    public static function campurWarna(string $a, string $b, float $porsiA): string
    {
        $ra = self::rgd($a);
        $rb = self::rgd($b);
        $t = $porsiA / 100;

        $hasil = '';

        foreach ([0, 1, 2] as $i) {
            $nilai = (int) round($ra[$i] * $t + $rb[$i] * (1 - $t));
            $hasil .= str_pad(dechex($nilai), 2, '0', STR_PAD_LEFT);
        }

        return '#'.strtoupper($hasil);
    }

    /**
     * Kanal RGB 0-255 dari warna hex (fallback hitam untuk format rusak).
     *
     * @return array{0:int,1:int,2:int}
     */
    private static function rgd(string $hex): array
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return [0, 0, 0];
        }

        return [
            (int) hexdec(substr($hex, 0, 2)),
            (int) hexdec(substr($hex, 2, 2)),
            (int) hexdec(substr($hex, 4, 2)),
        ];
    }
}
