@extends('layouts.public')

@section('title', $jurusan->nama_jurusan . ' - ' . $sekolah['nama'])
@section('meta_description', 'Program Keahlian ' . $jurusan->nama_jurusan . ' di ' . $sekolah['nama'] . '. ' . ($jurusan->deskripsi_singkat ?? ''))

@section('content')
<!-- Page Header / Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($jurusan->foto_utama ?? $jurusan->gambar ?? null))
        <!-- Full-Width Hero Banner Image with Dark Theme Gradient Overlay -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <img src="{{ $jurusan->foto_utama ?? $jurusan->gambar }}" alt="{{ $jurusan->nama_jurusan }}" 
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-950/60"></div>
            <div class="absolute inset-0" style="background: linear-gradient(135deg, color-mix(in srgb, var(--theme-header,#0f172a) 85%, black 15%) 0%, color-mix(in srgb, var(--theme-header,#0f172a) 40%, transparent) 70%, transparent 100%); opacity: 0.85;"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="hover:text-white transition drop-shadow-xs">Program Keahlian</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium truncate max-w-xs md:max-w-md drop-shadow-xs">{{ $jurusan->nama_jurusan }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-4 drop-shadow-sm">
                {{ $jurusan->nama_jurusan }}
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                {{ $jurusan->deskripsi_singkat }}
            </p>
        </div>
    </div>
</section>

<!-- Main Detail Content -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            
            <!-- Left: Main Information (2 Columns) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Hero Image with Aspect Ratio (Hanya tampil jika foto diisi) -->
                @php
                    $detailFoto = $jurusan->foto_utama ?? $jurusan->ikon_atau_foto;
                @endphp
                @if(!empty($detailFoto))
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900 relative flex items-center justify-center">
                        <!-- Ambient Blurred Backdrop -->
                        <img src="{{ $detailFoto }}" 
                             alt="" 
                             aria-hidden="true" 
                             class="absolute inset-0 w-full h-full object-cover blur-md scale-125 opacity-40 pointer-events-none">
                        <!-- Main Image with Smart Crop -->
                        <img src="{{ $detailFoto }}" 
                             alt="{{ $jurusan->nama_jurusan }}" 
                             @style([\App\Services\MediaService::getCropStyle($detailFoto)])
                             class="relative z-10 w-full h-full object-cover">
                    </div>
                </div>
                @endif

                <!-- Profil Utama & Deskripsi Lengkap -->
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200/80">
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-slate-100">
                        @if(!empty($jurusan->logo))
                            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center p-2 shadow-xs shrink-0">
                                <img src="{{ $jurusan->logo }}" alt="{{ $jurusan->nama_jurusan }}" class="w-full h-full object-contain">
                            </div>
                        @elseif(!empty($jurusan->singkatan))
                            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold font-heading shrink-0 shadow-inner">
                                {{ $jurusan->singkatan }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 font-heading">{{ $jurusan->nama_jurusan }}</h2>
                            <p class="text-xs text-slate-500">{{ $sekolah['nama'] }} • Berstandar Industri</p>
                        </div>
                    </div>

                    <!-- Rich Content -->
                    <div class="prose prose-slate max-w-none prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-600 prose-p:leading-relaxed prose-li:text-slate-600">
                        {!! $jurusan->deskripsi_lengkap !!}
                    </div>
                </div>

                <!-- Galeri Multi-Foto Dokumentasi Bengkel / Lab Kejuruan -->
                @if($jurusan->fotos && $jurusan->fotos->count() > 0)
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200/80 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900 font-heading flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Fasilitas Praktik &amp; Dokumentasi Kejuruan
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Dokumentasi sarana laboratorium, bengkel praktik kerja, dan portofolio keahlian.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($jurusan->fotos as $foto)
                        <div class="rounded-xl overflow-hidden border border-slate-200/80 bg-slate-900 group relative shadow-xs">
                            <div class="aspect-4/3 w-full relative overflow-hidden flex items-center justify-center">
                                <img src="{{ $foto->file_foto }}" alt="{{ $foto->judul ?? $jurusan->nama_jurusan }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @if(!empty($foto->judul))
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/85 via-slate-950/40 to-transparent p-3 text-white">
                                        <p class="text-xs font-semibold leading-tight drop-shadow-xs">{{ $foto->judul }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Call to Action SPMB -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white rounded-2xl p-6 md:p-8 shadow-md relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="relative z-10 max-w-md">
                        <h3 class="text-xl font-bold font-heading mb-2">Berminat Masuk ke Jurusan Ini?</h3>
                        <p class="text-sm text-blue-100">Ketahui persyaratan pendaftaran, daya tampung rombel, dan alur pendaftaran peserta didik baru.</p>
                    </div>
                    <div class="relative z-10 shrink-0">
                        <a href="{{ url(app('tenant')->slug . '/spmb') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 theme-btn-primary font-bold text-sm btn-radius shadow hover:shadow-lg transition">
                            <span>Informasi SPMB</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar (1 Column) -->
            <div class="space-y-6">
                <!-- KARTU TERPADU: KEPALA PROGRAM KEAHLIAN & INFORMASI PROGRAM -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 space-y-5">
                    @if($jurusan->kepalaProgram)
                    <!-- Sub-Section: Kepala Program -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 pb-2 border-b border-slate-100 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Kepala Program Keahlian
                        </h3>
                        <div class="flex items-center gap-3.5">
                            @if($jurusan->kepalaProgram->foto)
                                <div class="w-13 h-13 rounded-2xl overflow-hidden border border-slate-200 shadow-2xs shrink-0 bg-slate-100">
                                    <img src="{{ $jurusan->kepalaProgram->foto }}" alt="{{ $jurusan->kepalaProgram->nama_lengkap }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-13 h-13 rounded-2xl bg-blue-50 text-blue-700 font-bold font-heading text-lg flex items-center justify-center shrink-0 border border-blue-100">
                                    {{ substr($jurusan->kepalaProgram->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-bold text-slate-900 text-sm leading-snug">{{ $jurusan->kepalaProgram->nama_lengkap }}</h4>
                                <p class="text-xs text-blue-600 font-medium mt-0.5">{{ $jurusan->kepalaProgram->jabatan ?? 'Ketua Program Keahlian' }}</p>
                                @if(!empty($jurusan->kepalaProgram->nip))
                                    <p class="text-[11px] text-slate-400 mt-0.5 font-mono">NIP: {{ $jurusan->kepalaProgram->nip }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Sub-Section: Informasi Program (WYSIWYG Rich Content) -->
                    <div class="{{ $jurusan->kepalaProgram ? 'pt-4 border-t border-slate-100' : '' }}">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 pb-2 border-b border-slate-100 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Program
                        </h3>
                        
                        @if(!empty($jurusan->informasi_tambahan))
                            <div class="prose prose-slate prose-xs max-w-none text-xs leading-relaxed text-slate-600 space-y-2 prose-ul:my-1 prose-li:my-0.5 prose-p:my-1">
                                {!! $jurusan->informasi_tambahan !!}
                            </div>
                        @else
                            <ul class="space-y-3 text-xs md:text-sm">
                                <li class="flex justify-between items-center text-slate-600">
                                    <span>Jenjang:</span>
                                    <strong class="text-slate-900 font-semibold text-right">{{ $jurusan->jenjang ?? 'SMK (3 Tahun)' }}</strong>
                                </li>
                                <li class="flex justify-between items-center text-slate-600">
                                    <span>Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jurusan->is_aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $jurusan->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </li>
                                @if(!empty($jurusan->peluang_kerja))
                                <li class="flex justify-between items-start text-slate-600 gap-2">
                                    <span>Peluang Kerja:</span>
                                    <strong class="text-slate-900 font-semibold text-right">{{ $jurusan->peluang_kerja }}</strong>
                                </li>
                                @endif
                                @if(!empty($jurusan->sertifikasi))
                                <li class="flex justify-between items-start text-slate-600 gap-2">
                                    <span>Sertifikasi:</span>
                                    <strong class="text-slate-900 font-semibold text-right">{{ $jurusan->sertifikasi }}</strong>
                                </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Jurusan Lainnya Navigation -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-100 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Jurusan Lainnya
                    </h3>
                    <div class="space-y-3">
                        @foreach($jurusanLainnya as $jl)
                        <a href="{{ url(app('tenant')->slug . '/program-keahlian/' . $jl->slug) }}" 
                           class="flex items-center p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition group">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 text-blue-900 flex items-center justify-center font-bold text-xs font-heading mr-3 group-hover:bg-blue-600 group-hover:text-white transition overflow-hidden">
                                @if(!empty($jl->logo))
                                    <img src="{{ $jl->logo }}" alt="{{ $jl->nama_jurusan }}" class="w-full h-full object-contain p-1">
                                @elseif(!empty($jl->singkatan))
                                    {{ $jl->singkatan }}
                                @else
                                    PK
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs md:text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition truncate">
                                    {{ $jl->nama_jurusan }}
                                </h4>
                                <span class="text-[11px] text-slate-400">Lihat silabus &raquo;</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Hubungi Kami Card -->
                <div class="bg-blue-50 border border-blue-200/60 rounded-2xl p-6">
                    <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Butuh Konsultasi Jurusan?</h4>
                    <p class="text-xs text-blue-800 leading-relaxed mb-4">Tim bimbingan konseling dan humas kami siap menjawab pertanyaan seputar program keahlian.</p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
                        <span>Hubungi Humas Sekolah</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
