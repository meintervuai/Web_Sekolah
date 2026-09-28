<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $connection = 'tenant';

    protected $table = 'agenda';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'deskripsi_lengkap',
        'tgl_mulai',
        'tgl_selesai',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'penyelenggara',
        'gambar_sampul',
        'link_pendaftaran',
        'pengguna_id',
        'is_aktif',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeMendatang($query)
    {
        return $query->where('tgl_mulai', '>=', now()->toDateString())->orderBy('tgl_mulai', 'asc');
    }
}
