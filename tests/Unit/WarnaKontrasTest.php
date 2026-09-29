<?php

use App\Support\WarnaKontras;

test('luminans memakai rumus WCAG 2.1 dan menerima hex pendek', function () {
    expect(WarnaKontras::luminans('#FFFFFF'))->toBeGreaterThan(0.999)
        ->and(WarnaKontras::luminans('#000000'))->toBeLessThan(0.001)
        ->and(WarnaKontras::luminans('#fff'))->toBe(WarnaKontras::luminans('#FFFFFF'));
});

test('format warna tidak dikenal dianggap terang sehingga teks tidak pernah hilang', function () {
    expect(WarnaKontras::luminans('merah'))->toBe(1.0)
        ->and(WarnaKontras::luminans('#12345'))->toBe(1.0)
        ->and(WarnaKontras::pilihTeks('merah', '#0F2A22'))->toBe('#0F2A22');
});

test('rasio kontras simetris, maksimal 21:1, dan 1:1 untuk warna sama', function () {
    expect(round(WarnaKontras::rasio('#FFFFFF', '#000000'), 6))->toBe(21.0)
        ->and(round(WarnaKontras::rasio('#000000', '#FFFFFF'), 6))->toBe(21.0)
        ->and(round(WarnaKontras::rasio('#0F172A', '#0F172A'), 6))->toBe(1.0);
});

test('warna teks pilihan admin dipertahankan selama lolos AA 4.5:1', function () {
    expect(WarnaKontras::pilihTeks('#FFFFFF', '#0F2A22'))->toBe('#0F2A22')
        ->and(WarnaKontras::pilihTeks('#FFFFFF', '#64748B'))->toBe('#64748B');
});

test('teks dipaksa kontras saat latar gelap, terang, atau sama dengan teksnya', function () {
    // Kartu hijau zamrud + judul hijau tua: 1.03:1 -> dipaksa putih.
    expect(WarnaKontras::pilihTeks('#052E1F', '#0F2A22'))->toBe('#FFFFFF')
        // Teks sekunder nyaris sama terang dengan latar halaman -> tinta.
        ->and(WarnaKontras::pilihTeks('#F8FAFC', '#E2E8F0'))->toBe('#0F172A')
        // Kasus ekstrem: warna teks identik dengan latar.
        ->and(WarnaKontras::pilihTeks('#0F172A', '#0F172A'))->toBe('#FFFFFF');
});

test('ambang tombol dan tautan lebih longgar daripada teks isi', function () {
    // #94A3B8 di atas putih = 2.56:1: lolos ambang tautan, gagal teks isi.
    expect(WarnaKontras::rasio('#FFFFFF', '#94A3B8'))->toBeGreaterThan(2.0)
        ->and(WarnaKontras::rasio('#FFFFFF', '#94A3B8'))->toBeLessThan(4.5)
        ->and(WarnaKontras::pilihTeks('#FFFFFF', '#94A3B8', 2.0))->toBe('#94A3B8')
        ->and(WarnaKontras::pilihTeks('#FFFFFF', '#94A3B8', 4.5))->toBe('#0F172A');
});

test('campurWarna menginterpolasi dua warna dan aman untuk hex pendek', function () {
    expect(WarnaKontras::campurWarna('#0284C7', '#F8FAFC', 15))->toBe('#D3E8F4')
        ->and(WarnaKontras::campurWarna('#FFFFFF', '#000000', 0))->toBe('#000000')
        ->and(WarnaKontras::campurWarna('#FFFFFF', '#000000', 100))->toBe('#FFFFFF')
        ->and(WarnaKontras::campurWarna('#fff', '#000', 50))->toBe('#808080');
});
