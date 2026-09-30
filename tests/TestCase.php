<?php

namespace Tests;

use App\Models\Central\Sekolah;
use App\Models\Tenant\Pengguna;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @property Sekolah $sekolah
 * @property Pengguna $admin
 * @property string $tenantSlug
 */
abstract class TestCase extends BaseTestCase
{
    public ?Sekolah $sekolah = null;
    public ?Pengguna $admin = null;
    public ?string $tenantSlug = null;
}
