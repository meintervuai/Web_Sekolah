<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('inspect:superadmin', function () {
    $admins = \App\Models\Central\SuperAdmin::all();
    $this->info("Total SuperAdmin: " . $admins->count());
    foreach ($admins as $admin) {
        $check = \Illuminate\Support\Facades\Hash::check('password123', $admin->password);
        $this->line("ID: {$admin->id} | Email: {$admin->email} | Nama: {$admin->nama} | PasswordMatch('password123'): " . ($check ? 'YES' : 'NO'));
    }
});
