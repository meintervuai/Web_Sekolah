<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class GaleriAlbum extends Model
{
    protected $connection = 'tenant';

    protected $table = 'galeri_album';

    protected $fillable = [
        'nama_album',
        'slug',
        'tipe',
        'deskripsi',
        'cover_album',
    ];

    public function items()
    {
        return $this->hasMany(GaleriItem::class, 'album_id');
    }
}
