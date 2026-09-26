<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $connection = 'tenant';

    protected $table = 'fasilitas';

    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
        'foto_utama',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function fotoLainnya()
    {
        return $this->hasMany(FotoFasilitas::class, 'fasilitas_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}
