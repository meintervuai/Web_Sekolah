<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ignore superadmin routes
        if ($request->is('superadmin*') || $request->is('api/superadmin*')) {
            return $next($request);
        }

        $host = $request->getHost();
        $httpHost = $request->getHttpHost(); // includes port like 127.0.0.1:8000

        // Try to find the tenant by domain or domain with port
        $domain = DomainSekolah::where('domain', $host)
                    ->orWhere('domain', $httpHost)
                    ->with('sekolah')
                    ->first();

        // Fallback for local development if no tenant found
        if (!$domain && app()->environment('local')) {
            $sekolah = Sekolah::first();
            if (!$sekolah) {
                abort(404, "Tidak ada data sekolah untuk fallback lokal.");
            }
        } else {
            $sekolah = $domain ? $domain->sekolah : null;
        }

        if (!$sekolah) {
            abort(404, "Sekolah untuk domain {$host} tidak ditemukan.");
        }

        if (!$sekolah->status_aktif) {
            abort(403, 'Akses sekolah dinonaktifkan.');
        }

        // Set tenant in the app container
        app()->instance('tenant', $domain ? $domain->sekolah : $sekolah);

        // Switch Database connection to the tenant's database
        $tenantDbName = 'tenant_' . str_replace('-', '_', app('tenant')->id);
        
        // We will configure a dynamic database connection
        \config(['database.connections.tenant' => array_merge(
            \config('database.connections.mysql'),
            ['database' => $tenantDbName]
        )]);
        
        \DB::setDefaultConnection('tenant');

        return $next($request);
    }
}
