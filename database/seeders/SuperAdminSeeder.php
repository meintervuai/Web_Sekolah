<?php

namespace Database\Seeders;

use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;
use App\Models\Central\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Super Admin
        $superAdmin = SuperAdmin::firstOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'nama' => 'Super Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Data Awal Sekolah (Tenants)
        $schools = [
            [
                'nama_sekolah' => 'SD Negeri 01 Pagi Jakarta',
                'jenjang' => 'SD',
                'status_aktif' => true,
                'tgl_berakhir' => now()->addYear(),
                'domain' => 'sdn01pagi.test',
                'data' => [
                    'telepon' => '021-12345678',
                    'email' => 'info@sdn01pagi.sch.id',
                    'alamat' => 'Jl. Pendidikan No. 1, Jakarta Pusat',
                ],
            ],
            [
                'nama_sekolah' => 'SMP Negeri 1 Surabaya',
                'jenjang' => 'SMP',
                'status_aktif' => true,
                'tgl_berakhir' => now()->addMonths(8),
                'domain' => 'smpn1sby.test',
                'data' => [
                    'telepon' => '031-87654321',
                    'email' => 'kontak@smpn1sby.sch.id',
                    'alamat' => 'Jl. Pemuda No. 10, Surabaya',
                ],
            ],
            [
                'nama_sekolah' => 'SMK Negeri 2 Bandung',
                'jenjang' => 'SMK',
                'status_aktif' => true,
                'tgl_berakhir' => now()->addMonths(11),
                'domain' => 'smkn2bdg.test',
                'data' => [
                    'telepon' => '022-99887766',
                    'email' => 'admin@smkn2bdg.sch.id',
                    'alamat' => 'Jl. Cihampelas No. 45, Bandung',
                ],
            ],
            [
                'nama_sekolah' => 'SMA Nusantara Harapan',
                'jenjang' => 'SMA',
                'status_aktif' => false,
                'tgl_berakhir' => now()->subDays(5),
                'domain' => 'smanusantara.test',
                'data' => [
                    'telepon' => '021-55443322',
                    'email' => 'tu@smanusantara.sch.id',
                    'alamat' => 'Jl. Merdeka Barat No. 8, Tangerang',
                ],
            ],
        ];

        foreach ($schools as $item) {
            $sekolah = Sekolah::firstOrCreate(
                ['nama_sekolah' => $item['nama_sekolah']],
                [
                    'id' => (string) Str::uuid(),
                    'jenjang' => $item['jenjang'],
                    'status_aktif' => $item['status_aktif'],
                    'tgl_berakhir' => $item['tgl_berakhir'],
                    'data' => $item['data'],
                ]
            );

            DomainSekolah::firstOrCreate(
                ['domain' => $item['domain']],
                [
                    'sekolah_id' => $sekolah->id,
                ]
            );
        }
    }
}
