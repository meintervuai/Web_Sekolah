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
}
