<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'tenant';

    protected $table = 'halaman_statis';

    protected $fillable = [
        'judul',
        'subjudul',
        'slug',
        'isi_konten',
        'gambar_banner',
        'pola_latar',
        'pengguna_id',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
