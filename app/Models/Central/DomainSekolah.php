<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainSekolah extends Model
{
    use HasFactory;

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
    protected $table = 'domain_sekolah';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sekolah_id',
        'domain',
    ];

    /**
     * Relasi ke entitas sekolah induk.
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }
}
