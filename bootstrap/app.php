<?php

use App\Http\Middleware\TenantMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Contracts\Session\Middleware\AuthenticatesSessions;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->priority([
            HandlePrecognitiveRequests::class,
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            TenantMiddleware::class,
            AuthenticatesRequests::class,
            Authenticate::class,
            ThrottleRequests::class,
            ThrottleRequestsWithRedis::class,
            AuthenticatesSessions::class,
            SubstituteBindings::class,
            Authorize::class,
        ]);

        $middleware->web(append: [
            // \App\Http\Middleware\TenantMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('superadmin*')) {
                return route('superadmin.login');
            }

            // Jika dalam konteks tenant admin (baik via app('tenant') atau url pattern {tenant}/admin/*)
            if (app()->bound('tenant')) {
                return url(app('tenant')->slug.'/admin/login');
            }

            if ($request->segment(2) === 'admin') {
                return url($request->segment(1).'/admin/login');
            }

            return route('superadmin.login');
        });

        $middleware->redirectUsersTo(function (Request $request) {
            if (auth('superadmin')->check()) {
                return route('superadmin.dashboard');
            }

            if (app()->bound('tenant') && auth('tenant_admin')->check()) {
                return url(app('tenant')->slug.'/admin/dashboard');
            }

            return route('superadmin.dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (QueryException $e, Request $request) {
            Log::error('Database error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine()."\n".$e->getTraceAsString());

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan database sedang mengalami gangguan. Silakan coba beberapa saat lagi.',
                ], 500);
            }

            return response()->view('errors.500', ['message' => 'Layanan database sedang mengalami gangguan. Silakan coba beberapa saat lagi.'], 500);
        });

        $exceptions->render(function (PDOException $e, Request $request) {
            Log::error('PDO error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine()."\n".$e->getTraceAsString());

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koneksi database gagal. Silakan coba beberapa saat lagi.',
                ], 500);
            }

            return response()->view('errors.500', ['message' => 'Koneksi database gagal. Silakan coba beberapa saat lagi.'], 500);
        });
    })->create();
