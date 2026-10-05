@extends('layouts.public')

@section('title', 'Program Keahlian')
@section('meta_description', 'Daftar 7 program keahlian unggulan di SMK Negeri 2 Bandung dengan kurikulum berstandar industri.')

@section('content')
<!-- Page Header -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @php
        $heroBanner = $halaman->gambar_banner ?? ($gambarBanner ?? ($banner ?? null));
        $heroJudul = $halaman->judul ?? 'Program Keahlian Unggulan';
        $heroSubjudul = $halaman->subjudul ?? 'SMK Negeri 2 Bandung menyelenggarakan 7 konsentrasi keahlian di bidang teknologi dan rekayasa dengan fasilitas modern dan kemitraan puluhan industri terkemuka.';
    @endphp
    @if(!empty($heroBanner))
        <!-- Right-Side Artistic Banner Image with Gradual Mask/Fade to Left & Theme Dark Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $heroBanner }}" alt="{{ $heroJudul }}" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Program Keahlian</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                {{ $heroJudul }}
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                {{ $heroSubjudul }}
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
                        <div class="relative aspect-[4/3] w-full bg-slate-900 overflow-hidden flex items-center justify-center">
                            @if(!empty($j->ikon_atau_foto))
                                <!-- Ambient Blurred Backdrop -->
                                <img src="{{ $j->ikon_atau_foto }}" 
                                     alt="" 
                                     aria-hidden="true" 
                                     class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none">
                                <!-- Main Image -->
                                <img src="{{ $j->ikon_atau_foto }}" 
                                     alt="{{ $j->nama_jurusan }}" 
                                     @style([\App\Services\MediaService::getCropStyle($j->ikon_atau_foto)])
                                     class="relative z-10 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 z-20 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                            @else
                                <!-- Clean Gradient Background for No Image State -->
                                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white text-2xl font-bold font-heading shadow-inner backdrop-blur-xs">
                                        {{ $j->singkatan ?? substr($j->nama_jurusan, 0, 2) }}
                                    </div>
                                </div>
                                <div class="absolute inset-0 z-20 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent pointer-events-none"></div>
                            @endif

                            @if(!empty($j->logo))
                                <div class="absolute top-3 left-3 z-30 w-10 h-10 rounded-xl bg-white/95 p-1 shadow-md border border-white/40 flex items-center justify-center backdrop-blur-xs">
                                    <img src="{{ $j->logo }}" alt="{{ $j->nama_jurusan }}" class="w-full h-full object-contain">
                                </div>
                            @elseif(!empty($j->singkatan) && !empty($j->ikon_atau_foto))
                                <div class="absolute top-3 left-3 z-30 px-2.5 py-1 rounded-lg bg-blue-600/90 text-white text-[11px] font-bold font-heading shadow-md backdrop-blur-xs">
                                    {{ $j->singkatan }}
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-4 right-4 z-30">
                                <h2 class="font-heading font-bold text-lg text-white leading-tight">
                                    {{ $j->nama_jurusan }}
                                </h2>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed mb-3">
                                    {{ $j->deskripsi_singkat }}
                                </p>
                                <div class="flex items-center gap-2 text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 font-medium text-slate-700">
                                        {{ $j->jenjang ?? 'SMK (3 Tahun)' }}
                                    </span>
                                    @if($j->kepalaProgram)
                                        <span class="truncate text-slate-500">• Kaprog: {{ $j->kepalaProgram->nama_lengkap }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-4 mt-3 border-t border-slate-100">
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
