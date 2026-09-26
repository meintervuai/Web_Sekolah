@extends('layouts.public')

@section('title', $post->judul . ' - Pengumuman Resmi ' . $sekolah['nama'])
@section('meta_description', Str::limit(strip_tags($post->ringkasan ?? $post->isi_konten), 160))

@section('content')
<!-- Breadcrumbs -->
<section class="bg-slate-100 py-4 border-b border-slate-200">
    <div class="container-custom">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-500 overflow-x-auto hide-scrollbar">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><span>/</span></li>
                <li><a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="hover:text-blue-600 transition">Pengumuman</a></li>
                <li><span>/</span></li>
                <li class="text-slate-800 font-semibold truncate max-w-xs md:max-w-md">{{ $post->judul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Section -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Announcement Paper / Body (8 cols) -->
            <article class="lg:col-span-8">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-10">
                    
                    <!-- Official Header Letterhead -->
                    <div class="flex items-center space-x-4 pb-6 mb-6 border-b-2 border-slate-900">
                        <div class="w-14 h-14 rounded-xl bg-blue-900 text-white flex items-center justify-center font-bold text-xl shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-slate-500 font-semibold block">Pemerintah Daerah Provinsi Jawa Barat • Dinas Pendidikan</span>
                            <h2 class="text-lg md:text-xl font-extrabold text-slate-900 font-heading">{{ $sekolah['nama'] }}</h2>
                            <p class="text-xs text-slate-500">{{ $sekolah['alamat'] }} • Telp: {{ $sekolah['telepon'] }}</p>
                        </div>
                    </div>

                    <!-- Meta Tags -->
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-6 text-xs text-slate-500">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-900 font-bold text-xs">
                            Pemberitahuan Kedinasan
                        </span>
                        <div class="flex items-center space-x-3">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($post->tgl_publikasi)->translatedFormat('l, d F Y') }}
                            </span>
                            <span>•</span>
                            <span>{{ $post->jumlah_dilihat ?? 0 }} views</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-extrabold text-slate-900 font-heading mb-6 leading-tight">
                        {{ $post->judul }}
                    </h1>

                    <!-- Summary Highlight -->
                    @if($post->ringkasan)
                    <div class="bg-amber-50/60 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
                        <p class="text-xs md:text-sm font-medium text-amber-900 leading-relaxed">
                            {{ $post->ringkasan }}
                        </p>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="max-w-[720px] prose prose-slate prose-headings:font-heading prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed prose-li:text-slate-700 mb-10">
                        {!! $post->isi_konten !!}
                    </div>

                    <!-- Official Signature Box -->
                    <div class="pt-8 border-t border-slate-200 mt-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 text-xs text-slate-600">
                        <div>
                            <p class="text-slate-400">Bandung, {{ \Carbon\Carbon::parse($post->tgl_publikasi)->translatedFormat('d F Y') }}</p>
                            <p class="font-bold text-slate-800 mt-1">Kepala SMK Negeri 2 Bandung</p>
                            <div class="h-16 flex items-end">
                                <span class="font-semibold text-slate-900 text-sm underline">{{ $sekolah['nama_kepsek'] ?? 'Dr. H. Hasanudin, M.Pd.' }}</span>
                            </div>
                            <p class="text-slate-500">NIP. {{ $sekolah['nip_kepsek'] ?? '19680512 199303 1 004' }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button onclick="window.print()" class="inline-flex items-center px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak Dokumen
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Back button -->
                <div class="mt-6">
                    <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Semua Pengumuman
                    </a>
                </div>
            </article>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Pengumuman Lainnya -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80">
                    <h3 class="text-base font-bold text-slate-900 font-heading mb-4 pb-3 border-b border-slate-200">
                        Pengumuman Terbaru Lainnya
                    </h3>
                    <div class="space-y-4">
                        @forelse($pengumumanLainnya as $pl)
                        <div class="pb-3 border-b border-slate-200/60 last:border-b-0 last:pb-0">
                            <span class="text-[11px] text-slate-400 block mb-1">
                                {{ \Carbon\Carbon::parse($pl->tgl_publikasi)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="text-xs font-bold text-slate-800 hover:text-blue-600 transition line-clamp-2">
                                <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $pl->slug) }}">
                                    {{ $pl->judul }}
                                </a>
                            </h4>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada pengumuman lain saat ini.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Hotline Informasi Sekolah -->
                <div class="bg-blue-50 border border-blue-200/70 rounded-2xl p-6">
                    <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Pusat Bantuan & Layanan</h4>
                    <p class="text-xs text-blue-800 leading-relaxed mb-4">Jika terdapat pertanyaan terkait isi pengumuman atau surat edaran ini, silakan hubungi bagian tata usaha sekolah.</p>
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
                        <span>Hubungi Tata Usaha Sekolah &raquo;</span>
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection
