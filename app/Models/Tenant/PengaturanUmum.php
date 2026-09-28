<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PengaturanUmum extends Model
{
    protected $connection = 'tenant';

    protected $table = 'pengaturan_umum';

    protected $fillable = [
        'kunci',
        'nilai',
        'pengguna_id',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * Helper to get single setting value.
     */
    public static function ambil(string $kunci, ?string $default = null): ?string
    {
        return static::where('kunci', $kunci)->value('nilai') ?? $default;
    }

    /**
     * Helper to set single setting value.
     */
    public static function simpan(string $kunci, ?string $nilai): self
    {
        return static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
    }
}
