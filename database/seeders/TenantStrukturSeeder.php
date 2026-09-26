<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantStrukturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_lengkap' => 'Drs. H. Ahmad Sunarya, M.Pd.',
                'jabatan' => 'Kepala Sekolah',
                'urutan' => 1,
            ],
            [
                'nama_lengkap' => 'Budi Santoso, S.Pd., M.Si.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'urutan' => 2,
            ],
            [
                'nama_lengkap' => 'Siti Aminah, M.Pd.',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'urutan' => 3,
            ],
            [
                'nama_lengkap' => 'Drs. Wahyu Hidayat',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Sarana Prasarana',
                'urutan' => 4,
            ],
            [
                'nama_lengkap' => 'Dra. Rini Wulandari',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Humas',
                'urutan' => 5,
            ]
        ];

        foreach ($data as $item) {
            DB::connection('tenant')->table('struktur_organisasi')->insert([
                'id' => Str::uuid()->toString(),
                'nama_lengkap' => $item['nama_lengkap'],
                'jabatan' => $item['jabatan'],
                'foto' => null,
                'urutan' => $item['urutan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
