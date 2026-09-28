<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SuperAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

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
    protected $table = 'super_admin';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * Atribut yang harus disembunyikan dalam serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe casting atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi sekolah yang dikelola/dibuat super admin.
     */
    public function sekolahs(): HasMany
    {
        return $this->hasMany(Sekolah::class, 'super_admin_id');
    }
}
