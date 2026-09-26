<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $connection = 'tenant';

    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'nama_lengkap',
        'jabatan',
        'foto',
        'urutan',
    ];
}
