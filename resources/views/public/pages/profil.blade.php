@extends('layouts.public')

@section('title', 'Profil Sekolah')
@section('meta_description', 'Profil lengkap, sejarah, visi misi, dan struktur organisasi SMK Negeri 2 Bandung.')

@section('content')
<div class="bg-gradient-to-r from-theme-color via-theme-accent to-theme-color text-white py-14 border-b border-slate-800">
    <div class="container-custom">
        <nav class="flex items-center space-x-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
            <a href="{{ url(app('tenant')->slug) }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-white font-semibold">Profil Sekolah</span>
        </nav>
        <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-white">Profil SMK Negeri 2 Bandung</h1>
        <p class="text-slate-300 text-sm mt-2 max-w-2xl leading-relaxed">
            Mengenal lebih dekat sejarah, visi misi, budaya kerja, dan pimpinan satuan pendidikan kejuruan berprestasi.
        </p>
    </div>
</div>

<div class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Identitas Singkat -->
                <div class="theme-card rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="font-heading font-bold text-xl text-slate-900 mb-6 pb-2 border-b border-slate-100">
                        Identitas Satuan Pendidikan
                    </h2>
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8">
                        <div class="shrink-0 flex items-center justify-center bg-transparent">
                            <img src="{{ !empty($sekolah['logo']) ? $sekolah['logo'] : asset('images/logo-smkn2.svg') }}" 
                                 alt="Logo {{ $sekolah['nama'] }}" 
                                 class="w-36 h-36 sm:w-44 sm:h-44 md:w-48 md:h-48 object-contain">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700 flex-1 w-full">
                            <div class="space-y-2.5">
                                <p><strong class="text-slate-900">Nama Sekolah:</strong> {{ $sekolah['nama'] }}</p>
                                <p><strong class="text-slate-900">NPSN:</strong> {{ $sekolah['npsn'] }}</p>
                                <p><strong class="text-slate-900">Bentuk Pendidikan:</strong> SMK</p>
                                <p><strong class="text-slate-900">Status Akreditasi:</strong> <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded text-xs">Peringkat A</span></p>
                            </div>
                            <div class="space-y-2.5">
                                <p><strong class="text-slate-900">Tahun Berdiri:</strong> {{ $sekolah['tahun_berdiri'] }}</p>
                                <p><strong class="text-slate-900">Alamat:</strong> {{ $sekolah['alamat'] }}</p>
                                <p><strong class="text-slate-900">Telepon:</strong> {{ $sekolah['telepon'] }}</p>
                                <p><strong class="text-slate-900">Email Resmi:</strong> {{ $sekolah['email'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sejarah -->
                @if($sejarah)
                <div class="theme-card rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm" id="sejarah">
                    <h2 class="font-heading font-bold text-xl text-slate-900 mb-4 pb-2 border-b border-slate-100">
                        Sejarah Singkat
                    </h2>
                    <div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed space-y-3">
                        {!! $sejarah->isi_konten !!}
                    </div>
                </div>
                @endif

                <!-- Visi & Misi -->
                @if($visiMisi)
                <div class="theme-card rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm" id="visi-misi">
                    <h2 class="font-heading font-bold text-xl text-slate-900 mb-4 pb-2 border-b border-slate-100">
                        Visi, Misi & Tujuan
                    </h2>
                    <div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed space-y-3">
                        {!! $visiMisi->isi_konten !!}
                    </div>
                </div>
                @endif

            </div>

            <!-- Right Column / Video Player (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Video Media Player Card -->
                <div class="theme-card rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100">
                        <div class="w-2 h-5 bg-blue-600 rounded-full"></div>
                        <h3 class="font-heading font-bold text-base text-slate-900">
                            {{ $sekolah['video_profil_judul'] ?? 'Video Profil Sekolah' }}
                        </h3>
                    </div>

                    @php
                        $videoUrl = $sekolah['video_profil'] ?? '';
                        $isYouTube = Str::contains($videoUrl, ['youtube.com', 'youtu.be']);
                        $ytEmbed = '';
                        if ($isYouTube) {
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $videoUrl, $match)) {
                                $ytEmbed = 'https://www.youtube.com/embed/' . $match[1] . '?rel=0';
                            }
                        }
                    @endphp

                    <div class="rounded-xl overflow-hidden bg-black aspect-video shadow-md border border-slate-200 relative mb-4">
                        @if($ytEmbed)
                            <iframe
                                src="{{ $ytEmbed }}"
                                title="{{ $sekolah['video_profil_judul'] ?? 'Video Profil' }}"
                                class="w-full h-full border-0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @elseif(!empty($videoUrl))
                            <video controls class="w-full h-full object-cover">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutar video HTML5.
                            </video>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                <svg class="w-12 h-12 text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs">Video profil belum tersedia</span>
                            </div>
                        @endif
                    </div>

                    @if(!empty($sekolah['video_profil_deskripsi']))
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $sekolah['video_profil_deskripsi'] }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
