<?php

namespace App\Console\Commands;

use App\Models\Central\Sekolah;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

#[Signature('tenants:migrate {--refresh : Refresh the database} {--seed : Seed the database}')]
#[Description('Run migrations for all tenant databases')]
class MigrateTenants extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting tenant migrations...');

        $sekolahs = Sekolah::all();

        if ($sekolahs->isEmpty()) {
            $this->warn('No tenants found.');

            return;
        }

        foreach ($sekolahs as $sekolah) {
            $slug_db = str_replace('-', '_', $sekolah->slug);
            $dbName = 'tenant_'.$slug_db;

            $this->info("Migrating tenant: {$sekolah->nama_sekolah} (DB: {$dbName})");

            // Create database if not exists using central connection
            $centralConnection = DB::connection('mysql');
            $centralConnection->statement("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Set connection configuration dynamically
            Config::set('database.connections.tenant.database', $dbName);
            DB::purge('tenant');
            DB::reconnect('tenant');

            $options = [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ];

            try {
                if ($this->option('seed')) {
                    // Remove --seed from migrate options because it would run DatabaseSeeder (SuperAdmin)
                    $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';
                    Artisan::call($command, $options, $this->output);

                    $this->info("Seeding tenant: {$sekolah->nama_sekolah}");
                    $seederClass = ($sekolah->slug === 'smk-negeri-2-bandung') ? 'TenantSmkn2BandungSeeder' : 'TenantDummySeeder';
                    Artisan::call('db:seed', [
                        '--database' => 'tenant',
                        '--class' => $seederClass,
                        '--force' => true,
                    ], $this->output);
                } else {
                    $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';
                    Artisan::call($command, $options, $this->output);
                }
                $this->info("Successfully migrated tenant: {$sekolah->nama_sekolah}");
            } catch (\Exception $e) {
                $this->error("Failed to migrate tenant: {$sekolah->nama_sekolah}. Error: ".$e->getMessage());
            }
        }

        $this->info('All tenant migrations completed.');
    }
}
