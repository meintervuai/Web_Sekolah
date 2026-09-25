<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login Super Admin.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::guard('superadmin')->check()) {
            return redirect()->route('superadmin.dashboard');
        }

        return view('central.auth.login');
    }

    /**
     * Proses otentikasi login Super Admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('superadmin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('superadmin.dashboard'))
                ->with('sukses', 'Selamat datang kembali, '.Auth::guard('superadmin')->user()->nama);
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Proses keluar (logout) sesi Super Admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('superadmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('superadmin.login')
            ->with('info', 'Anda telah berhasil keluar dari sistem Super Admin.');
    }
}
