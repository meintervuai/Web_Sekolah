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
        $tenantDb->statement('SET FOREIGN_KEY_CHECKS=0;');

        // 0. Akun Pengguna Admin
        $tenantDb->table('pengguna')->truncate();
        $tenantDb->table('pengguna')->insert([
            [
                'id' => 1,
                'nama' => 'Administrator Sekolah',
                'email' => 'admin@admin.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'peran' => 'admin',
                'foto_profil' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Halaman Statis
        $tenantDb->table('halaman_statis')->truncate();
        $halaman_statis = [
            [
                'judul' => 'Sejarah Sekolah',
                'slug' => 'sejarah',
                'isi_konten' => '<p>SMK Negeri 2 Bandung berdiri sejak tahun 1951, berawal dari Sekolah Teknik Menengah (STM) Negeri 1 Bandung. Seiring dengan perkembangan teknologi dan kebutuhan industri, sekolah ini bertransformasi menjadi SMK Negeri 2 Bandung yang fokus pada bidang teknologi dan rekayasa.</p><p>Visi kami adalah menghasilkan lulusan yang kompeten, berkarakter, dan siap bersaing di era global.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'isi_konten' => '<h3>Visi</h3><p>Menjadi lembaga pendidikan dan pelatihan kejuruan yang unggul, berwawasan lingkungan, dan berdaya saing global pada tahun 2030.</p><h3>Misi</h3><ul><li>Menyelenggarakan pembelajaran yang berkualitas berbasis Teaching Factory (TEFA).</li><li>Meningkatkan kompetensi pendidik dan tenaga kependidikan sesuai dengan perkembangan IPTEK.</li><li>Membina karakter peserta didik yang beriman, bertakwa, dan berakhlak mulia.</li><li>Membangun kemitraan yang kuat dengan Dunia Usaha dan Dunia Industri (DUDI).</li></ul>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kurikulum',
                'slug' => 'kurikulum',
                'isi_konten' => '<p>SMK Negeri 2 Bandung menerapkan Kurikulum Merdeka yang memberikan keleluasaan kepada pendidik untuk menciptakan pembelajaran berkualitas yang sesuai dengan kebutuhan dan lingkungan belajar peserta didik.</p><p>Fokus utama kurikulum kami adalah pengembangan karakter Profil Pelajar Pancasila dan kompetensi keahlian yang relevan dengan kebutuhan industri.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'OSIS & MPK',
                'slug' => 'osis',
                'isi_konten' => '<p>Organisasi Siswa Intra Sekolah (OSIS) dan Majelis Perwakilan Kelas (MPK) adalah wadah pembinaan kesiswaan untuk mengembangkan minat, bakat, serta potensi kepemimpinan.</p><h3>Visi OSIS</h3><p>Mewujudkan siswa yang aktif, kreatif, inovatif, dan berakhlak mulia.</p>',
                'gambar_banner' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('halaman_statis')->insert($halaman_statis);

        // Struktur Organisasi
        $tenantDb->table('struktur_organisasi')->truncate();
        $struktur = [
            ['nama_lengkap' => 'Dr. H. Hasanudin, M.Pd.', 'jabatan' => 'Kepala Sekolah', 'urutan' => 1, 'foto' => 'https://randomuser.me/api/portraits/men/32.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Dra. Hj. Siti Aminah, M.Si.', 'jabatan' => 'Wakasek Kurikulum', 'urutan' => 2, 'foto' => 'https://randomuser.me/api/portraits/women/44.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Budi Santoso, S.Pd., M.T.', 'jabatan' => 'Wakasek Kesiswaan', 'urutan' => 3, 'foto' => 'https://randomuser.me/api/portraits/men/46.jpg', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('struktur_organisasi')->insert($struktur);

        // Guru & Staf
        $tenantDb->table('guru_staf')->truncate();
        $guru = [
            ['nama_lengkap' => 'Ahmad Hidayat, S.Kom.', 'jenis_kelamin' => 'L', 'jabatan' => 'Guru Produktif', 'mata_pelajaran' => 'Rekayasa Perangkat Lunak', 'foto' => 'https://randomuser.me/api/portraits/men/62.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Rina Marlina, S.Pd.', 'jenis_kelamin' => 'P', 'jabatan' => 'Guru Normatif', 'mata_pelajaran' => 'Bahasa Inggris', 'foto' => 'https://randomuser.me/api/portraits/women/65.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Joko Widodo, S.T.', 'jenis_kelamin' => 'L', 'jabatan' => 'Guru Produktif', 'mata_pelajaran' => 'Teknik Komputer Jaringan', 'foto' => 'https://randomuser.me/api/portraits/men/72.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Sari Indah, S.Sn.', 'jenis_kelamin' => 'P', 'jabatan' => 'Guru Produktif', 'mata_pelajaran' => 'Desain Komunikasi Visual', 'foto' => 'https://randomuser.me/api/portraits/women/75.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lengkap' => 'Tono Suciono, S.Pd.', 'jenis_kelamin' => 'L', 'jabatan' => 'Kepala Tata Usaha', 'mata_pelajaran' => null, 'foto' => 'https://randomuser.me/api/portraits/men/82.jpg', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('guru_staf')->insert($guru);

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

        // Fasilitas
        $tenantDb->table('fasilitas')->truncate();
        $fasilitas = [
            [
                'nama_fasilitas' => 'Laboratorium Komputer',
                'deskripsi' => 'Dilengkapi dengan 40 PC spesifikasi tinggi untuk praktek siswa.',
                'foto_utama' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Perpustakaan Digital',
                'deskripsi' => 'Menyediakan ribuan koleksi buku fisik dan e-book yang dapat diakses secara online.',
                'foto_utama' => 'https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Masjid Sekolah',
                'deskripsi' => 'Tempat ibadah yang luas dan nyaman, mampu menampung seluruh siswa.',
                'foto_utama' => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fasilitas' => 'Lapangan Olahraga',
                'deskripsi' => 'Fasilitas olahraga multifungsi untuk futsal, basket, dan voli.',
                'foto_utama' => 'https://images.unsplash.com/photo-1574629810360-7efbb1925846?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('fasilitas')->insert($fasilitas);

        // Ekstrakurikuler
        $tenantDb->table('ekstrakurikuler')->truncate();
        $ekskul = [
            [
                'nama_ekstrakurikuler' => 'Pramuka',
                'deskripsi' => 'Ekstrakurikuler wajib untuk membangun karakter mandiri dan disiplin.',
                'foto' => 'https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Jumat',
                'waktu_jadwal' => '14:00 - 16:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'Paskibra',
                'deskripsi' => 'Membentuk kedisiplinan dan rasa nasionalisme tinggi.',
                'foto' => 'https://images.unsplash.com/photo-1563207153-f4087b0a7018?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Rabu & Sabtu',
                'waktu_jadwal' => '15:30 - 17:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ekstrakurikuler' => 'PMR',
                'deskripsi' => 'Palang Merah Remaja, melatih kepedulian sosial dan kesehatan.',
                'foto' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=800&auto=format&fit=crop',
                'hari_jadwal' => 'Kamis',
                'waktu_jadwal' => '15:30 - 17:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('ekstrakurikuler')->insert($ekskul);

        // Prestasi Siswa
        $tenantDb->table('prestasi_siswa')->truncate();
        $prestasi = [
            [
                'nama_siswa' => 'Budi Santoso',
                'nama_prestasi' => 'Juara 1 Lomba Web Design Provinsi',
                'tingkat' => 'Provinsi',
                'tanggal' => '2026-05-15',
                'deskripsi' => 'Budi berhasil memenangkan lomba Web Design antar SMK se-Jawa Barat.',
                'foto' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_siswa' => 'Siti Aminah',
                'nama_prestasi' => 'Medali Emas Olimpiade Jaringan Nasional',
                'tingkat' => 'Nasional',
                'tanggal' => '2026-08-20',
                'deskripsi' => 'Siti meraih medali emas pada kompetisi instalasi jaringan tingkat nasional.',
                'foto' => 'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?q=80&w=800&auto=format&fit=crop',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        $tenantDb->table('prestasi_siswa')->insert($prestasi);
        // Kalender Akademik
        $tenantDb->table('kalender_akademik')->truncate();
        $kalender = [
            ['nama_kegiatan' => 'Awal Masuk Sekolah', 'tgl_mulai' => '2026-07-15', 'tgl_selesai' => '2026-07-15', 'keterangan' => 'Hari pertama masuk sekolah tahun ajaran 2026/2027', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kegiatan' => 'Masa Pengenalan Lingkungan Sekolah (MPLS)', 'tgl_mulai' => '2026-07-16', 'tgl_selesai' => '2026-07-18', 'keterangan' => 'Kegiatan pengenalan lingkungan bagi siswa baru', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kegiatan' => 'Penilaian Tengah Semester (PTS)', 'tgl_mulai' => '2026-09-20', 'tgl_selesai' => '2026-09-26', 'keterangan' => 'Ujian tengah semester ganjil', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kegiatan' => 'Penilaian Akhir Semester (PAS)', 'tgl_mulai' => '2026-12-05', 'tgl_selesai' => '2026-12-15', 'keterangan' => 'Ujian akhir semester ganjil', 'created_at' => now(), 'updated_at' => now()],
        ];
        $tenantDb->table('kalender_akademik')->insert($kalender);
        
        // Galeri
        $tenantDb->table('galeri_album')->truncate();
        $tenantDb->table('galeri_item')->truncate();
        
        $album1Id = $tenantDb->table('galeri_album')->insertGetId([
            'nama_album' => 'Kegiatan MPLS 2026',
            'slug' => 'kegiatan-mpls-2026',
            'tipe' => 'foto',
            'cover_album' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $tenantDb->table('galeri_item')->insert([
            ['album_id' => $album1Id, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Pembukaan', 'created_at' => now(), 'updated_at' => now()],
            ['album_id' => $album1Id, 'file_media_atau_link' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop', 'judul_item' => 'Kegiatan Kelas', 'created_at' => now(), 'updated_at' => now()],
        ]);


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

        // Seeding Menus
        $tenantDb->table('menus')->truncate();
        
        $menuBerandaId = $tenantDb->table('menus')->insertGetId(['name' => 'Beranda', 'url' => '/', 'type' => 'link', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()]);
        
        $menuProfilId = $tenantDb->table('menus')->insertGetId(['name' => 'Profil', 'url' => '#', 'type' => 'dropdown', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()]);
        $tenantDb->table('menus')->insert([
            ['name' => 'Sejarah Sekolah', 'url' => '/profil/sejarah', 'parent_id' => $menuProfilId, 'urutan' => 1, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Visi, Misi & Tujuan', 'url' => '/profil/visi-misi', 'parent_id' => $menuProfilId, 'urutan' => 2, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Struktur Organisasi', 'url' => '/profil/struktur', 'parent_id' => $menuProfilId, 'urutan' => 3, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fasilitas Sekolah', 'url' => '/profil/fasilitas', 'parent_id' => $menuProfilId, 'urutan' => 4, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guru & Tenaga Kependidikan', 'url' => '/profil/guru', 'parent_id' => $menuProfilId, 'urutan' => 5, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $menuAkademikId = $tenantDb->table('menus')->insertGetId(['name' => 'Akademik', 'url' => '#', 'type' => 'dropdown', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()]);
        
        // Program Keahlian sub-menu
        $menuProgramKeahlianId = $tenantDb->table('menus')->insertGetId(['name' => 'Program Keahlian', 'url' => '#', 'parent_id' => $menuAkademikId, 'type' => 'dropdown', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()]);
        $tenantDb->table('menus')->insert([
            ['name' => 'Teknik Komputer dan Jaringan', 'url' => '/akademik/jurusan/teknik-komputer-dan-jaringan', 'parent_id' => $menuProgramKeahlianId, 'urutan' => 1, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rekayasa Perangkat Lunak', 'url' => '/akademik/jurusan/rekayasa-perangkat-lunak', 'parent_id' => $menuProgramKeahlianId, 'urutan' => 2, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desain Komunikasi Visual', 'url' => '/akademik/jurusan/desain-komunikasi-visual', 'parent_id' => $menuProgramKeahlianId, 'urutan' => 3, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        $tenantDb->table('menus')->insert([
            ['name' => 'Kurikulum', 'url' => '/akademik/kurikulum', 'parent_id' => $menuAkademikId, 'urutan' => 2, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kalender Akademik', 'url' => '/akademik/kalender', 'parent_id' => $menuAkademikId, 'urutan' => 3, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $menuInformasiId = $tenantDb->table('menus')->insertGetId(['name' => 'Informasi', 'url' => '#', 'type' => 'dropdown', 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()]);
        $tenantDb->table('menus')->insert([
            ['name' => 'Berita & Artikel', 'url' => '/informasi/berita', 'parent_id' => $menuInformasiId, 'urutan' => 1, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengumuman', 'url' => '/informasi/pengumuman', 'parent_id' => $menuInformasiId, 'urutan' => 2, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Galeri', 'url' => '/informasi/galeri', 'parent_id' => $menuInformasiId, 'urutan' => 3, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        $menuKesiswaanId = $tenantDb->table('menus')->insertGetId(['name' => 'Kesiswaan', 'url' => '#', 'type' => 'dropdown', 'urutan' => 5, 'created_at' => now(), 'updated_at' => now()]);
        $tenantDb->table('menus')->insert([
            ['name' => 'Organisasi Siswa (OSIS)', 'url' => '/kesiswaan/osis', 'parent_id' => $menuKesiswaanId, 'urutan' => 1, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ekstrakurikuler', 'url' => '/kesiswaan/ekstrakurikuler', 'parent_id' => $menuKesiswaanId, 'urutan' => 2, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prestasi Siswa', 'url' => '/kesiswaan/prestasi', 'parent_id' => $menuKesiswaanId, 'urutan' => 3, 'type' => 'link', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        $tenantDb->statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
