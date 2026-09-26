@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', $sekolah['deskripsi'] ?? 'Website Resmi SMK Negeri 2 Bandung - Sekolah Menengah Kejuruan Pusat Keunggulan di Kota Bandung.')

@section('content')

<!-- ==========================================
     1. HERO CAROUSEL SECTION (16:6 Desktop, 380px Tablet, 360px Mobile)
=========================================== -->
@if($fiturList['beranda'] ?? true)
<section class="relative w-full bg-slate-950 overflow-hidden" 
         x-data="{
             current: 0,
             total: {{ count($slider) }},
             autoplayTimer: null,
             paused: false,
             touchStartX: 0,
             touchEndX: 0,
             init() {
                 this.startAutoplay();
             },
             startAutoplay() {
                 if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                 this.autoplayTimer = setInterval(() => {
                     if (!this.paused) {
                         this.next();
                     }
                 }, 6000);
             },
             stopAutoplay() {
                 clearInterval(this.autoplayTimer);
             },
             next() {
                 this.current = (this.current + 1) % this.total;
             },
             prev() {
                 this.current = (this.current - 1 + this.total) % this.total;
             },
             handleTouchStart(e) {
                 this.touchStartX = e.changedTouches[0].screenX;
             },
             handleTouchEnd(e) {
                 this.touchEndX = e.changedTouches[0].screenX;
                 if (this.touchStartX - this.touchEndX > 50) this.next();
                 if (this.touchEndX - this.touchStartX > 50) this.prev();
             }
         }"
         @mouseenter="paused = true"
         @mouseleave="paused = false"
         @focusin="paused = true"
         @focusout="paused = false"
         @touchstart="handleTouchStart($event)"
         @touchend="handleTouchEnd($event)">
    
    <!-- Slides Container -->
    <div class="relative w-full h-[360px] sm:h-[380px] lg:h-[520px] 2xl:h-[560px]">
        @foreach($slider as $index => $item)
            <div x-show="current === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full"
                 style="display: none;">
                
                <!-- Background Image -->
                <img src="{{ $item->gambar }}" 
                     alt="{{ $item->judul ?? 'SMK Negeri 2 Bandung' }}" 
                     class="w-full h-full object-cover object-center"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                
                <!-- Overlay Gradients (35-45% contrast) -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/60 to-slate-950/30"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                <!-- Slide Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="container-custom w-full">
                        <div class="max-w-2xl text-white space-y-4">
                            <!-- Heading -->
                            <h2 class="font-heading font-extrabold text-2xl sm:text-4xl lg:text-5xl text-white leading-tight tracking-tight drop-shadow-md">
                                {{ $item->judul }}
                            </h2>

                            <!-- Subheading -->
                            <p class="text-sm sm:text-base lg:text-lg text-slate-200 line-clamp-2 sm:line-clamp-3 leading-relaxed drop-shadow font-normal max-w-xl">
                                {{ $item->subjudul }}
                            </p>

                            <!-- CTAs -->
                            <div class="pt-2 flex flex-wrap gap-3">
                                @if(!empty($item->link_tombol))
                                    @php
                                        $btnPath = ltrim($item->link_tombol, '/');
                                        $btnUrl = str_starts_with($item->link_tombol, 'http') ? $item->link_tombol : url(app('tenant')->slug . ($btnPath ? '/' . $btnPath : ''));
                                    @endphp
                                    <a href="{{ $btnUrl }}" 
                                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm btn-radius shadow-lg shadow-blue-600/30 transition-all hover:scale-105">
                                        {{ $item->teks_tombol ?? 'Pelajari Selengkapnya' }}
                                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                @endif
                                <a href="{{ url(app('tenant')->slug . '/profil') }}" 
                                   class="inline-flex items-center px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-bold text-sm btn-radius backdrop-blur-sm transition-all">
                                    Profil Sekolah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    @if(count($slider) > 1)
        <button @click="prev()" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-900/40 hover:bg-slate-900/80 border border-white/20 text-white flex items-center justify-center backdrop-blur-sm transition focus:outline-none"
                aria-label="Slide Sebelumnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-900/40 hover:bg-slate-900/80 border border-white/20 text-white flex items-center justify-center backdrop-blur-sm transition focus:outline-none"
                aria-label="Slide Selanjutnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-5 left-0 right-0 z-20 flex justify-center space-x-2">
            @foreach($slider as $index => $item)
                <button @click="current = {{ $index }}" 
                        :class="current === {{ $index }} ? 'w-8 bg-blue-500' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none"
                        aria-label="Pindah ke slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    @endif
</section>
@endif

<!-- ==========================================
     2. QUICK LINKS BAR
=========================================== -->
@if(false)
<section class="relative -mt-6 z-30">
    <div class="container-custom">
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 p-4 sm:p-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            
            <a href="{{ url(app('tenant')->slug . '/spmb') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">SPMB 2026</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Penerimaan Siswa</span>
            </a>

            <a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">7 Jurusan</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Program Keahlian</span>
            </a>

            <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">Agenda</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Kalender Event</span>
            </a>

            <a href="{{ url(app('tenant')->slug . '/berita') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">Berita</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Kabar Sekolah</span>
            </a>

            <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">Prestasi</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Capaian Siswa</span>
            </a>

            <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="flex flex-col items-center text-center p-3 rounded-xl hover:bg-blue-50/70 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-blue-900">Kontak</span>
                <span class="text-[11px] text-slate-500 hidden sm:block">Layanan & Peta</span>
            </a>

        </div>
    </div>
</section>
@endif

<!-- ==========================================
     2. SAMBUTAN KEPALA SEKOLAH & PROFIL SINGKAT
=========================================== -->
@if($fiturList['profil'] ?? true)
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left: Foto Kepsek (Rasio 1:1 / 4:5 Elegan) -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-700 to-indigo-600 rounded-3xl blur-lg opacity-30"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-xl border border-slate-100">
                        <img src="{{ $sekolahData['foto_kepsek'] }}" 
                             alt="{{ $sekolahData['kepsek'] }}" 
                             class="w-full h-80 sm:h-96 object-cover object-top">
                        <div class="p-5 bg-gradient-to-t from-slate-950 via-slate-900/90 to-transparent absolute bottom-0 inset-x-0 text-white">
                            <h3 class="font-heading font-bold text-lg text-white leading-tight">{{ $sekolahData['kepsek'] }}</h3>
                            <p class="text-xs text-blue-300 font-medium">Kepala SMK Negeri 2 Bandung</p>
                            <p class="text-[11px] text-slate-400">NIP. {{ $sekolahData['nip_kepsek'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Teks Sambutan -->
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center space-x-2 text-blue-700 font-bold text-xs uppercase tracking-wider bg-blue-50 px-3 py-1 rounded-full">
                    <span>Sambutan Kepala Sekolah</span>
                </div>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-slate-900 leading-tight">
                    Mewujudkan Pendidikan Vokasi yang Unggul, Adaptif, dan Berakhlak Mulia
                </h2>
                <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-3">
                    <p class="italic text-slate-700 font-medium border-l-4 border-blue-600 pl-4 py-1">
                        "{{ $sekolahData['sambutan'] }}"
                    </p>
                    <p>
                        Sebagai sekolah yang berdiri sejak 1951 di jantung Kota Bandung, kami terus berinovasi mengintegrasikan kurikulum industri, penguatan Teaching Factory (TEFA), sertifikasi keahlian berstandar BNSP, dan pembentukan karakter Profil Pelajar Pancasila.
                    </p>
                </div>
                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="{{ url(app('tenant')->slug . '/profil') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm btn-radius shadow-md transition">
                        Profil & Sejarah Lengkap
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ url(app('tenant')->slug . '/profil/visi-misi') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-sm btn-radius transition">
                        Visi & Misi Sekolah
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endif

<!-- ==========================================
     4. STATISTIK COUNTER RESMI (Viewport Animated)
=========================================== -->
<section class="section-py bg-gradient-to-br from-blue-950 via-slate-900 to-indigo-950 text-white relative overflow-hidden"
         x-data="{
             shown: false,
             startCounters() {
                 if (this.shown) return;
                 this.shown = true;
                 const elements = this.$el.querySelectorAll('[data-target]');
                 elements.forEach(el => {
                     const target = +el.getAttribute('data-target');
                     const duration = 1200;
                     const stepTime = 20;
                     const steps = duration / stepTime;
                     const increment = target / steps;
                     let current = 0;
                     const timer = setInterval(() => {
                         current += increment;
                         if (current >= target) {
                             el.innerText = target.toLocaleString('id-ID');
                             clearInterval(timer);
                         } else {
                             el.innerText = Math.floor(current).toLocaleString('id-ID');
                         }
                     }, stepTime);
                 });
             }
         }"
         x-intersect.once="startCounters()">
    <div class="container-custom relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white">SMK Negeri 2 Bandung dalam Angka</h2>
            <p class="text-xs sm:text-sm text-blue-200 mt-2">
                {{ $sekolahData['stat_sumber_label'] }}
            </p>
        </div>

        <!-- 6 Counters Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6 text-center">
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-blue-400" data-target="{{ $sekolahData['stat_siswa'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_siswa_label'] }}</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-amber-400" data-target="{{ $sekolahData['stat_guru'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_guru_label'] }}</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-emerald-400" data-target="{{ $sekolahData['stat_rombel'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_rombel_label'] }}</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-indigo-400" data-target="{{ $sekolahData['stat_kelas'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_kelas_label'] }}</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-cyan-400" data-target="{{ $sekolahData['stat_jurusan'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_jurusan_label'] }}</p>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-sm">
                <p class="font-heading font-black text-3xl sm:text-4xl text-rose-400" data-target="{{ $sekolahData['stat_mitra'] }}">0</p>
                <p class="text-xs sm:text-sm text-slate-300 font-semibold mt-1">{{ $sekolahData['stat_mitra_label'] }}</p>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================
     5. PROGRAM KEAHLIAN (7 JURUSAN UNGGULAN)
=========================================== -->
@if($fiturList['program_keahlian'] ?? true)
<section class="section-py bg-slate-50" id="jurusan">
    <div class="container-custom">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-6 sm:mb-9">
            <div>
                <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Konsentrasi Keahlian</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">7 Program Keahlian Resmi</h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Kurikulum selaras dengan kebutuhan dunia usaha dan dunia kerja (DUDI)</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-blue-700 hover:text-blue-900 shrink-0">
                Lihat Seluruh Detail Kurikulum &rarr;
            </a>
        </div>

        @if($jurusan->isEmpty())
            <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500">
                Data program keahlian belum tersedia.
            </div>
        @else
            <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
                @foreach($jurusan as $j)
                    <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-2xl overflow-hidden shadow-sm hover-card border border-slate-200/80 flex flex-col h-full">
                        <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
                            <img src="{{ $j->ikon_atau_foto ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800' }}" 
                                 alt="{{ $j->nama_jurusan }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-heading font-bold text-base text-slate-900 leading-snug line-clamp-2">
                                    {{ $j->nama_jurusan }}
                                </h3>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $j->deskripsi_singkat }}
                                </p>
                            </div>
                            <div class="pt-4 mt-auto">
                                <a href="{{ url(app('tenant')->slug . '/program-keahlian/' . $j->slug) }}" 
                                   class="w-full py-2 bg-slate-50 hover:bg-blue-50 text-blue-800 hover:text-blue-900 font-bold text-xs btn-radius flex items-center justify-center border border-slate-200 transition">
                                    Detail Kompetensi
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
@endif

<!-- ==========================================
     6. BERITA & PENGUMUMAN PENTING (SPLIT GRID)
=========================================== -->
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
            
            <!-- Left: Berita Terbaru (8 Cols) -->
            @if($fiturList['berita'] ?? true)
            <div class="lg:col-span-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Publikasi</span>
                        <h2 class="font-heading font-extrabold text-2xl text-slate-900">Kabar & Berita Terbaru</h2>
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/berita') }}" class="text-xs sm:text-sm font-bold text-blue-700 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                @if($berita->isEmpty())
                    <div class="p-8 text-center bg-slate-50 rounded-2xl text-slate-500">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @else
                    <div class="flex sm:grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
                        @foreach($berita as $post)
                            <article class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover-card flex flex-col h-full">
                                <div class="relative h-40 w-full overflow-hidden bg-slate-100">
                                    <img src="{{ $post->gambar_sampul ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800' }}" 
                                         alt="{{ $post->judul }}" 
                                         class="w-full h-full object-cover">
                                    @if($post->kategori)
                                        <span class="absolute top-2.5 left-2.5 bg-blue-900/90 text-white text-[11px] font-semibold px-2 py-0.5 rounded backdrop-blur-sm">
                                            {{ $post->kategori->nama_kategori }}
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <p class="text-[11px] text-slate-400 font-medium">
                                            {{ $post->tgl_publikasi ? $post->tgl_publikasi->translatedFormat('d M Y') : date('d M Y') }}
                                        </p>
                                        <h3 class="font-heading font-bold text-sm text-slate-900 mt-1 line-clamp-2 leading-snug">
                                            <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="hover:text-blue-700">
                                                {{ $post->judul }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                            {{ $post->ringkasan }}
                                        </p>
                                    </div>
                                    <div class="pt-3 mt-2 border-t border-slate-100">
                                        <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center">
                                            Baca Selengkapnya &rarr;
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            <!-- Right: Pengumuman Resmi (4 Cols) -->
            @if($fiturList['pengumuman'] ?? true)
            <div class="lg:col-span-4">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <span class="text-amber-600 font-bold text-xs uppercase tracking-wider">Informasi Resmi</span>
                        <h2 class="font-heading font-extrabold text-2xl text-slate-900">Pengumuman</h2>
                    </div>
                    <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="text-xs sm:text-sm font-bold text-amber-600 hover:underline">
                        Semua &rarr;
                    </a>
                </div>

                @if($pengumuman->isEmpty())
                    <div class="p-8 text-center bg-slate-50 rounded-2xl text-slate-500">
                        Tidak ada pengumuman saat ini.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($pengumuman as $p)
                            <div class="p-4 bg-amber-50/60 hover:bg-amber-50 border border-amber-200/70 rounded-2xl transition">
                                <div class="flex items-center justify-between text-[11px] text-amber-800 font-semibold mb-1">
                                    <span class="bg-amber-200 text-amber-900 px-2 py-0.5 rounded text-[10px]">PENTING</span>
                                    <span>{{ $p->tgl_publikasi ? $p->tgl_publikasi->translatedFormat('d M Y') : date('d M Y') }}</span>
                                </div>
                                <h3 class="font-heading font-bold text-xs sm:text-sm text-slate-900 leading-snug line-clamp-2">
                                    <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" class="hover:text-amber-700">
                                        {{ $p->judul }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 mt-1 line-clamp-2">
                                    {{ $p->ringkasan }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</section>

<!-- ==========================================
     7. AGENDA KEGIATAN MENDATANG
=========================================== -->
@if($fiturList['agenda'] ?? true)
<section class="section-py bg-slate-100/70">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Agenda Kegiatan</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Jadwal & Agenda Sekolah</h2>
                <p class="text-xs sm:text-sm text-slate-600">Aktivitas resmi dan agenda akademik mendatang</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hidden md:inline-flex items-center text-sm font-bold text-blue-700 hover:text-blue-900">
                Lihat Kalender Lengkap &rarr;
            </a>
        </div>

        @if($agenda->isEmpty())
            <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500">
                Belum ada agenda terdekat.
            </div>
        @else
            <div class="flex sm:grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
                @foreach($agenda as $item)
                    <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover-card flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-start space-x-3 mb-3">
                                <!-- Date Badge -->
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-900 to-indigo-700 text-white rounded-xl flex flex-col items-center justify-center shrink-0 shadow-sm">
                                    <span class="font-extrabold text-lg leading-none">{{ $item->tgl_mulai ? $item->tgl_mulai->format('d') : '01' }}</span>
                                    <span class="text-[10px] uppercase font-bold text-blue-200 mt-0.5">{{ $item->tgl_mulai ? $item->tgl_mulai->format('M') : 'Jan' }}</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                        {{ $item->penyelenggara ?? 'Humas SMKN 2' }}
                                    </span>
                                    <h3 class="font-heading font-bold text-sm text-slate-900 mt-1 line-clamp-2 leading-snug">
                                        {{ $item->judul }}
                                    </h3>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                {{ $item->ringkasan }}
                            </p>
                            <div class="mt-3 pt-3 border-t border-slate-100 text-xs text-slate-500 space-y-1">
                                <div class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $item->jam_mulai ?? '08.00' }} - {{ $item->jam_selesai ?? 'Selesai' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span class="truncate">{{ $item->lokasi ?? 'SMK Negeri 2 Bandung' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 mt-3">
                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}" 
                               class="w-full py-2 bg-slate-50 hover:bg-blue-50 text-blue-800 text-xs font-bold btn-radius flex items-center justify-center border border-slate-200 transition">
                                Detail Agenda
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

<!-- ==========================================
     8. PRESTASI SISWA & EKSTRAKURIKULER
=========================================== -->
@if($fiturList['prestasi'] ?? true)
<section class="section-py bg-white">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Bakat & Kejuaraan</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-1">Prestasi Membanggakan</h2>
                <p class="text-xs sm:text-sm text-slate-600">Dedikasi siswa berprestasi di tingkat Kota, Provinsi, dan Nasional</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hidden md:inline-flex items-center text-sm font-bold text-blue-700 hover:text-blue-900">
                Lihat Seluruh Prestasi &rarr;
            </a>
        </div>

        <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
            @foreach($prestasi as $pres)
                <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover-card flex flex-col justify-between h-full">
                    <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $pres->foto }}" alt="{{ $pres->nama_prestasi }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-amber-500 text-slate-950 font-bold text-[10px] px-2.5 py-0.5 rounded-full shadow">
                            Tingkat {{ $pres->tingkat ?? 'Nasional' }}
                        </span>
                        <span class="absolute top-3 right-3 bg-slate-900/80 text-white font-bold text-[10px] px-2 py-0.5 rounded backdrop-blur-sm">
                            {{ $pres->tahun ?? date('Y') }}
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-bold text-blue-800">{{ $pres->nama_siswa }}</p>
                            <h3 class="font-heading font-bold text-sm text-slate-900 mt-1 line-clamp-2 leading-snug">
                                {{ $pres->nama_prestasi }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">
                                {{ $pres->deskripsi }}
                            </p>
                        </div>
                        <div class="pt-3 mt-2 border-t border-slate-100">
                            <a href="{{ url(app('tenant')->slug . '/prestasi/' . ($pres->slug ?? $pres->id)) }}" class="text-xs font-bold text-blue-700 hover:underline">
                                Rincian Capaian &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ==========================================
     9. GALERI FOTO UNGGULAN
=========================================== -->
@if($fiturList['galeri'] ?? true)
<section class="section-py bg-slate-950 text-white">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <span class="text-blue-400 font-bold text-xs uppercase tracking-wider">Dokumentasi</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">Galeri Aktivitas Siswa</h2>
                <p class="text-xs sm:text-sm text-slate-400">Potret keceriaan dan produktivitas di lingkungan SMK Negeri 2 Bandung</p>
            </div>
            <a href="{{ url(app('tenant')->slug . '/galeri') }}" class="hidden md:inline-flex items-center text-sm font-bold text-blue-400 hover:text-blue-300">
                Buka Seluruh Album &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($galeri as $item)
                <div class="group relative rounded-xl overflow-hidden aspect-square bg-slate-800 cursor-pointer shadow-md"
                     @click="lightboxSrc = '{{ $item->file_media_atau_link }}'; lightboxCaption = '{{ addslashes($item->judul_item ?? 'Foto Galeri SMKN 2 Bandung') }}'; lightboxOpen = true">
                    <img src="{{ $item->file_media_atau_link }}" 
                         alt="{{ $item->judul_item ?? 'Foto' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-2 text-center">
                        <p class="text-[11px] font-semibold text-white line-clamp-2">{{ $item->judul_item ?? 'Lihat Foto' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ==========================================
     10. CTA SPMB 2026/2027 BANNER
=========================================== -->
@if($fiturList['spmb'] ?? true)
<section class="section-py bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-950 text-white relative">
    <div class="container-custom">
        <div class="bg-white/10 border border-white/20 rounded-3xl p-8 sm:p-12 backdrop-blur-md text-center max-w-3xl mx-auto space-y-4">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-xs uppercase tracking-wider border border-emerald-400/30">
                Penerimaan Peserta Didik Baru
            </span>
            <h2 class="font-heading font-extrabold text-2xl sm:text-4xl text-white leading-tight">
                Bergabunglah Bersama SMK Negeri 2 Bandung Tahun Ajaran 2026/2027
            </h2>
            <p class="text-xs sm:text-base text-slate-200 max-w-xl mx-auto leading-relaxed">
                Raih kompetensi vokasi terbaik dengan pengakuan sertifikasi industri nasional dan internasional. Dapatkan informasi syarat, jalur, dan alur pendaftaran resmi.
            </p>
            <div class="pt-3 flex flex-wrap justify-center gap-4">
                <a href="{{ url(app('tenant')->slug . '/spmb') }}" 
                   class="px-6 py-3 bg-white text-blue-900 hover:bg-blue-50 font-bold text-sm btn-radius shadow-lg transition hover:scale-105">
                    Informasi & Syarat SPMB
                </a>
                <a href="{{ url(app('tenant')->slug . '/kontak') }}" 
                   class="px-6 py-3 bg-transparent hover:bg-white/10 border border-white/40 text-white font-bold text-sm btn-radius transition">
                    Hubungi Panitia SPMB
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ==========================================
     11. LOKASI & GOOGLE MAPS
=========================================== -->
@if($fiturList['kontak'] ?? true)
<section class="section-py bg-slate-50 border-t border-slate-200">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-5 space-y-4">
                <span class="text-blue-700 font-bold text-xs uppercase tracking-wider">Lokasi Kampus</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">Kunjungi SMK Negeri 2 Bandung</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Terletak strategis di kawasan Bandung Wetan, mudah diakses melalui transportasi umum dan kendaraan pribadi.
                </p>
                <div class="space-y-2 text-sm text-slate-700">
                    <p class="flex items-start">
                        <strong class="w-24 shrink-0 text-slate-900">Alamat:</strong>
                        <span>{{ $sekolahData['alamat'] }}</span>
                    </p>
                    <p class="flex items-center">
                        <strong class="w-24 shrink-0 text-slate-900">Telepon:</strong>
                        <span>{{ $sekolahData['telepon'] }}</span>
                    </p>
                    <p class="flex items-center">
                        <strong class="w-24 shrink-0 text-slate-900">Email:</strong>
                        <span>{{ $sekolahData['email'] }}</span>
                    </p>
                    <p class="flex items-center">
                        <strong class="w-24 shrink-0 text-slate-900">Jam Layanan:</strong>
                        <span>{{ $sekolahData['jam_layanan'] }}</span>
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm btn-radius shadow-md transition">
                        Kirim Pesan / Pengaduan &rarr;
                    </a>
                </div>
            </div>
            
            <div class="lg:col-span-7">
                <div class="rounded-2xl overflow-hidden shadow-md border border-slate-200 h-80 sm:h-96 w-full bg-slate-200">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.915720919426!2d107.62512397499625!3d-6.900693593098544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c39f06121%3A0x6b4887342617f164!2sSMK%20Negeri%202%20Bandung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi SMK Negeri 2 Bandung"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection
