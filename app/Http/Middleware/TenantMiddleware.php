<?php

namespace App\Http\Middleware;

use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

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

        $tenantSlug = $request->route('tenant');

        if (! $tenantSlug) {
            // Jika bukan route tenant (misal api/superadmin), lanjutkan saja
            return $next($request);
        }

        // Try to find the tenant by slug
        $sekolah = Sekolah::where('slug', $tenantSlug)->first();

        // Fallback for local development if no tenant found by slug, maybe domain?
        if (! $sekolah) {
            $host = $request->getHost();
            $httpHost = $request->getHttpHost();

            $domain = DomainSekolah::where('domain', $host)
                ->orWhere('domain', $httpHost)
                ->with('sekolah')
                ->first();

            $sekolah = $domain ? $domain->sekolah : null;
        }

        if (! $sekolah) {
            abort(404, "Sekolah dengan identifier {$tenantSlug} tidak ditemukan.");
        }

        if (! $sekolah->status_aktif) {
            abort(403, 'Akses sekolah dinonaktifkan.');
        }

        // Set tenant in the app container
        app()->instance('tenant', $sekolah);

        // Remove tenant parameter from URL generation so we don't have to pass it manually
        URL::defaults(['tenant' => $tenantSlug]);
        $request->route()->forgetParameter('tenant');

        // Switch Database connection to the tenant's database
        $tenantDbName = 'tenant_'.str_replace('-', '_', app('tenant')->slug);

        // We will configure a dynamic database connection
        \config(['database.connections.tenant' => array_merge(
            \config('database.connections.mysql'),
            ['database' => $tenantDbName]
        )]);

        \DB::purge('tenant');
        \DB::reconnect('tenant');
        \DB::setDefaultConnection('tenant');

        return $next($request);
    }
}
