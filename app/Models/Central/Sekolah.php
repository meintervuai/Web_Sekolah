<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    use HasFactory, HasUuids;

    /**
     * Database connection untuk model central.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'sekolah';

    /**
     * Tipe primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Primary key auto incrementing status.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'super_admin_id',
        'nama_sekolah',
        'slug',
        'jenjang',
        'status_aktif',
        'tgl_berakhir',
        'data',
    ];

    /**
     * Tipe casting atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
            'tgl_berakhir' => 'date',
            'data' => 'array',
        ];
    }

    /**
     * Relasi ke Super Admin pengelola.
     */
    public function superAdmin(): BelongsTo
    {
        return $this->belongsTo(SuperAdmin::class, 'super_admin_id');
    }

    /**
     * Relasi ke domain sekolah.
     */
    public function domains(): HasMany
    {
        return $this->hasMany(DomainSekolah::class, 'sekolah_id', 'id');
    }
}
