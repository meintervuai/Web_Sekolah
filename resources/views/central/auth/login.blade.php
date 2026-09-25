<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Super Admin — Platform Website Sekolah SaaS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 text-slate-100">

    <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
        <!-- Logo Brand -->
        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-indigo-600/30">
                WS
            </div>
        </div>
        <h1 class="text-center text-2xl sm:text-3xl font-bold tracking-tight text-white">
            Super Admin Portal
        </h1>
        <p class="mt-2 text-center text-sm text-slate-400">
            Masuk untuk mengelola tenant, domain, dan operasional website sekolah.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-slate-800/90 backdrop-blur-md border border-slate-700/80 py-8 px-6 shadow-xl rounded-2xl sm:px-10">

            <!-- Flash Info / Error -->
            @if (session('info'))
                <div class="mb-5 p-3.5 rounded-xl bg-slate-700/60 border border-slate-600 text-slate-300 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs">
                    <div class="font-semibold mb-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Autentikasi Gagal
                    </div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="space-y-5" action="{{ route('superadmin.login.submit') }}" method="POST" x-data="{ showPass: false }">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            value="{{ old('email', 'superadmin@admin.com') }}" 
                            class="block w-full pl-11 pr-4 py-3 bg-slate-900/90 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[48px] transition-colors"
                            placeholder="nama@domain.com"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            :type="showPass ? 'text' : 'password'" 
                            autocomplete="current-password" 
                            required 
                            class="block w-full pl-11 pr-12 py-3 bg-slate-900/90 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[48px] transition-colors"
                            placeholder="••••••••"
                        >
                        <button 
                            type="button" 
                            @click="showPass = !showPass" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 min-h-[44px] min-w-[44px] justify-center focus:outline-none"
                            aria-label="Lihat kata sandi"
                        >
                            <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 rounded-md border-slate-700 bg-slate-900 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-800"
                        >
                        <span>Ingat sesi masuk saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-indigo-500 transition-colors shadow-md min-h-[48px]"
                    >
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <!-- Demo Hint Credentials -->
            <div class="mt-6 pt-5 border-t border-slate-700/60 text-center">
                <div class="text-[11px] uppercase tracking-wider text-slate-400 font-semibold mb-1">
                    Kredensial Default Demo
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-900/80 border border-slate-700 text-xs font-mono text-slate-300">
                    <span>superadmin@admin.com</span>
                    <span class="text-slate-500">•</span>
                    <span>password123</span>
                </div>
            </div>

        </div>

        <p class="mt-6 text-center text-xs text-slate-500">
            Akses ini dibatasi khusus untuk Administrator Utama Platform SaaS.
        </p>
    </div>

</body>
</html>
