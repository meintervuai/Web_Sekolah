<?php

namespace App\Http\Middleware;

use App\Models\Tenant\PengaturanFitur;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantFeatureEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$fiturKodes  Satu atau lebih kode fitur yang salah satunya harus aktif (OR)
     */
    public function handle(Request $request, Closure $next, string ...$fiturKodes): Response
    {
        // Pastikan tenant terhubung
        if (! app()->bound('tenant')) {
            return $next($request);
        }

        if (empty($fiturKodes)) {
            return $next($request);
        }

        $anyAktif = false;
        foreach ($fiturKodes as $kode) {
            if (PengaturanFitur::isAktif($kode, true)) {
                $anyAktif = true;
                break;
            }
        }

        if (! $anyAktif) {
            // Jika request AJAX/JSON
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Modul/fitur ini sedang dinonaktifkan oleh Super Admin.',
                ], 403);
            }

            // Jika rute admin tenant, redirect ke dashboard profil dengan pesan flash info/error
            if ($request->is('*/admin/*') || $request->is('*/admin')) {
                $tenantSlug = app('tenant')->slug;

                return redirect()->route('tenant.admin.profil.index', ['tenant' => $tenantSlug])
                    ->with('error', 'Akses ditolak: Modul ini sedang dinonaktifkan oleh Super Admin.');
            }

            // Jika rute publik, tampilkan 404
            abort(404, 'Halaman ini saat ini tidak diaktifkan oleh sekolah.');
        }

        return $next($request);
    }
}
