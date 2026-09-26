@extends('layouts.public')

@section('title', 'Struktur Organisasi & Pimpinan - ' . $sekolah['nama'])
@section('meta_description', 'Susunan struktur organisasi, jajaran kepala sekolah, wakil kepala sekolah, dan pimpinan program keahlian di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/profil') }}" class="hover:text-white transition">Profil</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Struktur Organisasi</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Struktur Organisasi Sekolah
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Jajaran pimpinan, kepala program keahlian, dan koordinator tata kelola manajerial di {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($struktur as $s)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition text-center flex flex-col items-center group">
                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-slate-100 mb-4 ring-4 ring-slate-100 group-hover:ring-blue-100 transition shadow-inner">
                    <img src="{{ $s->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($s->nama_lengkap).'&background=1E3A8A&color=fff&size=200' }}" 
                         alt="{{ $s->nama_lengkap }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <h2 class="text-base font-bold text-slate-900 font-heading mb-1 leading-snug">
                    {{ $s->nama_lengkap }}
                </h2>
                <p class="text-xs font-semibold text-blue-600 mb-2">
                    {{ $s->jabatan }}
                </p>
                @if($s->keterangan)
                <p class="text-[11px] text-slate-500 mt-auto pt-2 border-t border-slate-100 w-full">
                    {{ $s->keterangan }}
                </p>
                @endif
            </div>
            @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada data struktur organisasi.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Halaman Profil Lengkap
            </a>
        </div>
    </div>
</section>
@endsection
