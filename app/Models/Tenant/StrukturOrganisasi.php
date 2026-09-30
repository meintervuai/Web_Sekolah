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
        'guru_id',
    ];

    public function guru()
    {
        return $this->belongsTo(GuruStaf::class, 'guru_id');
    }

    /**
     * Helper CSS object-position dari media library.
     */
    public function getFotoFocalPositionAttribute(): string
    {
        return \App\Services\MediaService::getFocalPosition($this->foto);
    }

    /**
     * Helper CSS Style lengkap untuk Smart Box Cropping (Zoom & Clip).
     */
    public function getFotoCropStyleAttribute(): string
    {
        return \App\Services\MediaService::getCropStyle($this->foto);
    }
}
