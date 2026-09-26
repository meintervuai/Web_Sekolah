@extends('layouts.public')

@section('title', $jurusan->nama_jurusan . ' - ' . $sekolah['nama'])
@section('meta_description', 'Program Keahlian ' . $jurusan->nama_jurusan . ' di ' . $sekolah['nama'] . '. ' . ($jurusan->deskripsi_singkat ?? ''))

@section('content')
<!-- Page Header / Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="hover:text-white transition">Program Keahlian</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium truncate max-w-xs md:max-w-md">{{ $jurusan->nama_jurusan }}</li>
            </ol>
        </nav>

        <div class="max-w-3xl">
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-4">
                {{ $jurusan->nama_jurusan }}
            </h1>
            <p class="text-slate-300 text-sm md:text-lg leading-relaxed">
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
                
                <!-- Hero Image with Aspect Ratio -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200/80">
                    <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $jurusan->foto_utama ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1200&auto=format&fit=crop' }}" 
                             alt="{{ $jurusan->nama_jurusan }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-slate-100">
                            <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold font-heading shrink-0 shadow-inner">
                                {{ $jurusan->singkatan }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 font-heading">Profil & Ringkasan Jurusan</h2>
                                <p class="text-xs text-slate-500">SMK Negeri 2 Bandung • Berstandar Industri</p>
                            </div>
                        </div>

                        <!-- Rich Content -->
                        <div class="prose prose-slate max-w-none prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-600 prose-p:leading-relaxed prose-li:text-slate-600">
                            {!! $jurusan->deskripsi_lengkap !!}
                        </div>
                    </div>
                </div>

                <!-- Call to Action SPMB -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white rounded-2xl p-6 md:p-8 shadow-md relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="relative z-10 max-w-md">
                        <h3 class="text-xl font-bold font-heading mb-2">Berminat Masuk ke Jurusan Ini?</h3>
                        <p class="text-sm text-blue-100">Ketahui persyaratan pendaftaran, daya tampung rombel, dan alur pendaftaran peserta didik baru.</p>
                    </div>
                    <div class="relative z-10 shrink-0">
                        <a href="{{ url(app('tenant')->slug . '/spmb') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-sm btn-radius shadow hover:shadow-lg transition">
                            <span>Informasi SPMB</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar (1 Column) -->
            <div class="space-y-6">
                <!-- Program Info Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-100 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Program
                    </h3>
                    <ul class="space-y-3.5 text-xs md:text-sm">
                        <li class="flex justify-between items-center text-slate-600">
                            <span>Jenjang:</span>
                            <strong class="text-slate-900 font-semibold">SMK (3 Tahun)</strong>
                        </li>
                        <li class="flex justify-between items-center text-slate-600">
                            <span>Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                        </li>
                        <li class="flex justify-between items-center text-slate-600">
                            <span>Peluang Kerja:</span>
                            <strong class="text-slate-900 font-semibold">Industri & Wirausaha</strong>
                        </li>
                        <li class="flex justify-between items-center text-slate-600">
                            <span>Sertifikasi:</span>
                            <strong class="text-slate-900 font-semibold">LSP-P1 / BNSP</strong>
                        </li>
                    </ul>
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
                            <div class="w-10 h-10 rounded-lg bg-slate-100 text-blue-900 flex items-center justify-center font-bold text-xs font-heading mr-3 group-hover:bg-blue-600 group-hover:text-white transition">
                                {{ $jl->singkatan }}
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
