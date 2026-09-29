<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200 p-8 text-center">
        <div class="w-16 h-16 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Halaman Tidak Ditemukan (404)</h1>
        <p class="text-sm text-slate-600 mb-6 leading-relaxed">
            {{ $exception?->getMessage() ?: 'Alamat atau tautan yang Anda cari tidak tersedia di direktori sistem sekolah ini.' }}
        </p>
        @php
            $tenant = app()->bound('tenant') ? app('tenant') : null;
            $homeUrl = $tenant ? url($tenant->slug) : url('/');
            $adminLoginUrl = $tenant ? url($tenant->slug . '/admin/login') : url('/login');
        @endphp
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button type="button" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ $homeUrl }}'" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-md transition cursor-pointer flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Halaman Sebelumnya
            </button>
            <a href="{{ $homeUrl }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center justify-center">
                Beranda Sekolah
            </a>
        </div>
    </div>
</body>
</html>
