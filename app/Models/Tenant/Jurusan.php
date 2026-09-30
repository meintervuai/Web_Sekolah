<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $connection = 'tenant';

    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'logo',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'informasi_tambahan',
        'ikon_atau_foto',
        'jenjang',
        'peluang_kerja',
        'sertifikasi',
        'urutan',
        'guru_id',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function kepalaProgram()
    {
        return $this->belongsTo(GuruStaf::class, 'guru_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoJurusan::class, 'jurusan_id')->orderBy('urutan');
    }

    public function pendaftar()
    {
        return $this->hasMany(PendaftarPpdb::class, 'pilihan_jurusan_id');
    }

    public function prestasi()
    {
        return $this->hasMany(PrestasiSiswa::class, 'jurusan_id');
    }

    /**
     * Helper CSS object-position dari media library.
     */
    public function getFotoFocalPositionAttribute(): string
    {
        return \App\Services\MediaService::getFocalPosition($this->ikon_atau_foto);
    }

    /**
     * Helper CSS Style lengkap untuk Smart Box Cropping (Zoom & Clip).
     */
    public function getFotoCropStyleAttribute(): string
    {
        return \App\Services\MediaService::getCropStyle($this->ikon_atau_foto);
    }
}
