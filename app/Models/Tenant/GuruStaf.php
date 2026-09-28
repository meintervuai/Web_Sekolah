<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class GuruStaf extends Model
{
    protected $connection = 'tenant';

    protected $table = 'guru_staf';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'jabatan',
        'mata_pelajaran',
        'foto',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function ekstrakurikulers()
    {
        return $this->hasMany(Ekstrakurikuler::class, 'guru_id');
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class, 'guru_id');
    }

    public function strukturOrganisasis()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'guru_id');
    }
}
