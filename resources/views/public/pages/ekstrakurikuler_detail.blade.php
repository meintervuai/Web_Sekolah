@extends('layouts.public')

@section('title', $ekskul->nama_ekskul . ' - Ekstrakurikuler ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($ekskul->deskripsi), 160))

@section('content')
<!-- Breadcrumbs -->
<section class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="hover:text-blue-600 transition">Ekstrakurikuler</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $ekskul->nama_ekskul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Detail -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Main Ekskul Info (8 cols) -->
            <div class="lg:col-span-8">
                <!-- Title & Badge -->
                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        Ekstrakurikuler Resmi SMKN 2 Bandung
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight font-heading mb-6">
                    {{ $ekskul->nama_ekskul }}
                </h1>

                <!-- Photo with Lightbox -->
                @if($ekskul->gambar)
                <div class="mb-8 rounded-2xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100 relative group">
                    <img src="{{ $ekskul->gambar }}" 
                         alt="{{ $ekskul->nama_ekskul }}" 
                         class="w-full h-auto max-h-[460px] object-cover cursor-pointer"
                         @click="lightboxOpen = true; lightboxSrc = '{{ $ekskul->gambar }}'; lightboxCaption = '{{ addslashes($ekskul->nama_ekskul) }}'">
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center text-xs text-slate-500 italic">
                        Dokumentasi Kegiatan {{ $ekskul->nama_ekskul }} (Klik gambar untuk memperbesar)
                    </div>
                </div>
                @endif

                <!-- Metadata Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Jadwal Latihan Rutin:</span>
                        <strong class="text-sm md:text-base text-slate-900 font-bold block">{{ $ekskul->jadwal ?? 'Setiap Hari Sabtu' }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Guru Pembina:</span>
                        <strong class="text-sm md:text-base text-slate-900 font-bold block">{{ $ekskul->pembina ?? 'Tim Kesiswaan SMKN 2' }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Tempat Latihan:</span>
                        <strong class="text-xs md:text-sm text-slate-800 font-semibold block">Kampus SMKN 2 Bandung</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-1">Keanggotaan:</span>
                        <strong class="text-xs md:text-sm text-slate-800 font-semibold block">Terbuka Untuk Kelas X, XI, & XII</strong>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose prose-slate max-w-none prose-p:text-slate-700 prose-p:leading-relaxed mb-8">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-3">Profil & Program Kegiatan</h2>
                    <p class="whitespace-pre-line text-sm md:text-base text-slate-700 leading-relaxed">
                        {{ $ekskul->deskripsi }}
                    </p>
                </div>

                <!-- Back button -->
                <div class="pt-6 border-t border-slate-200">
                    <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Seluruh Ekstrakurikuler
                    </a>
                </div>
            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Ekskul Lainnya -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200">
                        Ekstrakurikuler Lainnya
                    </h3>
                    <div class="space-y-3">
                        @foreach($ekskulLainnya as $el)
                        <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler/' . $el->slug) }}" 
                           class="flex items-center p-2.5 rounded-xl hover:bg-white border border-transparent hover:border-slate-200 transition group">
                            <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-slate-200 mr-3">
                                <img src="{{ $el->gambar ?? 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=200&auto=format&fit=crop' }}" 
                                     alt="{{ $el->nama_ekskul }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition truncate">
                                    {{ $el->nama_ekskul }}
                                </h4>
                                <span class="text-[11px] text-slate-400 block truncate">{{ $el->jadwal ?? 'Jadwal Mingguan' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Gabung Ekskul Card -->
                <div class="bg-blue-900 text-white rounded-2xl p-6 shadow-sm">
                    <h4 class="font-bold font-heading text-sm mb-2">Ingin Mendaftar Ekskul?</h4>
                    <p class="text-xs text-blue-200 leading-relaxed mb-4">Pendaftaran anggota baru dibuka pada masa Masa Pengenalan Lingkungan Sekolah (MPLS) atau langsung menghubungi pengurus OSIS / MPK.</p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-amber-300 hover:text-amber-200">
                        <span>Hubungi Pembina OSIS &raquo;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
