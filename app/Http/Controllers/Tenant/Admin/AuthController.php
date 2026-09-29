<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login Admin Sekolah (Tenant).
     */
    public function showLogin(): View|RedirectResponse
    {
        $tenant = app('tenant');

        if (Auth::guard('tenant_admin')->check()) {
            return redirect()->route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug]);
        }

        return view('tenant.admin.auth.login', compact('tenant'));
    }

    /**
     * Proses otentikasi login Admin Sekolah.
     */
    public function login(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Otentikasi terhadap koneksi tenant aktif
        if (Auth::guard('tenant_admin')->attempt($credentials, $remember)) {
            $user = Auth::guard('tenant_admin')->user();

            if (! $user->status_aktif) {
                Auth::guard('tenant_admin')->logout();

                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan oleh administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('tenant.admin.pengaturan.index', ['tenant' => $tenant->slug]))
                ->with('sukses', "Selamat datang kembali di Panel Admin {$tenant->nama_sekolah}, {$user->nama}!");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data admin sekolah.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout sesi Admin Sekolah.
     */
    public function logout(Request $request): RedirectResponse
    {
        $tenant = app('tenant');

        Auth::guard('tenant_admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.admin.login', ['tenant' => $tenant->slug])
            ->with('info', "Anda telah berhasil keluar dari Panel Admin {$tenant->nama_sekolah}.");
    }
}
