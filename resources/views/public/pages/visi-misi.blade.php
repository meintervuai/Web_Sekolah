@extends('layouts.public')

@section('title', ($halaman->judul ?? 'Visi & Misi') . ' - ' . $sekolah['nama'])
@section('meta_description', 'Visi, misi, dan tujuan strategis pendidikan kejuruan ' . $sekolah['nama'] . ' Bandung.')

@section('content')
<!-- Header & Breadcrumb -->
@php
    $polaVisiMisi = $halaman->pola_latar ?? 'dots';
@endphp
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    @if($polaVisiMisi === 'dots')
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @elseif($polaVisiMisi === 'grid')
        <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,var(--theme-accent)_1px,transparent_1px),linear-gradient(to_bottom,var(--theme-accent)_1px,transparent_1px)] [background-size:24px_24px]"></div>
    @elseif($polaVisiMisi === 'mesh')
        <div class="absolute inset-0 opacity-20 bg-gradient-to-tr from-transparent via-blue-500/10 to-transparent"></div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/profil') }}" class="hover:text-white transition">Profil</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Visi &amp; Misi</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                {{ $halaman->judul ?? 'Visi & Misi Sekolah' }}
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                {{ $halaman->subjudul ?? ('Arah haluan, cita-cita luhur, dan komitmen penyelenggaraan pendidikan vokasi di ' . $sekolah['nama']) }}
            </p>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="max-w-[780px] mx-auto">
            @if(isset($halaman->gambar_banner) && $halaman->gambar_banner)
            <div class="rounded-2xl overflow-hidden shadow-sm mb-8 bg-slate-100">
                <img src="{{ $halaman->gambar_banner }}" alt="{{ $halaman->judul }}" class="w-full h-auto max-h-[420px] object-cover">
            </div>
            @endif

            <div class="prose prose-slate md:prose-lg max-w-none prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed prose-li:text-slate-700">
                {!! $halaman->isi_konten ?? '<p>Konten belum tersedia.</p>' !!}
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Halaman Profil Lengkap
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
