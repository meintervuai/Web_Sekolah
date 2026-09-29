<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'tenant';

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
        'foto_profil',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi artikel/post yang ditulis pengguna.
     */
    public function artikels()
    {
        return $this->hasMany(Post::class, 'pengguna_id');
    }

    /**
     * Relasi agenda kegiatan yang dibuat pengguna.
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'pengguna_id');
    }

    public function unduhans()
    {
        return $this->hasMany(Unduhan::class, 'pengguna_id');
    }

    public function sliderBerandas()
    {
        return $this->hasMany(SliderBeranda::class, 'pengguna_id');
    }

    public function halamanStatis()
    {
        return $this->hasMany(HalamanStatis::class, 'pengguna_id');
    }

    public function kalenderAkademiks()
    {
        return $this->hasMany(KalenderAkademik::class, 'pengguna_id');
    }

    public function pesanMasuks()
    {
        return $this->hasMany(PesanMasuk::class, 'petugas_id');
    }

    public function sosialMedias()
    {
        return $this->hasMany(SosialMedia::class, 'pengguna_id');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'pengguna_id');
    }
}
