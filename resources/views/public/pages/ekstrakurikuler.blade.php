@extends('layouts.public')

@section('title', 'Ekstrakurikuler - ' . $sekolah['nama'])
@section('meta_description', 'Kembangkan minat, bakat, kepemimpinan, dan kreativitas melalui 8 kegiatan ekstrakurikuler unggulan di ' . $sekolah['nama'])

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Right-Side Artistic Banner Image with Gradual Mask/Fade to Left & Theme Dark Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Ekstrakurikuler Sekolah" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Ekstrakurikuler</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Ekstrakurikuler Sekolah
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Wadah penyaluran bakat, pembentukan disiplin, inovasi teknologi, serta prestasi non-akademik siswa-siswi {{ $sekolah['nama'] }}.
            </p>
        </div>
    </div>
</section>

<!-- Ekstrakurikuler Grid -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($ekstrakurikuler as $ekskul)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition duration-200 flex flex-col h-full group">
                <!-- Cover Image -->
                <div class="aspect-4/3 w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $ekskul->gambar ?? 'https://images.unsplash.com/photo-1526676037777-05a232554f77?q=80&w=600&auto=format&fit=crop' }}" 
                         alt="{{ $ekskul->nama_ekskul }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <span class="absolute bottom-3 left-3 text-white text-xs font-semibold">
                        {{ $ekskul->jadwal ?? 'Jadwal Rutin' }}
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h2 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
                        <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler/' . $ekskul->slug) }}">
                            {{ $ekskul->nama_ekskul }}
                        </a>
                    </h2>

                    <p class="text-xs text-slate-600 line-clamp-3 mb-4 leading-relaxed">
                        {{ $ekskul->deskripsi }}
                    </p>

                    @if($ekskul->pembina)
                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 mb-4 text-[11px] text-slate-600 truncate">
                        Pembina: <strong class="text-slate-800">{{ $ekskul->pembina }}</strong>
                    </div>
                    @endif

                    <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">SMKN 2 Bandung</span>
                        <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler/' . $ekskul->slug) }}" 
                           class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
                            <span>Detail Ekskul</span>
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <p class="text-sm text-slate-500">Belum ada data ekstrakurikuler.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
