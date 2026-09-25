@extends('layouts.public')

@section('title', '500 - Kesalahan Internal Server')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Terjadi Kesalahan (500)
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ $message ?? 'Maaf, terjadi kesalahan internal pada server kami. Silakan coba beberapa saat lagi.' }}
            </p>
        </div>
        <div class="mt-8 space-y-6">
            <a href="/" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
