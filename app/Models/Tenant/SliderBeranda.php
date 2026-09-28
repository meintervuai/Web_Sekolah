<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class SliderBeranda extends Model
{
    protected $connection = 'tenant';

    protected $table = 'slider_beranda';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'video',
        'link_tombol',
        'teks_tombol',
        'urutan',
        'pengguna_id',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true)->orderBy('urutan', 'asc');
    }
}
