@extends('layouts.public')

@section('title', 'Sarana & Fasilitas Sekolah - ' . $sekolah['nama'])
@section('meta_description', 'Fasilitas pembelajaran standar industri: bengkel mesin CNC, bengkel otomotif EFI, lab komputer & IoT, studio multimedia di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Sarana & Prasarana</li>
            </ol>
        </nav>
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3">
                Fasilitas & Infrastruktur
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                Menunjang pembelajaran teaching factory dengan peralatan modern: mesin CNC industri, bengkel otomotif EFI, studio multimedia, dan perpustakaan digital.
            </p>
        </div>
    </div>
</section>

<!-- Stats overview bar -->
<section class="bg-white border-b border-slate-200/80">
    <div class="container-custom py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-2xl font-extrabold text-blue-900 font-heading block">41</span>
                <span class="text-xs text-slate-500">Ruang Kelas Teori</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-2xl font-extrabold text-blue-900 font-heading block">7+</span>
                <span class="text-xs text-slate-500">Bengkel Praktik Industri</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-2xl font-extrabold text-blue-900 font-heading block">1</span>
                <span class="text-xs text-slate-500">Perpustakaan Terakreditasi</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                <span class="text-2xl font-extrabold text-blue-900 font-heading block">100%</span>
                <span class="text-xs text-slate-500">Akses Internet Kampus</span>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Grid Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($fasilitas as $f)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition duration-200 flex flex-col group">
                <!-- 4:3 Image Container with Lightbox Trigger -->
                <div class="aspect-4/3 w-full overflow-hidden bg-slate-100 relative cursor-pointer"
                     @click="lightboxOpen = true; lightboxSrc = '{{ $f->foto_utama ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop' }}'; lightboxCaption = '{{ addslashes($f->nama_fasilitas) }}'">
                    <img src="{{ $f->foto_utama ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop' }}" 
                         alt="{{ $f->nama_fasilitas }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[11px] px-2.5 py-1 rounded-lg backdrop-blur-xs flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Perbesar
                    </span>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h2 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
                        {{ $f->nama_fasilitas }}
                    </h2>

                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed mb-4">
                        {{ $f->deskripsi }}
                    </p>

                    <!-- Additional Photos Thumbnail if available -->
                    @if($f->fotoLainnya && $f->fotoLainnya->count() > 0)
                    <div class="mt-auto pt-3 border-t border-slate-100">
                        <span class="text-[11px] text-slate-400 block mb-2 font-medium">Foto Dokumentasi Terkait:</span>
                        <div class="flex items-center space-x-2">
                            @foreach($f->fotoLainnya as $foto)
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 cursor-pointer"
                                 @click="lightboxOpen = true; lightboxSrc = '{{ $foto->file_path }}'; lightboxCaption = '{{ addslashes($foto->keterangan ?? $f->nama_fasilitas) }}'">
                                <img src="{{ $foto->file_path }}" alt="Dokumentasi" class="w-full h-full object-cover hover:opacity-80 transition">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada data fasilitas yang ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
