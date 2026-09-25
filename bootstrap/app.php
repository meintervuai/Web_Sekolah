<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            // \App\Http\Middleware\TenantMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('superadmin*')) {
                return route('superadmin.login');
            }

            return route('superadmin.login');
        });

        $middleware->redirectUsersTo(function (Request $request) {
            if (auth('superadmin')->check()) {
                return route('superadmin.dashboard');
            }

            return route('superadmin.dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
        
        $exceptions->render(function (\Illuminate\Database\QueryException $e, Request $request) {
            \Illuminate\Support\Facades\Log::error('Database error: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan database sedang mengalami gangguan. Silakan coba beberapa saat lagi.'
                ], 500);
            }

            return response()->view('errors.500', ['message' => 'Layanan database sedang mengalami gangguan. Silakan coba beberapa saat lagi.'], 500);
        });

        $exceptions->render(function (\PDOException $e, Request $request) {
            \Illuminate\Support\Facades\Log::error('PDO error: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koneksi database gagal. Silakan coba beberapa saat lagi.'
                ], 500);
            }

            return response()->view('errors.500', ['message' => 'Koneksi database gagal. Silakan coba beberapa saat lagi.'], 500);
        });
    })->create();
