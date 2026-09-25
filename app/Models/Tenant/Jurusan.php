<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'ikon_atau_foto',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];
}
