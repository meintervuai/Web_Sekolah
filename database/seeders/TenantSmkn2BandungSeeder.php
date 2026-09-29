<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantSmkn2BandungSeeder extends Seeder
{
    public function run(): void
    {
        $tenantDb = DB::connection('tenant');
        $tenantDb->statement('SET FOREIGN_KEY_CHECKS=0;');

        // 0. Akun Pengguna (Admin & Operator Sekolah)
        $tenantDb->table('pengguna')->truncate();
        $tenantDb->table('pengguna')->insert([
            [
                'id' => 1,
                'nama' => 'Administrator SMKN 2 Bandung',
                'email' => 'admin@smkn2bdg.test',
                'password' => Hash::make('password'),
                'peran' => 'admin',
                'foto_profil' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama' => 'Administrator Resmi SMKN 2 Bandung',
                'email' => 'admin@smkn2bandung.sch.id',
                'password' => Hash::make('password123'),
                'peran' => 'admin',
                'foto_profil' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama' => 'Staf Tata Usaha & Operator',
                'email' => 'operator@smkn2bandung.sch.id',
                'password' => Hash::make('password123'),
                'peran' => 'operator',
                'foto_profil' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 1. Pengaturan Umum (Identitas Resmi SMK Negeri 2 Bandung)
        $tenantDb->table('pengaturan_umum')->truncate();
        $pengaturan = [
            ['kunci' => 'nama_sekolah', 'nilai' => 'SMK Negeri 2 Bandung'],
            ['kunci' => 'jenjang', 'nilai' => 'SMK'],
            ['kunci' => 'slogan', 'nilai' => 'Sekolah Pusat Keunggulan - Berkarakter, Unggul & Berdaya Saing Global'],
            ['kunci' => 'npsn', 'nilai' => '20219146'],
            ['kunci' => 'akreditasi', 'nilai' => 'A (Amat Baik)'],
            ['kunci' => 'tahun_berdiri', 'nilai' => '1951'],
            ['kunci' => 'alamat', 'nilai' => 'Jl. Ciliwung No. 4, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114'],
            ['kunci' => 'no_telepon', 'nilai' => '(022) 7234285'],
            ['kunci' => 'email_sekolah', 'nilai' => 'humas@smkn2bandung.sch.id'],
            ['kunci' => 'whatsapp', 'nilai' => '081222333444'],
            ['kunci' => 'jam_layanan', 'nilai' => 'Senin - Jumat: 07.00 - 16.00 WIB'],
            ['kunci' => 'deskripsi', 'nilai' => 'SMK Negeri 2 Bandung merupakan Sekolah Menengah Kejuruan Pusat Keunggulan yang berlokasi strategis di pusat Kota Bandung dengan 7 konsentrasi keahlian berstandar industri nasional dan internasional.'],
            ['kunci' => 'sambutan_kepsek', 'nilai' => 'Selamat datang di website resmi SMK Negeri 2 Bandung. Melalui platform digital ini, kami berkomitmen menyajikan transparansi informasi dan layanan pendidikan vokasi terdepan, adaptif terhadap perkembangan teknologi industri 4.0, serta berorientasi pada pembentukan karakter Profil Pelajar Pancasila yang tangguh dan kompeten.'],
            ['kunci' => 'nama_kepsek', 'nilai' => 'Dr. H. Hasanudin, M.Pd.'],
            ['kunci' => 'nip_kepsek', 'nilai' => '19680512 199303 1 004'],
            ['kunci' => 'foto_kepsek', 'nilai' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop'],
            ['kunci' => 'warna_tema', 'nilai' => '#1E3A8A'], // Navy Blue elegan khas sekolah kejuruan
            ['kunci' => 'warna_aksen', 'nilai' => '#0284C7'],
            // Pengaturan Tema & Warna Portal (panel admin: Tema & Warna)
            // A. Warna Identitas, B. Tipografi, C. Latar, D. Garis, E. Tombol, F. Header & Footer
            ['kunci' => 'warna_judul', 'nilai' => '#0F172A'],
            ['kunci' => 'warna_teks', 'nilai' => '#1E293B'],
            ['kunci' => 'warna_teks_sekunder', 'nilai' => '#475569'],
            ['kunci' => 'warna_latar_halaman', 'nilai' => '#F8FAFC'],
            ['kunci' => 'warna_latar_section', 'nilai' => '#F1F5F9'],
            ['kunci' => 'warna_kartu', 'nilai' => '#FFFFFF'],
            ['kunci' => 'warna_border', 'nilai' => '#E2E8F0'],
            ['kunci' => 'warna_tombol', 'nilai' => '#1D4ED8'],
            ['kunci' => 'warna_tombol_teks', 'nilai' => '#FFFFFF'],
            ['kunci' => 'warna_header', 'nilai' => '#1E3A8A'],
            ['kunci' => 'warna_footer', 'nilai' => '#172F63'],
            ['kunci' => 'skema_tema', 'nilai' => 'navy_classic'],
            ['kunci' => 'logo', 'nilai' => ''],
            // Statistik Resmi dengan label sumber & tahun
            ['kunci' => 'stat_guru', 'nilai' => '98'],
            ['kunci' => 'stat_guru_label', 'nilai' => 'Guru & Tenaga Kependidikan'],
            ['kunci' => 'stat_siswa', 'nilai' => '1972'],
            ['kunci' => 'stat_siswa_label', 'nilai' => 'Siswa Aktif'],
            ['kunci' => 'stat_rombel', 'nilai' => '54'],
            ['kunci' => 'stat_rombel_label', 'nilai' => 'Rombongan Belajar'],
            ['kunci' => 'stat_kelas', 'nilai' => '41'],
            ['kunci' => 'stat_kelas_label', 'nilai' => 'Ruang Kelas Nyaman'],
            ['kunci' => 'stat_jurusan', 'nilai' => '7'],
            ['kunci' => 'stat_jurusan_label', 'nilai' => 'Program Keahlian Unggulan'],
            ['kunci' => 'stat_mitra', 'nilai' => '85'],
            ['kunci' => 'stat_mitra_label', 'nilai' => 'Mitra Industri (DUDI)'],
            ['kunci' => 'stat_sumber_label', 'nilai' => 'Data Pokok Pendidikan (Dapodik) Kemendikbudristek TA 2025/2026'],
            ['kunci' => 'peta_embed', 'nilai' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.915720919426!2d107.62512397499625!3d-6.900693593098544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c39f06121%3A0x6b4887342617f164!2sSMK%20Negeri%202%20Bandung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid'],
        ];
        foreach ($pengaturan as $p) {
            $p['created_at'] = now();
            $p['updated_at'] = now();
            $tenantDb->table('pengaturan_umum')->insert($p);
        }

        // 2. Pengaturan Fitur (Feature Flags)
        $tenantDb->table('pengaturan_fitur')->truncate();
        $fitur = [
            ['kode_fitur' => 'beranda', 'nama_fitur' => 'Halaman Beranda', 'is_aktif' => true],
            ['kode_fitur' => 'profil', 'nama_fitur' => 'Profil Sekolah & Sejarah', 'is_aktif' => true],
            ['kode_fitur' => 'program_keahlian', 'nama_fitur' => 'Program Keahlian / Jurusan', 'is_aktif' => true],
            ['kode_fitur' => 'berita', 'nama_fitur' => 'Berita & Artikel', 'is_aktif' => true],
            ['kode_fitur' => 'agenda', 'nama_fitur' => 'Agenda & Event', 'is_aktif' => true],
            ['kode_fitur' => 'pengumuman', 'nama_fitur' => 'Pengumuman Resmi', 'is_aktif' => true],
            ['kode_fitur' => 'prestasi', 'nama_fitur' => 'Prestasi Siswa', 'is_aktif' => true],
            ['kode_fitur' => 'kegiatan', 'nama_fitur' => 'Dokumentasi Kegiatan', 'is_aktif' => true],
            ['kode_fitur' => 'ekstrakurikuler', 'nama_fitur' => 'Ekstrakurikuler & Kesiswaan', 'is_aktif' => true],
            ['kode_fitur' => 'guru_staf', 'nama_fitur' => 'Direktori Guru & Tenaga Kependidikan', 'is_aktif' => true],
            ['kode_fitur' => 'fasilitas', 'nama_fitur' => 'Fasilitas & Sarpras', 'is_aktif' => true],
            ['kode_fitur' => 'galeri', 'nama_fitur' => 'Galeri Foto & Video', 'is_aktif' => true],
            ['kode_fitur' => 'spmb', 'nama_fitur' => 'SPMB / PPDB Online', 'is_aktif' => true],
            ['kode_fitur' => 'kontak', 'nama_fitur' => 'Kontak & Form Pengaduan', 'is_aktif' => true],
        ];
        foreach ($fitur as $f) {
            $f['created_at'] = now();
            $f['updated_at'] = now();
            $tenantDb->table('pengaturan_fitur')->insert($f);
        }

        // 3. Slider Beranda (Hero)
        $tenantDb->table('slider_beranda')->truncate();
        $slider = [
            [
                'judul' => 'Mencetak Generasi Vokasi Berdaya Saing Global',
                'subjudul' => 'SMK Negeri 2 Bandung memadukan kurikulum industri, teknologi modern, dan karakter unggul berorientasi masa depan.',
                'gambar' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1600&auto=format&fit=crop',
                'link_tombol' => '/spmb',
                'teks_tombol' => 'Info SPMB 2026',
                'urutan' => 1,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pembelajaran Berbasis Teaching Factory (TEFA)',
                'subjudul' => '7 Konsentrasi Keahlian teknologi dan rekayasa dengan fasilitas bengkel serta laboratorium standar industri.',
                'gambar' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1600&auto=format&fit=crop',
                'link_tombol' => '/program-keahlian',
                'teks_tombol' => 'Lihat Program Keahlian',
                'urutan' => 2,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Prestasi Nyata di Tingkat Nasional & Internasional',
                'subjudul' => 'Raih masa depan gemilang dengan sertifikasi kompetensi keahlian dan kemitraan puluhan industri terkemuka.',
                'gambar' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1600&auto=format&fit=crop',
                'link_tombol' => '/prestasi',
                'teks_tombol' => 'Capaian Prestasi',
                'urutan' => 3,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('slider_beranda')->insert($slider);

        // 4. 7 Program Keahlian Resmi SMK Negeri 2 Bandung
        $tenantDb->table('jurusan')->truncate();
        $jurusan = [
            [
                'nama_jurusan' => 'Teknik Mesin',
                'singkatan' => 'TM',
                'slug' => 'teknik-mesin',
                'deskripsi_singkat' => 'Mempelajari perancangan, pembuatan komponen mesin presisi, pengoperasian mesin bubut, milling, dan mesin perkakas konvensional maupun CNC modern.',
                'deskripsi_lengkap' => '<p>Program Keahlian Teknik Mesin membekali peserta didik dengan keterampilan pengoperasian mesin perkakas (bubut, frais/milling, gerinda), pemrograman Computer Numerical Control (CNC), dan Computer Aided Manufacturing (CAM).</p><p>Lulusan dipersiapkan menjadi operator mesin presisi, teknisi manufaktur, quality control, dan wirausahawan bidang permesinan.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop',
                'urutan' => 1,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Teknik Pengelasan dan Fabrikasi Logam',
                'singkatan' => 'TPFL',
                'slug' => 'teknik-pengelasan-dan-fabrikasi-logam',
                'deskripsi_singkat' => 'Fokus pada teknik pengelasan SMAW, GMAW, GTAW berstandar internasional, fabrikasi struktur logam, serta inspeksi uji kualitas sambungan las.',
                'deskripsi_lengkap' => '<p>Program Keahlian TPFL mempersiapkan tenaga ahli pengelasan industri otomotif, perkapalan, konstruksi gedung, dan migas. Peserta didik dilatih menguasai teknik pengelasan Shielded Metal Arc Welding (SMAW), Gas Metal Arc Welding (GMAW/MIG-MAG), dan Gas Tungsten Arc Welding (GTAW/TIG).</p><p>Siswa mendapatkan sertifikasi Badan Nasional Sertifikasi Profesi (BNSP) untuk lisensi welder profesional.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=800&auto=format&fit=crop',
                'urutan' => 2,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Pengembangan Perangkat Lunak dan Gim',
                'singkatan' => 'PPLG',
                'slug' => 'pengembangan-perangkat-lunak-dan-gim',
                'deskripsi_singkat' => 'Mempelajari pemrograman web, aplikasi mobile, rekayasa perangkat lunak modern, database, serta perancangan logika dan asset game 2D/3D.',
                'deskripsi_lengkap' => '<p>PPLG (sebelumnya RPL) berfokus pada pengembangan solusi perangkat lunak skala enterprise, mobile apps (Flutter, Android native), web development (Laravel, React, Node.js), UI/UX design, dan implementasi game engine seperti Unity dan Godot.</p><p>Kurikulum didukung kemitraan langsung dengan software house terkemuka di Kota Bandung dan Jakarta.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800&auto=format&fit=crop',
                'urutan' => 3,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'singkatan' => 'TJKT',
                'slug' => 'teknik-jaringan-komputer-dan-telekomunikasi',
                'deskripsi_singkat' => 'Spesialisasi arsitektur jaringan komputer, routing-switching enterprise, fiber optic, cloud infrastructure, cyber security, dan Mikrotik Academy.',
                'deskripsi_lengkap' => '<p>TJKT (sebelumnya TKJ) mendalami instalasi jaringan kabel dan nirkabel, konfigurasi router enterprise (MikroTik MTCNA, Cisco CCNA), virtualisasi server, cloud computing (AWS/Google Cloud), dan administrasi sistem keamanan jaringan komputer.</p><p>SMK Negeri 2 Bandung merupakan Pusat Mikrotik Academy resmi di Jawa Barat.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=800&auto=format&fit=crop',
                'urutan' => 4,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'singkatan' => 'DKV',
                'slug' => 'desain-komunikasi-visual',
                'deskripsi_singkat' => 'Mempelajari desain grafis, tipografi, fotografi profesional, videografi komersial, branding identitas visual, dan digital advertising.',
                'deskripsi_lengkap' => '<p>Program Keahlian DKV mengasah kreativitas estetika dan kemampuan komunikasi visual peserta didik melalui penguasaan software industri (Adobe Creative Cloud: Illustrator, Photoshop, InDesign, Premiere Pro) serta studio foto dan video berstandar profesional.</p><p>Prospek karir mencakup Graphic Designer, Art Director, UI Designer, Videographer, dan Creative Entrepreneur.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
                'urutan' => 5,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Animasi',
                'singkatan' => 'ANI',
                'slug' => 'animasi',
                'deskripsi_singkat' => 'Mempelajari pembuatan animasi 2D & 3D, character design, storyboard, rigging, compositing, visual effects (VFX), dan audio post-production.',
                'deskripsi_lengkap' => '<p>Program Keahlian Animasi mempersiapkan peserta didik menjadi animator profesional untuk industri film, game, dan periklanan. Menggunakan pipeline industri seperti Blender, Maya, Toon Boom Harmony, dan After Effects.</p><p>Siswa terlibat dalam produksi karya intellectual property (IP) film pendek animasi berkolaborasi dengan studio animasi terkemuka.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=800&auto=format&fit=crop',
                'urutan' => 6,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Desain Gambar Mesin',
                'singkatan' => 'DGM',
                'slug' => 'desain-gambar-mesin',
                'deskripsi_singkat' => 'Fokus pada Computer Aided Design (CAD 2D/3D), mechanical engineering drafting, toleransi geometris, reverse engineering, dan 3D prototyping.',
                'deskripsi_lengkap' => '<p>Program Keahlian Desain Gambar Mesin mencetak drafter dan mechanical CAD engineer andal yang menguasai AutoCAD, Autodesk Inventor, dan SolidWorks untuk merancang komponen mesin, alat bantu produksi (jig & fixture), dan mekanikal presisi.</p><p>Lulusan terserap luas di industri manufaktur otomotif, mold & dies, serta konsultan rekayasa teknik.</p>',
                'ikon_atau_foto' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?q=80&w=800&auto=format&fit=crop',
                'urutan' => 7,
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('jurusan')->insert($jurusan);

        // 5. Kategori Artikel
        $tenantDb->table('kategori_artikel')->truncate();
        $kategori = [
            ['id' => 1, 'nama_kategori' => 'Prestasi & Akademik', 'slug' => 'prestasi-akademik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama_kategori' => 'Kemitraan Industri', 'slug' => 'kemitraan-industri', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama_kategori' => 'Kesiswaan & Karakter', 'slug' => 'kesiswaan-karakter', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama_kategori' => 'Pengumuman Resmi', 'slug' => 'pengumuman-resmi', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('kategori_artikel')->insert($kategori);

        // 6. Artikel (Minimal 6 Berita + Minimal 4 Pengumuman)
        $tenantDb->table('artikel')->truncate();
        $beritaList = [
            // 6 BERITA
            [
                'kategori_id' => 1,
                'judul' => 'Siswa SMK Negeri 2 Bandung Raih Medali Emas LKS Nasional 2026 Bidang CNC Milling',
                'slug' => 'siswa-smkn2-bandung-raih-medali-emas-lks-nasional-2026-cnc-milling',
                'ringkasan' => 'Kontingen SMK Negeri 2 Bandung kembali menorehkan prestasi gemilang dengan merebut Medali Emas pada ajang Lomba Kompetensi Siswa (LKS) Tingkat Nasional.',
                'isi_konten' => '<p>Prestasi membanggakan kembali dipersembahkan oleh peserta didik SMK Negeri 2 Bandung pada ajang Lomba Kompetensi Siswa (LKS) SMK Tingkat Nasional ke-34 tahun 2026. Dalam kompetisi bergengsi yang diselenggarakan oleh Balai Pengembangan Talenta Indonesia (BPTI) Kemendikbudristek tersebut, perwakilan konsentrasi keahlian Teknik Mesin berhasil meraih Medali Emas untuk bidang lomba CNC Milling.</p><p>Kepala SMK Negeri 2 Bandung, Dr. H. Hasanudin, M.Pd., menyampaikan apresiasi setinggi-tingginya kepada siswa pembina, guru pendamping, dan mitra industri yang telah mengawal proses pembinaan intensif selama enam bulan terakhir.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(2),
                'jumlah_dilihat' => 342,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'kategori_id' => 2,
                'judul' => 'SMKN 2 Bandung Resmikan Kelas Industri dan Lab Komputasi Awan Bersama Mitra Global',
                'slug' => 'smkn-2-bandung-resmikan-kelas-industri-dan-lab-komputasi-awan',
                'ringkasan' => 'Kerja sama strategis ini memperkuat kurikulum kejuruan berbasis industri nyata dengan sertifikasi kompetensi bertaraf internasional.',
                'isi_konten' => '<p>Sebagai wujud nyata transformasi SMK Pusat Keunggulan, SMK Negeri 2 Bandung secara resmi meluncurkan fasilitas Laboratorium Cloud Computing dan Kelas Industri hasil kolaborasi dengan raksasa teknologi global. Fasilitas ini didedikasikan untuk peserta didik program keahlian TJKT dan PPLG.</p><p>Melalui kemitraan ini, siswa akan mendapatkan kurikulum terkini seputar cloud architecture, cyber security, dan DevOps langsung dari instruktur industri bersertifikat.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(5),
                'jumlah_dilihat' => 520,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'kategori_id' => 3,
                'judul' => 'Gelar Pameran Karya Inovasi TEFA Expo 2026: Produk Siswa Siap Masuk Pasar Ritel',
                'slug' => 'gelar-pameran-karya-inovasi-tefa-expo-2026',
                'ringkasan' => 'Ratusan produk kreatif mulai dari komponen mesin presisi, game edukasi, animasi pendek hingga merchandise dipamerkan di Aula Graha Wiyata.',
                'isi_konten' => '<p>Teaching Factory Expo (TEFA Expo) 2026 SMK Negeri 2 Bandung sukses menyedot perhatian ribuan pengunjung dari kalangan pendidik, siswa SMP, dan perwakilan asosiasi industri Jawa Barat. Pameran menampilkan hasil pembelajaran berbasis proyek nyata (Project-Based Learning) dari 7 konsentrasi keahlian.</p><p>Beberapa produk unggulan seperti prototipe mesin pemilah sampah otomatis dan game petualangan budaya Sunda bahkan mendapatkan tawaran pendanaan awal dari investor inkubasi bisnis.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(9),
                'jumlah_dilihat' => 415,
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],
            [
                'kategori_id' => 1,
                'judul' => 'Tim Animasi SMKN 2 Bandung Sabet Juara 1 Festival Film Pendek Pelajar Jawa Barat',
                'slug' => 'tim-animasi-smkn-2-bandung-sabet-juara-1-festival-film-pendek-jabar',
                'ringkasan' => 'Film animasi 2D bertajuk "Harmoni di Ciliwung" memikat dewan juri dengan kekuatan narasi nilai kepedulian lingkungan dan visual yang memukau.',
                'isi_konten' => '<p>Karya animasi berdurasi 7 menit karya siswa kelas XII Animasi berhasil menyabet Juara 1 pada Festival Film Pelajar Jawa Barat 2026. Karya ini diproduksi selama 3 bulan di studio animasi sekolah dengan bimbingan praktisi studio industri lokal.</p><p>Karya ini direncanakan akan diputar pada festival animasi pelajar tingkat Asia Tenggara akhir tahun ini.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(12),
                'jumlah_dilihat' => 289,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            [
                'kategori_id' => 3,
                'judul' => 'Bina Karakter Kedisiplinan Siswa Melalui Diksar Bela Negara Bersama Kodam III/Siliwangi',
                'slug' => 'bina-karakter-kedisiplinan-siswa-melalui-diksar-bela-negara',
                'ringkasan' => 'Sebanyak 650 siswa tingkat X mengikuti pelatihan kepemimpinan, baris-berbaris, dan pembinaan mental spiritual guna membentuk etos kerja unggul.',
                'isi_konten' => '<p>Sebagai bagian dari komitmen pembentukan karakter profil pelajar pancasila dan kesiapan budaya kerja industri, SMK Negeri 2 Bandung menyelenggarakan Pendidikan Dasar Kedisiplinan dan Bela Negara. Kegiatan berlangsung selama 4 hari dengan bimbingan instruktur profesional.</p><p>Materi mencakup wawasan kebangsaan, team building, manajemen waktu, dan latihan tanggap darurat bencana.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(15),
                'jumlah_dilihat' => 610,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'kategori_id' => 2,
                'judul' => 'Job Fair & Career Day SMKN 2 Bandung 2026: Tersedia 1.200 Lowongan dari 45 Perusahaan',
                'slug' => 'job-fair-career-day-smkn-2-bandung-2026',
                'ringkasan' => 'Bursa kerja khusus (BKK) memfasilitasi rekrutmen langsung bagi calon lulusan dan alumni SMK di bidang manufaktur, IT, dan industri kreatif.',
                'isi_konten' => '<p>Bursa Kerja Khusus (BKK) Mitra Sejahtera SMK Negeri 2 Bandung kembali menggelar Job Fair & Career Day tahunan. Sebanyak 45 perusahaan multinasional dan BUMN berpartisipasi membuka peluang karir bagi para lulusan kejuruan di kawasan Bandung Raya dan nasional.</p><p>Acara ini juga dilengkapi seminar kiat sukses wawancara kerja dan tes psikotes langsung di lokasi.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => false,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(20),
                'jumlah_dilihat' => 840,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],

            // 4 PENGUMUMAN PENTING
            [
                'kategori_id' => 4,
                'judul' => 'Petunjuk Teknis Penerimaan Peserta Didik Baru (PPDB/SPMB) Tahun Ajaran 2026/2027',
                'slug' => 'petunjuk-teknis-ppdb-spmb-tahun-ajaran-2026-2027',
                'ringkasan' => 'Informasi lengkap jadwal pendaftaran, jalur afirmasi, perpindahan tugas orang tua, zonasi prioritas, dan jalur prestasi kejuaraan.',
                'isi_konten' => '<p>Diberitahukan kepada seluruh calon peserta didik baru dan orang tua/wali bahwa tahapan PPDB/SPMB SMK Negeri 2 Bandung Tahun Ajaran 2026/2027 akan dibuka dalam dua tahap pendaftaran sesuai ketentuan Dinas Pendidikan Provinsi Jawa Barat.</p><p>Seluruh dokumen persyaratan teknis dan jadwal verifikasi berkas dapat diakses melalui portal resmi atau halaman khusus SPMB pada website ini.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => true,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(1),
                'jumlah_dilihat' => 1250,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'kategori_id' => 4,
                'judul' => 'Jadwal Asesmen Sumatif Akhir Jenjang (ASAJ) Kelas XII Tahun Pembelajaran 2025/2026',
                'slug' => 'jadwal-asesmen-sumatif-akhir-jenjang-kelas-xii',
                'ringkasan' => 'Tata tertib, pembagian ruang ujian berbasis komputer (CBT), dan jadwal mata pelajaran yang diujikan mulai tanggal 12 s.d 19 Mei 2026.',
                'isi_konten' => '<p>Pelaksanaan Asesmen Sumatif Akhir Jenjang (ASAJ) untuk seluruh siswa kelas XII akan dilaksanakan menggunakan Computer-Based Test (CBT) di laboratorium komputer sekolah. Siswa diwajibkan hadir 15 menit sebelum sesi dimulai dengan seragam lengkap dan kartu peserta ujian resmi.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => true,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(4),
                'jumlah_dilihat' => 980,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'kategori_id' => 4,
                'judul' => 'Sosialisasi Program Praktik Kerja Lapangan (PKL) Industri Periode Ganjil 2026',
                'slug' => 'sosialisasi-program-praktik-kerja-lapangan-pkl-periode-ganjil-2026',
                'ringkasan' => 'Pertemuan daring dan tatap muka bersama orang tua siswa kelas XI mengenai penempatan kerja praktik di 85 mitra industri ternama.',
                'isi_konten' => '<p>Pihak sekolah mengundang seluruh orang tua/wali siswa kelas XI untuk menghadiri sosialisasi teknis pelaksanaan PKL selama 6 bulan. Pembahasan mencakup hak dan kewajiban peserta, jaminan keselamatan kerja, serta sistem monitoring dosen pembimbing industri.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => true,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(8),
                'jumlah_dilihat' => 765,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'kategori_id' => 4,
                'judul' => 'Pengumuman Beasiswa Prestasi & Bantuan Khusus Pendidikan (BKP) Kota Bandung',
                'slug' => 'pengumuman-beasiswa-prestasi-dan-bantuan-khusus-pendidikan-bkp',
                'ringkasan' => 'Daftar nama penerima manfaat bantuan pendidikan serta mekanisme aktivasi rekening tabungan pelajar Bank BJB.',
                'isi_konten' => '<p>Berdasarkan hasil verifikasi tim kesiswaan bersama Dinas Pendidikan, berikut adalah daftar calon penerima Beasiswa Prestasi dan BKP. Siswa yang namanya tercantum diharapkan segera melengkapi berkas verifikasi di bagian Tata Usaha ruang kesiswaan.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=800&auto=format&fit=crop',
                'is_pengumuman' => true,
                'status_publikasi' => 'published',
                'tgl_publikasi' => now()->subDays(14),
                'jumlah_dilihat' => 1100,
                'created_at' => now()->subDays(14),
                'updated_at' => now()->subDays(14),
            ],
        ];
        $tenantDb->table('artikel')->insert($beritaList);

        // 7. Minimal 4 Agenda Sekolah
        $tenantDb->table('agenda')->truncate();
        $agenda = [
            [
                'judul' => 'Uji Sertifikasi Kompetensi (USK) Siswa Bersama Lembaga Sertifikasi Profesi (LSP-P1)',
                'slug' => 'uji-sertifikasi-kompetensi-usk-lsp-p1-2026',
                'ringkasan' => 'Uji kompetensi teknis skema okupasi nasional bagi calon lulusan 7 program keahlian oleh asesor bersertifikat BNSP.',
                'deskripsi_lengkap' => '<p>Pelaksanaan Uji Sertifikasi Kompetensi (USK) merupakan penentu kelayakan sertifikasi profesi nasional berlogo Garuda bagi seluruh peserta didik tingkat akhir. Pengujian mencakup uji tulis teori kejuruan, wawancara portofolio, dan demonstrasi praktik kerja mandiri di tempat uji kompetensi (TUK) sekolah.</p>',
                'tgl_mulai' => now()->addDays(5)->toDateString(),
                'tgl_selesai' => now()->addDays(9)->toDateString(),
                'jam_mulai' => '07.30',
                'jam_selesai' => '16.00 WIB',
                'lokasi' => 'TUK Mandiri SMK Negeri 2 Bandung',
                'penyelenggara' => 'LSP-P1 SMKN 2 Bandung & BNSP',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop',
                'link_pendaftaran' => '#',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pameran Karya Akhir & Industri Kelulusan (Graduation Showcase 2026)',
                'slug' => 'pameran-karya-akhir-graduation-showcase-2026',
                'ringkasan' => 'Gelar inovasi tugas akhir siswa kelas XII di hadapan 50 HRD perusahaan mitra dan perguruan tinggi vokasi ternama.',
                'deskripsi_lengkap' => '<p>Graduation Showcase adalah wadah unjuk kebolehan karya cipta siswa sebelum memasuki dunia kerja atau perkuliahan. Terbuka untuk umum, praktisi industri, dan orang tua siswa.</p>',
                'tgl_mulai' => now()->addDays(14)->toDateString(),
                'tgl_selesai' => now()->addDays(15)->toDateString(),
                'jam_mulai' => '08.00',
                'jam_selesai' => '15.30 WIB',
                'lokasi' => 'Aula Graha Wiyata & Lapangan Utama',
                'penyelenggara' => 'Humas & Hubungan Industri (Hubin)',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop',
                'link_pendaftaran' => '#',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Workshop Technopreneurship Vokasi: Membangun Startup Digital Berbasis Kearifan Lokal',
                'slug' => 'workshop-technopreneurship-vokasi-startup-digital',
                'ringkasan' => 'Pelatihan intensif inkubasi bisnis dan monetisasi produk digital bagi siswa DKV, PPLG, dan Animasi.',
                'deskripsi_lengkap' => '<p>Menghadirkan narasumber Founder & CEO tech-startup alumni SMK Negeri 2 Bandung yang sukses menembus pendanaan ventura. Peserta dilatih menyusun pitch deck, riset pasar, dan validasi model bisnis inovatif.</p>',
                'tgl_mulai' => now()->addDays(22)->toDateString(),
                'tgl_selesai' => now()->addDays(22)->toDateString(),
                'jam_mulai' => '09.00',
                'jam_selesai' => '13.00 WIB',
                'lokasi' => 'Auditorium Gedung B Lantai 3',
                'penyelenggara' => 'Unit Produksi & TEFA SMKN 2 Bandung',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=800&auto=format&fit=crop',
                'link_pendaftaran' => '#',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Latihan Gabungan Palang Merah Remaja (PMR) & Kesiapsiagaan Bencana Gempa Sesar Lembang',
                'slug' => 'latihan-gabungan-pmr-kesiapsiagaan-bencana-sesar-lembang',
                'ringkasan' => 'Simulasi evakuasi mandiri dan pertolongan pertama gawat darurat bekerjasama dengan PMI Kota Bandung dan BPBD Jabar.',
                'deskripsi_lengkap' => '<p>Kegiatan simulasi kesiapsiagaan sekolah tangguh bencana untuk meningkatkan kapasitas respon cepat seluruh warga sekolah saat terjadi potensi gempa bumi di wilayah Bandung Raya.</p>',
                'tgl_mulai' => now()->addDays(30)->toDateString(),
                'tgl_selesai' => now()->addDays(30)->toDateString(),
                'jam_mulai' => '08.00',
                'jam_selesai' => '12.00 WIB',
                'lokasi' => 'Lapangan Olahraga & Selasar Kelas SMKN 2',
                'penyelenggara' => 'Ekstrakurikuler PMR Wira & BPBD Jawa Barat',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=800&auto=format&fit=crop',
                'link_pendaftaran' => '#',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('agenda')->insert($agenda);

        // 8. Minimal 6 Prestasi Siswa
        $tenantDb->table('prestasi_siswa')->truncate();
        $prestasi = [
            [
                'nama_siswa' => 'Rifqi Pratama & Fajar Nugraha',
                'nama_prestasi' => 'Medali Emas LKS SMK Tingkat Nasional Bidang CNC Milling',
                'slug' => 'medali-emas-lks-nasional-cnc-milling',
                'tingkat' => 'Nasional',
                'tanggal' => now()->subMonths(1)->toDateString(),
                'tahun' => 2026,
                'foto' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Berhasil memprogram dan memproduksi benda kerja presisi tinggi dengan toleransi mikron dalam batas waktu tercepat dan akurasi geometri sempurna.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Nadia Syahrani',
                'nama_prestasi' => 'Juara 1 Lomba Desain Grafis & Poster Edukasi Tingkat Provinsi Jawa Barat',
                'slug' => 'juara-1-desain-grafis-jawa-barat',
                'tingkat' => 'Provinsi',
                'tanggal' => now()->subMonths(2)->toDateString(),
                'tahun' => 2026,
                'foto' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Karya poster bertema transisi energi hijau dan kelestarian air memukau dewan juri dalam Festival Seni Pelajar Jawa Barat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Dwi Andika Putra',
                'nama_prestasi' => 'Juara 2 Kompetisi Jaringan Komputer & Cyber Security Telkom University',
                'slug' => 'juara-2-kompetisi-jaringan-cyber-security',
                'tingkat' => 'Nasional',
                'tanggal' => now()->subMonths(3)->toDateString(),
                'tahun' => 2025,
                'foto' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Menuntaskan skenario uji penetrasi keamanan jaringan dan konfigurasi firewall enterprise melawan puluhan tim sekolah unggulan se-Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Tim Animasi "Studio Ciliwung 2"',
                'nama_prestasi' => 'Juara 1 Festival Film Animasi Pelajar Nusantara',
                'slug' => 'juara-1-festival-film-animasi-pelajar-nusantara',
                'tingkat' => 'Nasional',
                'tanggal' => now()->subMonths(4)->toDateString(),
                'tahun' => 2025,
                'foto' => 'https://images.unsplash.com/photo-1536240478700-b869070f9279?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Film animasi pendek 2D "Si Kancil Modern" mendapat pujian atas kualitas sinematografi, coloring, dan voice acting.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Muhammad Bintang Alamsyah',
                'nama_prestasi' => 'Medali Perak Kejuaraan Pengelasan GTAW (TIG Welding) Industri',
                'slug' => 'medali-perak-kejuaraan-pengelasan-gtaw',
                'tingkat' => 'Provinsi',
                'tanggal' => now()->subMonths(6)->toDateString(),
                'tahun' => 2025,
                'foto' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Menunjukkan hasil sambungan pipa stainless steel posisi 6G dengan hasil uji radiografi (X-Ray) zero defect.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Tim Paskibra SMKN 2 Bandung',
                'nama_prestasi' => 'Juara Umum Lomba Ketangkasan Baris Berbaris (LKBB) Tingkat Kota Bandung',
                'slug' => 'juara-umum-lkbb-tingkat-kota-bandung',
                'tingkat' => 'Kota',
                'tanggal' => now()->subMonths(7)->toDateString(),
                'tahun' => 2025,
                'foto' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800&auto=format&fit=crop',
                'deskripsi' => 'Meraih kategori Danton Terbaik, Kostum Terbaik, dan Formasi Variasi Paling Dinamis di ajang tahunan PPI Kota Bandung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('prestasi_siswa')->insert($prestasi);

        // 9. Minimal 8 Ekstrakurikuler
        $tenantDb->table('ekstrakurikuler')->truncate();
        $ekskul = [
            [
                'nama_ekstrakurikuler' => 'Paskibra (Pasukan Pengibar Bendera)',
                'slug' => 'paskibra',
                'deskripsi' => 'Melatih kedisiplinan tingkat tinggi, kepemimpinan, formasi baris-berbaris estetik, serta pembinaan mental generasi berkarakter patriotik.',
                'foto' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Rabu & Sabtu',
                'waktu_jadwal' => '15.30 - 17.30 WIB',
                'pembina' => 'Drs. Yayat Supriatna',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Pramuka (Gugus Depan SMKN 2)',
                'slug' => 'pramuka',
                'deskripsi' => 'Mengembangkan keterampilan kepanduan, survival alam bebas, kepemimpinan regu, sandi pramuka, dan pengabdian nyata kepada masyarakat.',
                'foto' => 'https://images.unsplash.com/photo-1510519138171-c70d76b54a45?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Jumat',
                'waktu_jadwal' => '13.30 - 16.00 WIB',
                'pembina' => 'Asep Saepudin, S.Pd.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Palang Merah Remaja (PMR Wira)',
                'slug' => 'palang-merah-remaja',
                'deskripsi' => 'Wadah kemanusiaan yang mendalami pertolongan pertama, donor darah sukarela, evakuasi tandu, dan promosi perilaku hidup bersih dan sehat.',
                'foto' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Selasa & Kamis',
                'waktu_jadwal' => '15.30 - 17.00 WIB',
                'pembina' => 'Hj. Nenden Hernawati, S.Pd.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'IT & Robotics Club (Cyber Team)',
                'slug' => 'it-robotics-club',
                'deskripsi' => 'Eksplorasi Internet of Things (IoT), mikrokontroler Arduino/ESP32, pemrograman robotik, dan kompetisi keamanan siber Capture The Flag (CTF).',
                'foto' => 'https://images.unsplash.com/photo-1563770660941-20978e870e26?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Senin & Kamis',
                'waktu_jadwal' => '15.30 - 17.30 WIB',
                'pembina' => 'Ahmad Hidayat, S.Kom., M.T.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Futsal & Sepakbola SMKN 2',
                'slug' => 'futsal-sepakbola',
                'deskripsi' => 'Latihan fisik, taktik permainan tim, pembinaan atlet kejuaraan liga antar-pelajar Kota Bandung dan turnamen regional Jawa Barat.',
                'foto' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Selasa & Jumat',
                'waktu_jadwal' => '15.30 - 17.30 WIB',
                'pembina' => 'Budi Santoso, S.Pd.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Bola Basket (Ciliwung Ballers)',
                'slug' => 'bola-basket',
                'deskripsi' => 'Pengembangan teknik dribbling, shooting, kerjasama pertahanan dan serangan, serta partisipasi aktif pada DBL (Developmental Basketball League).',
                'foto' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Rabu & Sabtu',
                'waktu_jadwal' => '15.30 - 17.30 WIB',
                'pembina' => 'Rian Kurniawan, S.Pd.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Rohis & Keputrian (Al-Kautsar)',
                'slug' => 'rohis-al-kautsar',
                'deskripsi' => 'Kajian keislaman berkala, tahsin & tahfidz Quran, pembinaan akhlak karimah, bakti sosial ramadhan, serta perayaan hari besar islam.',
                'foto' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Jumat',
                'waktu_jadwal' => '12.45 - 14.30 WIB',
                'pembina' => 'Drs. H. Mamat Rohimat, M.Ag.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'English Debate & Conversation Club (EDC)',
                'slug' => 'english-debate-club',
                'deskripsi' => 'Mengasah kecakapan komunikasi bahasa inggris aktif, public speaking, teknik debat format British Parliamentary, dan persiapan sertifikasi TOEIC.',
                'foto' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Kamis',
                'waktu_jadwal' => '15.30 - 17.00 WIB',
                'pembina' => 'Rina Marlina, S.Pd., M.Hum.',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('ekstrakurikuler')->insert($ekskul);

        // 10. Minimal 8 Guru & Tenaga Kependidikan (dari total 98 guru resmi)
        $tenantDb->table('guru_staf')->truncate();
        $guru = [
            [
                'nip' => '19680512 199303 1 004',
                'nama_lengkap' => 'Dr. H. Hasanudin, M.Pd.',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Kepala Sekolah',
                'mata_pelajaran' => 'Manajemen Pendidikan Kejuruan',
                'foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19740815 200003 2 003',
                'nama_lengkap' => 'Dra. Hj. Siti Aminah, M.Si.',
                'jenis_kelamin' => 'P',
                'jabatan' => 'Wakasek Bidang Kurikulum',
                'mata_pelajaran' => 'Matematika Terapan',
                'foto' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19810214 200801 1 008',
                'nama_lengkap' => 'Budi Santoso, S.Pd., M.T.',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Wakasek Bidang Kesiswaan',
                'mata_pelajaran' => 'Pendidikan Jasmani & Olahraga',
                'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19790618 200604 1 012',
                'nama_lengkap' => 'Ahmad Hidayat, S.Kom., M.T.',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Ketua Program Keahlian PPLG',
                'mata_pelajaran' => 'Pemrograman Berorientasi Objek & Web',
                'foto' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19831120 200902 1 005',
                'nama_lengkap' => 'Joko Widodo, S.T., M.Kom.',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Ketua Program Keahlian TJKT',
                'mata_pelajaran' => 'Administrasi Infrastruktur Jaringan',
                'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19760405 200312 1 002',
                'nama_lengkap' => 'Ir. Hendra Gunawan, S.T.',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Ketua Program Keahlian Teknik Mesin',
                'mata_pelajaran' => 'Teknik Pemesinan Bubut & CNC',
                'foto' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19850912 201001 2 018',
                'nama_lengkap' => 'Sari Indah Kusuma, S.Sn., M.Ds.',
                'jenis_kelamin' => 'P',
                'jabatan' => 'Ketua Program Keahlian DKV & Animasi',
                'mata_pelajaran' => 'Desain Publikasi & Motion Graphic',
                'foto' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '19820325 200701 2 014',
                'nama_lengkap' => 'Rina Marlina, S.Pd., M.Hum.',
                'jenis_kelamin' => 'P',
                'jabatan' => 'Guru Penggerak & Koordinator Bahasa',
                'mata_pelajaran' => 'Bahasa Inggris Vokasi',
                'foto' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('guru_staf')->insert($guru);

        // 11. Minimal 6 Fasilitas Sekolah
        $tenantDb->table('fasilitas')->truncate();
        $fasilitas = [
            [
                'nama_fasilitas' => 'Bengkel Pemesinan Presisi & CNC Center',
                'deskripsi' => 'Dilengkapi 12 unit mesin bubut konvensional, 8 mesin frais, serta 4 unit CNC Lathe dan CNC Milling modern berstandar industri manufaktur.',
                'foto_utama' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Laboratorium Cloud & Software Engineering',
                'deskripsi' => 'Ruang komputasi ber-AC dengan 40 unit PC workstation Core i7/16GB RAM, koneksi internet gigabit fiber optic, dan smart display interaktif.',
                'foto_utama' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Studio Animasi & Render Farm',
                'deskripsi' => 'Fasilitas produksi animasi 2D/3D lengkap dengan pen display drawing tablet Cintiq, studio dubbing kedap suara, dan render server mandiri.',
                'foto_utama' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Workshop Fabrikasi Logam & Pengelasan Modern',
                'deskripsi' => 'Bilik las individu dengan sistem exhaust sirkulasi udara standar K3, dilengkapi mesin las SMAW, TIG inverter, dan mesin potong plasma.',
                'foto_utama' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Perpustakaan Digital Graha Pustaka',
                'deskripsi' => 'Menyediakan ribuan koleksi buku teks teknik, jurnal internasional, e-book reader, ruang diskusi kubikel, dan lounge literasi yang nyaman.',
                'foto_utama' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Aula Serbaguna Graha Wiyata',
                'deskripsi' => 'Gedung pertemuan berkapasitas 1.000 orang dengan tata suara akustik profesional untuk pameran TEFA, job fair, wisuda, dan pentas seni.',
                'foto_utama' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('fasilitas')->insert($fasilitas);

        // 12. Minimal 3 Album Galeri (+ Item Galeri)
        $tenantDb->table('galeri_album')->truncate();
        $tenantDb->table('galeri_item')->truncate();
        $album = [
            [
                'id' => 1,
                'nama_album' => 'Kegiatan Masa Pengenalan Lingkungan Sekolah (MPLS) & Bela Negara 2025/2026',
                'slug' => 'mpls-bela-negara-2025-2026',
                'tipe' => 'foto',
                'deskripsi' => 'Rangkaian upacara penerimaan siswa baru, pengenalan budaya kerja industri, dan latihan dasar kepemimpinan.',
                'cover_album' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_album' => 'Dokumentasi Gelar Inovasi TEFA Expo & Pameran Produk Siswa',
                'slug' => 'dokumentasi-tefa-expo-pameran-produk',
                'tipe' => 'foto',
                'deskripsi' => 'Dokumentasi stand pameran karya kejuruan dari 7 program keahlian di Aula Graha Wiyata SMKN 2 Bandung.',
                'cover_album' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_album' => 'Lomba Kompetensi Siswa (LKS) SMK Tingkat Wilayah & Nasional',
                'slug' => 'lomba-kompetensi-siswa-lks',
                'tipe' => 'foto',
                'deskripsi' => 'Momen perjuangan kontingen siswa dan guru pembimbing dalam kompetisi vokasi bergengsi tingkat nasional.',
                'cover_album' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('galeri_album')->insert($album);

        $galeriItems = [
            // Album 1
            ['album_id' => 1, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Upacara Pembukaan MPLS di Lapangan Utama', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => 1, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Latihan Baris Berbaris Kedisiplinan', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => 1, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Penyematan Atribut Peserta Didik Baru', 'created_at' => now(), 'updated_at' => now()],

            // Album 2
            ['album_id' => 2, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Pengunjung Antusias Mengunjungi Booth PPLG & Game', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => 2, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Demonstrasi Produk Mesin Bubut CNC', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => 2, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Pameran Fotografi dan Desain Komunikasi Visual', 'created_at' => now(), 'updated_at' => now()],

            // Album 3
            ['album_id' => 3, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Penerimaan Medali Emas LKS Nasional', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => 3, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Fokus Saat Ujian Praktik Pemrograman', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('galeri_item')->insert($galeriItems);

        // 13. Halaman Statis (Sejarah, Visi-Misi, Profil Sekolah, Kurikulum, OSIS, SPMB)
        $tenantDb->table('halaman_statis')->truncate();
        $halaman = [
            [
                'judul' => 'Sejarah Singkat SMK Negeri 2 Bandung',
                'slug' => 'sejarah',
                'isi_konten' => '<p>SMK Negeri 2 Bandung memiliki rekam jejak panjang dalam sejarah pendidikan vokasi Indonesia. Berdiri sejak tahun 1951, awalnya institusi ini dirintis sebagai Sekolah Teknik Menengah (STM) Negeri 1 Bandung yang berlokasi di kawasan bersejarah Kota Bandung.</p><p>Seiring pesatnya laju industri manufaktur dan teknologi informasi di Jawa Barat, sekolah bertransformasi menjadi SMK Negeri 2 Bandung dengan predikat Sekolah Menengah Kejuruan Pusat Keunggulan (SMK PK). Hingga kini, SMKN 2 Bandung telah meluluskan puluhan ribu teknisi andal, technopreneur, dan profesional yang berkontribusi nyata di kancah nasional maupun internasional.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Visi, Misi, dan Tujuan Sekolah',
                'slug' => 'visi-misi',
                'isi_konten' => '<h3>Visi Sekolah</h3><p class="text-lg font-semibold text-slate-800">"Menjadi Lembaga Pendidikan Kejuruan Terdepan Berdaya Saing Global, Berkarakter Pancasila, Berwawasan Lingkungan, dan Berbasis Industri Unggul pada Tahun 2030."</p><h3 class="mt-6">Misi Sekolah</h3><ul class="list-disc pl-5 space-y-2"><li>Menyelenggarakan kurikulum berbasis kompetensi industri dan teaching factory (TEFA) yang adaptif dan inovatif.</li><li>Membina karakter peserta didik yang bertakwa, berintegritas, mandiri, dan berbudaya kerja profesional.</li><li>Meningkatkan kualitas sumber daya pendidik dan tenaga kependidikan bersertifikasi kompetensi industri.</li><li>Memperluas jejaring kemitraan strategis dengan Dunia Usaha, Dunia Industri, dan Dunia Kerja (DUDIKA) dalam dan luar negeri.</li><li>Menyediakan sarana dan prasarana pembelajaran mutakhir yang ramah lingkungan dan inklusif.</li></ul><h3 class="mt-6">Tujuan Satuan Pendidikan</h3><p>Mencetak lulusan BMW: <strong>Bekerja</strong> di industri ternama dengan upah layak, <strong>Melanjutkan</strong> pendidikan tinggi vokasi/akademik, atau <strong>Berwirausaha</strong> mandiri berbasis teknologi (technopreneur).</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Profil Singkat & Nilai Budaya Sekolah',
                'slug' => 'profil',
                'isi_konten' => '<p>SMK Negeri 2 Bandung beralamat di Jalan Ciliwung No. 4, Kelurahan Cihapit, Kecamatan Bandung Wetan, Kota Bandung. Terakreditasi A dengan nomor NPSN 20219146. Saat ini membina 1.972 siswa aktif yang terbagi dalam 54 rombongan belajar dan diampu oleh 98 guru serta tenaga kependidikan berdedikasi tinggi.</p><p>Kami menanamkan 5 Nilai Budaya Kerja: <strong>Integritas, Disiplin, Inovasi, Kerjasama, dan Keselamatan (K3)</strong> dalam seluruh denyut aktivitas belajar mengajar sehari-hari.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Sistem Penerimaan Murid Baru (SPMB / PPDB) 2026/2027',
                'slug' => 'spmb',
                'isi_konten' => '<p>Penerimaan Peserta Didik Baru (PPDB) SMK Negeri 2 Bandung dilaksanakan secara objektif, transparan, dan akuntabel sesuai Petunjuk Teknis Dinas Pendidikan Provinsi Jawa Barat.</p><h3>Jalur Penerimaan</h3><ol class="list-decimal pl-5 space-y-2"><li><strong>Tahap 1:</strong> Jalur Afirmasi (KETM), Prioritas Terdekat (Zonasi), dan Perpindahan Tugas Orang Tua/Wali.</li><li><strong>Tahap 2:</strong> Jalur Prestasi Nilai Rapor Umum dan Jalur Prestasi Kejuaraan (Akademik/Non-Akademik).</li></ol><h3 class="mt-6">Persyaratan Umum</h3><ul class="list-disc pl-5 space-y-1"><li>Lulus SMP/MTs sederajat tahun 2026 atau lulusan 2025 yang belum terdaftar di SMA/SMK.</li><li>Berusia maksimal 21 tahun per 1 Juli 2026.</li><li>Memiliki Ijazah / Surat Keterangan Lulus (SKL) dan Akta Kelahiran.</li><li>Tidak buta warna untuk program keahlian Teknik Mesin, TPFL, TJKT, DKV, dan Animasi.</li></ul><p class="mt-4">Pendaftaran resmi dapat diakses melalui portal Disdik Jabar: <a href="https://ppdb.jabarprov.go.id" target="_blank" class="text-indigo-600 underline font-semibold">https://ppdb.jabarprov.go.id</a></p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kurikulum Merdeka Vokasi Berbasis Industri',
                'slug' => 'kurikulum',
                'isi_konten' => '<p>SMK Negeri 2 Bandung menerapkan Kurikulum Merdeka yang diselaraskan secara komprehensif dengan standar kompetensi industri rekanan (link & match 8+i). Pembelajaran mengedepankan Project-Based Learning dan Teaching Factory.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Organisasi Kesiswaan: OSIS & MPK',
                'slug' => 'osis',
                'isi_konten' => '<p>Organisasi Siswa Intra Sekolah (OSIS) dan Majelis Perwakilan Kelas (MPK) SMK Negeri 2 Bandung merupakan wadah demokrasi, kepemimpinan, dan penyalur aspirasi seluruh peserta didik dalam mewujudkan iklim sekolah yang dinamis, kreatif, dan harmonis.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $tenantDb->table('halaman_statis')->insert($halaman);

        // 14. Struktur Organisasi
        $tenantDb->table('struktur_organisasi')->truncate();
        $struktur = [
            ['nama_lengkap' => 'Dr. H. Hasanudin, M.Pd.', 'jabatan' => 'Kepala Sekolah', 'urutan' => 1, 'foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Dra. Hj. Siti Aminah, M.Si.', 'jabatan' => 'Wakasek Bidang Kurikulum', 'urutan' => 2, 'foto' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Budi Santoso, S.Pd., M.T.', 'jabatan' => 'Wakasek Bidang Kesiswaan', 'urutan' => 3, 'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Drs. Yayat Supriatna', 'jabatan' => 'Wakasek Hubungan Industri (Hubin)', 'urutan' => 4, 'foto' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Ir. Hendra Gunawan, S.T.', 'jabatan' => 'Wakasek Sarana & Prasarana', 'urutan' => 5, 'foto' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Tono Suciono, S.AP.', 'jabatan' => 'Kepala Tata Usaha', 'urutan' => 6, 'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=400&auto=format&fit=crop', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('struktur_organisasi')->insert($struktur);

        // 15. Navigasi Menus Terstruktur
        $tenantDb->table('menus')->truncate();

        // 1. Beranda
        $tenantDb->table('menus')->insert([
            'id' => 1, 'name' => 'Beranda', 'url' => '/', 'parent_id' => null, 'urutan' => 1, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now(),
        ]);

        // 2. Profil Sekolah (Dropdown)
        $tenantDb->table('menus')->insert([
            'id' => 2, 'name' => 'Profil', 'url' => '#', 'parent_id' => null, 'urutan' => 2, 'is_aktif' => true, 'type' => 'dropdown', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $tenantDb->table('menus')->insert([
            ['id' => 21, 'name' => 'Profil Lengkap', 'url' => '/profil', 'parent_id' => 2, 'urutan' => 1, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Sejarah Sekolah', 'url' => '/profil/sejarah', 'parent_id' => 2, 'urutan' => 2, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Visi & Misi', 'url' => '/profil/visi-misi', 'parent_id' => 2, 'urutan' => 3, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Struktur Organisasi', 'url' => '/profil/struktur', 'parent_id' => 2, 'urutan' => 4, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Guru & Staf', 'url' => '/guru-staf', 'parent_id' => 2, 'urutan' => 5, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Fasilitas Sekolah', 'url' => '/fasilitas', 'parent_id' => 2, 'urutan' => 6, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Program Keahlian (Dropdown 7 Jurusan)
        $tenantDb->table('menus')->insert([
            'id' => 3, 'name' => 'Program Keahlian', 'url' => '/program-keahlian', 'parent_id' => null, 'urutan' => 3, 'is_aktif' => true, 'type' => 'dropdown', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $tenantDb->table('menus')->insert([
            ['id' => 31, 'name' => 'Semua Program Keahlian', 'url' => '/program-keahlian', 'parent_id' => 3, 'urutan' => 1, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Teknik Mesin', 'url' => '/program-keahlian/teknik-mesin', 'parent_id' => 3, 'urutan' => 2, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Teknik Pengelasan & Fabrikasi', 'url' => '/program-keahlian/teknik-pengelasan-dan-fabrikasi-logam', 'parent_id' => 3, 'urutan' => 3, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'PPLG (Software & Game)', 'url' => '/program-keahlian/pengembangan-perangkat-lunak-dan-gim', 'parent_id' => 3, 'urutan' => 4, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'TJKT (Jaringan Komputer)', 'url' => '/program-keahlian/teknik-jaringan-komputer-dan-telekomunikasi', 'parent_id' => 3, 'urutan' => 5, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Desain Komunikasi Visual', 'url' => '/program-keahlian/desain-komunikasi-visual', 'parent_id' => 3, 'urutan' => 6, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Animasi (2D/3D)', 'url' => '/program-keahlian/animasi', 'parent_id' => 3, 'urutan' => 7, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Desain Gambar Mesin', 'url' => '/program-keahlian/desain-gambar-mesin', 'parent_id' => 3, 'urutan' => 8, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Informasi (Dropdown)
        $tenantDb->table('menus')->insert([
            'id' => 4, 'name' => 'Informasi', 'url' => '#', 'parent_id' => null, 'urutan' => 4, 'is_aktif' => true, 'type' => 'dropdown', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $tenantDb->table('menus')->insert([
            ['id' => 41, 'name' => 'Berita Sekolah', 'url' => '/berita', 'parent_id' => 4, 'urutan' => 1, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'Pengumuman Resmi', 'url' => '/pengumuman', 'parent_id' => 4, 'urutan' => 2, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'Agenda Kegiatan', 'url' => '/agenda', 'parent_id' => 4, 'urutan' => 3, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'Dokumentasi Kegiatan', 'url' => '/kegiatan', 'parent_id' => 4, 'urutan' => 4, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'Galeri Foto & Video', 'url' => '/galeri', 'parent_id' => 4, 'urutan' => 5, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Kesiswaan (Dropdown)
        $tenantDb->table('menus')->insert([
            'id' => 5, 'name' => 'Kesiswaan', 'url' => '#', 'parent_id' => null, 'urutan' => 5, 'is_aktif' => true, 'type' => 'dropdown', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $tenantDb->table('menus')->insert([
            ['id' => 51, 'name' => 'Prestasi Siswa', 'url' => '/prestasi', 'parent_id' => 5, 'urutan' => 1, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'name' => 'Ekstrakurikuler', 'url' => '/ekstrakurikuler', 'parent_id' => 5, 'urutan' => 2, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'name' => 'OSIS & MPK', 'url' => '/kesiswaan/osis', 'parent_id' => 5, 'urutan' => 3, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. SPMB
        $tenantDb->table('menus')->insert([
            'id' => 6, 'name' => 'SPMB 2026', 'url' => '/spmb', 'parent_id' => null, 'urutan' => 6, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now(),
        ]);

        // 7. Kontak
        $tenantDb->table('menus')->insert([
            'id' => 7, 'name' => 'Kontak', 'url' => '/kontak', 'parent_id' => null, 'urutan' => 7, 'is_aktif' => true, 'type' => 'link', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $tenantDb->statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
