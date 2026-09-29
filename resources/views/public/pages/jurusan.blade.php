@extends('layouts.public')

@section('title', 'Program Keahlian')
@section('meta_description', 'Daftar 7 program keahlian unggulan di SMK Negeri 2 Bandung dengan kurikulum berstandar industri.')

@section('content')
<!-- Page Header -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Program Keahlian</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Program Keahlian Unggulan
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                SMK Negeri 2 Bandung menyelenggarakan 7 konsentrasi keahlian di bidang teknologi dan rekayasa dengan fasilitas modern dan kemitraan puluhan industri terkemuka.
            </p>
        </div>
    </div>
</section>

<div class="section-py bg-slate-50">
    <div class="container-custom">
        
        @if($jurusan->isEmpty())
            <div class="p-12 text-center bg-white rounded-2xl border border-slate-200 text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <p class="font-bold text-base text-slate-700">Belum Ada Program Keahlian</p>
                <p class="text-xs text-slate-500 mt-1">Data program keahlian sedang dalam proses pemutakhiran.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($jurusan as $j)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between h-full">
                        <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                            <img src="{{ $j->ikon_atau_foto ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800' }}" 
                                 alt="{{ $j->nama_jurusan }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-4 right-4">
                                <h2 class="font-heading font-bold text-lg text-white leading-tight">
                                    {{ $j->nama_jurusan }}
                                </h2>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed">
                                {{ $j->deskripsi_singkat }}
                            </p>
                            <div class="pt-5 mt-4 border-t border-slate-100">
                                <a href="{{ url(app('tenant')->slug . '/program-keahlian/' . $j->slug) }}" 
                                   class="w-full py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs btn-radius flex items-center justify-center transition shadow-sm">
                                    <span>Pelajari Kompetensi & Prospek</span>
                                    <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
