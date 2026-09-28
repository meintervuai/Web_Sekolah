<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'tenant';

    protected $table = 'halaman_statis';

    protected $fillable = [
        'judul',
        'slug',
        'isi_konten',
        'gambar_banner',
        'pengguna_id',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
