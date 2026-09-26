<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PengaturanFitur extends Model
{
    protected $connection = 'tenant';

    protected $table = 'pengaturan_fitur';

    protected $fillable = [
        'kode_fitur',
        'nama_fitur',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    /**
     * Memeriksa apakah fitur tertentu aktif untuk tenant saat ini.
     */
    public static function isAktif(string $kodeFitur, bool $default = true): bool
    {
        try {
            $fitur = static::where('kode_fitur', $kodeFitur)->first();

            return $fitur ? (bool) $fitur->is_aktif : $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Set status aktif fitur.
     */
    public static function setAktif(string $kodeFitur, string $namaFitur, bool $isAktif): self
    {
        return static::updateOrCreate(
            ['kode_fitur' => $kodeFitur],
            ['nama_fitur' => $namaFitur, 'is_aktif' => $isAktif]
        );
    }
}
