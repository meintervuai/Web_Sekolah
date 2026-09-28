<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    protected $connection = 'tenant';

    protected $table = 'prestasi_siswa';

    protected $fillable = [
        'nama_siswa',
        'nama_prestasi',
        'slug',
        'tingkat',
        'tanggal',
        'tahun',
        'foto',
        'deskripsi',
        'jurusan_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
