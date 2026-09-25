<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantDummySeeder extends Seeder
{
    public function run(): void
    {
        $tenantDb = DB::connection('tenant');

        // Seeding Jurusan
        $tenantDb->table('jurusan')->truncate();
        $jurusan = [
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'singkatan' => 'TKJ',
                'slug' => 'teknik-komputer-dan-jaringan',
                'deskripsi_singkat' => 'Mempelajari perakitan komputer, instalasi jaringan, dan administrasi server.',
                'deskripsi_lengkap' => '<p>Mempelajari perakitan komputer, instalasi jaringan, dan administrasi server tingkat lanjut.</p>',
                'ikon_atau_foto' => '🖥️',
                'urutan' => 1,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'slug' => 'rekayasa-perangkat-lunak',
                'deskripsi_singkat' => 'Fokus pada pengembangan perangkat lunak berbasis web, mobile, dan desktop.',
                'deskripsi_lengkap' => '<p>Fokus pada pengembangan aplikasi dan pemrograman berorientasi objek.</p>',
                'ikon_atau_foto' => '💻',
                'urutan' => 2,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'singkatan' => 'DKV',
                'slug' => 'desain-komunikasi-visual',
                'deskripsi_singkat' => 'Belajar desain grafis, videografi, animasi, dan media kreatif.',
                'deskripsi_lengkap' => '<p>Mempelajari teknik komunikasi visual dan desain multimedia modern.</p>',
                'ikon_atau_foto' => '🎨',
                'urutan' => 3,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('jurusan')->insert($jurusan);

        // Kategori Artikel
        $tenantDb->table('kategori_artikel')->truncate();
        $kategoriId = $tenantDb->table('kategori_artikel')->insertGetId([
            'nama_kategori' => 'Berita Sekolah',
            'slug' => 'berita-sekolah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tenantDb->table('pengguna')->truncate();
        $userId = $tenantDb->table('pengguna')->insertGetId([
            'nama' => 'Admin Sekolah',
            'email' => 'admin@smkn2bdg.test',
            'password' => bcrypt('password'),
            'peran' => 'admin',
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Artikel
        $tenantDb->table('artikel')->truncate();
        $artikel = [
            [
                'pengguna_id' => $userId,
                'kategori_id' => $kategoriId,
                'judul' => 'Siswa SMKN 2 Bandung Juara 1 Lomba LKS Nasional',
                'slug' => 'siswa-smkn-2-bandung-juara-1-lks-nasional',
                'ringkasan' => 'Prestasi membanggakan kembali diraih oleh siswa jurusan RPL pada ajang LKS Nasional 2026.',
                'isi_konten' => '<p>Prestasi membanggakan kembali diraih...</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1567168544813-cc03465b4fa8?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengguna_id' => $userId,
                'kategori_id' => $kategoriId,
                'judul' => 'Kunjungan Industri ke PT. Telkom Indonesia',
                'slug' => 'kunjungan-industri-ke-pt-telkom-indonesia',
                'ringkasan' => 'Mengenalkan dunia kerja nyata kepada siswa melalui kunjungan industri tahunan.',
                'isi_konten' => '<p>Kegiatan rutin kunjungan industri...</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengguna_id' => $userId,
                'kategori_id' => $kategoriId,
                'judul' => 'Penerimaan Peserta Didik Baru (PPDB) 2026',
                'slug' => 'penerimaan-peserta-didik-baru-2026',
                'ringkasan' => 'Informasi lengkap seputar pendaftaran siswa baru tahun ajaran 2026/2027.',
                'isi_konten' => '<p>Pendaftaran akan dibuka mulai...</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => true,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('artikel')->insert($artikel);

        // Statistik Dummy via PengaturanUmum
        $stats = [
            ['kunci' => 'stat_siswa', 'nilai' => '1240'],
            ['kunci' => 'stat_guru', 'nilai' => '86'],
            ['kunci' => 'stat_prestasi', 'nilai' => '142'],
            ['kunci' => 'stat_alumni', 'nilai' => '5000+'],
        ];
        foreach ($stats as $stat) {
            $tenantDb->table('pengaturan_umum')->updateOrInsert(['kunci' => $stat['kunci']], $stat);
        }
    }
}
