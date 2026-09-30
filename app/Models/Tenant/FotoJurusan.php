<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class FotoJurusan extends Model
{
    protected $connection = 'tenant';

    protected $table = 'foto_jurusan';

    protected $fillable = [
        'jurusan_id',
        'file_foto',
        'judul',
        'urutan',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Helper CSS Style lengkap untuk Smart Box Cropping.
     */
    public function getFotoCropStyleAttribute(): string
    {
        return \App\Services\MediaService::getCropStyle($this->file_foto);
    }
}
