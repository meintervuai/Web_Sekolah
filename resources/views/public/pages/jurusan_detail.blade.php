@extends('layouts.public')

@section('title', $jurusan->nama_jurusan . ' - ' . $sekolah['nama'])

@section('content')
<!-- Hero Section -->
<section class="relative bg-blue-900 text-white py-20 lg:py-32">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <img src="{{ $jurusan->foto_utama ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $jurusan->nama_jurusan }}" class="w-full h-full object-cover opacity-60">
    </div>
    
    <div class="container mx-auto px-4 relative z-20">
        <div class="max-w-3xl mx-auto text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-600/80 text-blue-100 text-sm font-semibold tracking-wider mb-4 border border-blue-400/50">Program Keahlian</span>
            <h1 class="text-4xl lg:text-5xl font-bold mb-6 text-white drop-shadow-md leading-tight">{{ $jurusan->nama_jurusan }}</h1>
            <p class="text-xl text-blue-100 font-light drop-shadow">{{ $jurusan->deskripsi_singkat }}</p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 lg:p-12">
                <div class="flex items-center space-x-4 mb-8 pb-8 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl shadow-inner">
                        {{ $jurusan->ikon_atau_foto ?? '🏫' }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Profil {{ $jurusan->singkatan }}</h2>
                        <p class="text-slate-500">Informasi lengkap program keahlian</p>
                    </div>
                </div>

                <div class="prose prose-lg prose-blue max-w-none prose-headings:text-slate-800 prose-p:text-slate-600 prose-li:text-slate-600">
                    {!! $jurusan->deskripsi_lengkap !!}
                </div>
            </div>
            
            <div class="bg-slate-50 p-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wider mb-1">Tertarik bergabung?</h3>
                    <p class="text-slate-500 text-sm">Daftar sekarang melalui portal PPDB kami.</p>
                </div>
                <a href="#" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors w-full sm:w-auto">
                    Informasi PPDB
                </a>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ route('akademik.jurusan') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Semua Jurusan
            </a>
        </div>
    </div>
</section>
@endsection
