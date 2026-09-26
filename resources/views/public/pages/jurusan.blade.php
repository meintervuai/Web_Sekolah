@extends('layouts.public')

@section('title', 'Program Keahlian')
@section('meta_description', 'Daftar 7 program keahlian unggulan di SMK Negeri 2 Bandung dengan kurikulum berstandar industri.')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white py-14 border-b border-slate-800">
    <div class="container-custom">
        <nav class="flex items-center space-x-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
            <a href="{{ url(app('tenant')->slug) }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-white font-semibold">Program Keahlian</span>
        </nav>
        <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-white">Program Keahlian Unggulan</h1>
        <p class="text-slate-300 text-sm mt-2 max-w-2xl leading-relaxed">
            SMK Negeri 2 Bandung menyelenggarakan 7 konsentrasi keahlian di bidang teknologi dan rekayasa dengan fasilitas modern dan kemitraan puluhan industri terkemuka.
        </p>
    </div>
</div>

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
                            <span class="absolute top-3 right-3 bg-blue-900/90 text-white font-extrabold text-xs px-2.5 py-1 rounded-md backdrop-blur-sm shadow">
                                {{ $j->singkatan }}
                            </span>
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
