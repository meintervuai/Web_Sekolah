<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $connection = 'tenant';

    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama_ekstrakurikuler',
        'slug',
        'deskripsi',
        'foto',
        'hari_jadwal',
        'waktu_jadwal',
        'pembina',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}
