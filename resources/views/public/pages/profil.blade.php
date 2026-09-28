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
                    <h2 class="font-heading font-bold text-xl text-slate-900 mb-4 pb-2 border-b border-slate-100">
                        Identitas Satuan Pendidikan
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
                        <div class="space-y-2">
                            <p><strong class="text-slate-900">Nama Sekolah:</strong> {{ $sekolah['nama'] }}</p>
                            <p><strong class="text-slate-900">NPSN:</strong> {{ $sekolah['npsn'] }}</p>
                            <p><strong class="text-slate-900">Bentuk Pendidikan:</strong> SMK</p>
                            <p><strong class="text-slate-900">Status Akreditasi:</strong> <span class="bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded text-xs">Peringkat A</span></p>
                        </div>
                        <div class="space-y-2">
                            <p><strong class="text-slate-900">Tahun Berdiri:</strong> {{ $sekolah['tahun_berdiri'] }}</p>
                            <p><strong class="text-slate-900">Alamat:</strong> {{ $sekolah['alamat'] }}</p>
                            <p><strong class="text-slate-900">Telepon:</strong> {{ $sekolah['telepon'] }}</p>
                            <p><strong class="text-slate-900">Email Resmi:</strong> {{ $sekolah['email'] }}</p>
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

                <!-- Struktur Organisasi Pimpinan -->
                <div class="theme-card rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm" id="struktur">
                    <h2 class="font-heading font-bold text-xl text-slate-900 mb-6 pb-2 border-b border-slate-100">
                        Struktur Pimpinan Sekolah
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($struktur as $st)
                            <div class="text-center p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition">
                                <img src="{{ $st->foto ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400' }}" 
                                     alt="{{ $st->nama_lengkap }}" 
                                     class="w-24 h-24 rounded-full mx-auto object-cover object-top shadow-md border-2 border-white">
                                <h3 class="font-heading font-bold text-sm text-slate-900 mt-3">{{ $st->nama_lengkap }}</h3>
                                <p class="text-xs text-blue-700 font-semibold">{{ $st->jabatan }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Kepala Sekolah Card -->
                <div class="theme-card rounded-2xl p-6 border border-slate-200 shadow-sm text-center">
                    <img src="{{ $sekolah['foto_kepsek'] }}" 
                         alt="{{ $sekolah['nama_kepsek'] }}" 
                         class="w-32 h-32 rounded-full mx-auto object-cover object-top shadow-lg border-4 border-blue-50">
                    <h3 class="font-heading font-bold text-base text-slate-900 mt-4">{{ $sekolah['nama_kepsek'] }}</h3>
                    <p class="text-xs text-blue-700 font-semibold">Kepala Sekolah</p>
                    <p class="text-xs text-slate-500 mt-0.5">NIP. {{ $sekolah['nip_kepsek'] }}</p>
                    <p class="text-xs text-slate-600 italic mt-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        "{{ Str::limit($sekolah['sambutan_kepsek'], 140) }}"
                    </p>
                </div>

                <!-- Navigation Widget -->
                <div class="theme-card rounded-2xl p-5 border border-slate-200 shadow-sm">
                    <h4 class="font-heading font-bold text-sm text-slate-900 uppercase tracking-wider mb-3">Daftar Menu Profil</h4>
                    <ul class="space-y-1.5 text-sm">
                        <li><a href="#sejarah" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Sejarah Sekolah</a></li>
                        <li><a href="#visi-misi" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Visi, Misi & Tujuan</a></li>
                        <li><a href="#struktur" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Struktur Organisasi</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/guru-staf') }}" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Direktori Guru & Staf</a></li>
                        <li><a href="{{ url(app('tenant')->slug . '/fasilitas') }}" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Fasilitas Sekolah</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
