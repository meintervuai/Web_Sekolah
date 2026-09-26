<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class GaleriItem extends Model
{
    protected $connection = 'tenant';

    protected $table = 'galeri_item';

    protected $fillable = [
        'album_id',
        'file_media_atau_link',
        'judul_item',
    ];

    public function album()
    {
        return $this->belongsTo(GaleriAlbum::class, 'album_id');
    }
}
