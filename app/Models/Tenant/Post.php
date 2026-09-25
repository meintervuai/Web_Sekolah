<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'artikel';

    protected $fillable = [
        'pengguna_id',
        'kategori_id',
        'judul',
        'slug',
        'ringkasan',
        'isi_konten',
        'gambar_sampul',
        'is_pengumuman',
        'status_publikasi',
        'tgl_publikasi',
        'jumlah_dilihat',
    ];

    protected $casts = [
        'is_pengumuman' => 'boolean',
        'tgl_publikasi' => 'datetime',
    ];
}
