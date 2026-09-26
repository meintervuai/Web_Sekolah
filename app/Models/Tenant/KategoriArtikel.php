<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class KategoriArtikel extends Model
{
    protected $connection = 'tenant';

    protected $table = 'kategori_artikel';

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    public function artikels()
    {
        return $this->hasMany(Post::class, 'kategori_id');
    }
}
