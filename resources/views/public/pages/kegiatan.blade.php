@extends('layouts.public')

@section('title', 'Dokumentasi Kegiatan & Aktivitas Sekolah - ' . $sekolah['nama'])
@section('meta_description', 'Dokumentasi aktivitas belajar mengajar, upacara, peringatan hari besar, workshop industri, dan event siswa di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Full-Width Hero Banner Image with Dark Theme Gradient Overlay -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Aktivitas & Kegiatan Sekolah" 
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-950/60"></div>
            <div class="absolute inset-0" style="background: linear-gradient(135deg, color-mix(in srgb, var(--theme-header,#0f172a) 85%, black 15%) 0%, color-mix(in srgb, var(--theme-header,#0f172a) 40%, transparent) 70%, transparent 100%); opacity: 0.85;"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Aktivitas &amp; Kegiatan</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Aktivitas &amp; Kegiatan Sekolah
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Potret dinamika kehidupan kampus {{ $sekolah['nama'] }}, mencakup pembelajaran praktik vokasi, apel kebangsaan, pentas seni, dan kerja sama dunia industri.
            </p>
        </div>
    </div>
</section>

<!-- Kegiatan / Album Dokumentasi Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-slate-900 font-heading">Album Dokumentasi Terbaru</h2>
            <p class="text-xs md:text-sm text-slate-500">Kumpulan momen kegiatan dan pembelajaran di lingkungan sekolah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($album as $alb)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition duration-200 flex flex-col group">
                <!-- Cover Image -->
                <div class="aspect-16/10 w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $alb->cover ?? 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=800&auto=format&fit=crop' }}" 
                         alt="{{ $alb->nama_album }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-xs text-white text-xs font-bold px-2.5 py-1 rounded-lg">
                        {{ $alb->items->count() }} Foto
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
                        {{ $alb->nama_album }}
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                        {{ $alb->deskripsi }}
                    </p>

                    <!-- Preview Thumbnail Strip -->
                    @if($alb->items->count() > 0)
                    <div class="grid grid-cols-4 gap-2 pt-3 border-t border-slate-100 mb-4">
                        @foreach($alb->items->take(4) as $item)
                        <div class="aspect-square rounded-lg overflow-hidden bg-slate-100 cursor-pointer"
                             @click="lightboxOpen = true; lightboxSrc = '{{ $item->file_path }}'; lightboxCaption = '{{ addslashes($item->caption ?? $alb->nama_album) }}'">
                            <img src="{{ $item->file_path }}" alt="Preview" class="w-full h-full object-cover hover:opacity-80 transition">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-xs text-slate-400">SMKN 2 Bandung</span>
                        <a href="{{ url(app('tenant')->slug . '/galeri') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                            Buka Galeri Penuh &raquo;
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada album kegiatan yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>

        <!-- Upcoming & Recent Events Timeline -->
        <div class="mt-16 bg-white rounded-2xl p-6 md:p-10 border border-slate-200/80 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 font-heading">Jadwal Event & Kegiatan Mendatang</h2>
                    <p class="text-xs text-slate-500">Pantau agenda besar sekolah yang sedang dan akan berlangsung.</p>
                </div>
                <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                    Lihat Kalender Lengkap &raquo;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($agenda as $ag)
                <div class="flex items-start space-x-4 p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex flex-col items-center justify-center shrink-0 text-center font-heading">
                        <span class="text-[10px] uppercase font-bold leading-none">{{ \Carbon\Carbon::parse($ag->tgl_mulai)->translatedFormat('M') }}</span>
                        <span class="text-lg font-extrabold leading-none mt-0.5">{{ \Carbon\Carbon::parse($ag->tgl_mulai)->translatedFormat('d') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-slate-900 hover:text-blue-600 transition truncate">
                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $ag->slug) }}">{{ $ag->judul }}</a>
                        </h4>
                        <div class="flex items-center space-x-3 text-xs text-slate-500 mt-1">
                            <span>📍 {{ $ag->lokasi ?? 'Kampus' }}</span>
                            <span>•</span>
                            <span>⏰ {{ $ag->jam_mulai ? substr($ag->jam_mulai, 0, 5) . ' WIB' : 'Menyesuaikan' }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic">Belum ada agenda kegiatan mendatang.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>
@endsection
