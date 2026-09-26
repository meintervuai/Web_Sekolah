<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class FotoFasilitas extends Model
{
    protected $connection = 'tenant';

    protected $table = 'foto_fasilitas';

    protected $fillable = [
        'fasilitas_id',
        'file_foto',
        'keterangan',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }
}
