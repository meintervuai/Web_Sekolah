<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PesanMasuk extends Model
{
    protected $connection = 'tenant';

    protected $table = 'pesan_masuk';

    protected $fillable = [
        'nama_pengirim',
        'email_pengirim',
        'no_telepon',
        'subjek',
        'pesan',
        'is_dibaca',
    ];

    protected $casts = [
        'is_dibaca' => 'boolean',
    ];
}
