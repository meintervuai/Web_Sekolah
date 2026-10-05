<?php

use App\Models\Central\Sekolah;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tenants = Sekolah::all();

        foreach ($tenants as $sekolah) {
            $dbName = 'tenant_'.str_replace('-', '_', $sekolah->slug);
            try {
                $tenantConfig = config('database.connections.mysql');
                $tenantConfig['database'] = $dbName;
                config(['database.connections.tenant_migration' => $tenantConfig]);
                DB::purge('tenant_migration');

                $tenantDb = DB::connection('tenant_migration');

                // Cari menu kesiswaan induk
                $parentMenus = $tenantDb->table('menus')
                    ->where('name', 'like', '%Kesiswaan%')
                    ->orWhere('url', 'like', '%kesiswaan%')
                    ->get();

                foreach ($parentMenus as $parent) {
                    // Hapus sub-menu / children
                    $tenantDb->table('menus')->where('parent_id', $parent->id)->delete();
                    // Hapus menu induk
                    $tenantDb->table('menus')->where('id', $parent->id)->delete();
                }

                // Hapus sub-menu lepas yang URL-nya mengandung kesiswaan atau osis
                $tenantDb->table('menus')
                    ->where('url', 'like', '%/kesiswaan%')
                    ->orWhere('url', 'like', '%/osis%')
                    ->delete();
            } catch (Throwable $e) {
                // Lanjutkan jika DB tenant belum ada / konfigurasi berbeda
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menu kesiswaan sengaja tidak dikembalikan karena dipindah ke informasi/berita
    }
};
