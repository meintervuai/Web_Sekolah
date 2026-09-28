@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', $sekolah['deskripsi'] ?? 'Website Resmi SMK Negeri 2 Bandung - Sekolah Menengah Kejuruan Pusat Keunggulan di Kota Bandung.')

@section('content')

@php
$tenantSlug = app()->bound('tenant') ? app('tenant')->slug : 'smk-negeri-2-bandung';
@endphp

<!-- ==========================================
     1. HERO CAROUSEL SECTION (Clean, Kontras Tinggi, Elegan)
=========================================== -->
@if($fiturList['beranda'] ?? true)
<section class="relative w-full theme-bg-dark overflow-hidden"
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
  <div class="relative w-full h-[380px] sm:h-[420px] lg:h-[540px]">
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

      <!-- Background Media (Video atau Gambar) -->
      @if(!empty($item->video))
      <video src="{{ $item->video }}"
        class="w-full h-full object-cover object-center"
        autoplay
        muted
        playsinline
        @if(count($slider) > 1)
          @ended="next()"
        @else
          loop
        @endif></video>
      @elseif(!empty($item->gambar))
      <img src="{{ $item->gambar }}"
        alt="{{ $item->judul ?? 'SMK Negeri 2 Bandung' }}"
        class="w-full h-full object-cover object-center"
        loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
      @endif

      <!-- Clean High-Contrast Overlay -->
      <div class="absolute inset-0 bg-blue-950/85"></div>

      <!-- Slide Content -->
      <div class="absolute inset-0 flex items-center">
        <div class="container-custom w-full">
          <div class="max-w-3xl text-white space-y-4">

            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-md bg-white/10 text-white text-xs font-semibold tracking-wide border border-white/20">
              <span>Akreditasi {{ $sekolahData['akreditasi'] }}</span>
              <span>&bull;</span>
              <span>NPSN {{ $sekolahData['npsn'] }}</span>
            </div>

            <h1 class="font-heading font-bold text-2xl sm:text-4xl lg:text-5xl text-white leading-tight">
              {{ $item->judul }}
            </h1>

            <p class="text-sm sm:text-base lg:text-lg text-slate-200 line-clamp-2 sm:line-clamp-3 leading-relaxed max-w-2xl font-normal">
              {{ $item->subjudul }}
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-3">
              @if(!empty($item->link_tombol))
              @php
              $btnPath = ltrim($item->link_tombol, '/');
              $btnUrl = str_starts_with($item->link_tombol, 'http') ? $item->link_tombol : url(app('tenant')->slug . ($btnPath ? '/' . $btnPath : ''));
              @endphp
              <a href="{{ $btnUrl }}"
                class="inline-flex items-center px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm">
                {{ $item->teks_tombol ?? 'Pelajari Selengkapnya' }}
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </a>
              @endif
              <a href="{{ url(app('tenant')->slug . '/profil') }}"
                class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold text-sm rounded-lg transition-colors">
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
    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-900/60 hover:bg-slate-900 border border-white/20 text-white flex items-center justify-center transition focus:outline-none"
    aria-label="Slide Sebelumnya">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
  </button>
  <button @click="next()"
    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-900/60 hover:bg-slate-900 border border-white/20 text-white flex items-center justify-center transition focus:outline-none"
    aria-label="Slide Selanjutnya">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
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
     BANNER HERO BERANDA (Tepat di Atas Sambutan Kepala Sekolah)
=========================================== -->
@php
$hasHeroBannerImg = !empty($sekolahData['hero_banner']);
$hasHeroBannerVid = !empty($sekolahData['hero_banner_video']);
@endphp

@if($hasHeroBannerImg || $hasHeroBannerVid)
<section class="w-full theme-bg-dark border-b border-slate-200 relative overflow-hidden"
  x-data="{
    hasImage: {{ $hasHeroBannerImg ? 'true' : 'false' }},
    hasVideo: {{ $hasHeroBannerVid ? 'true' : 'false' }},
    // Mode: 'video' atau 'image'
    currentMode: '{{ $hasHeroBannerVid ? 'video' : 'image' }}',
    isMuted: true,
    videoEnded: false,
    imageTimer: null,
    
    init() {
      // Skenario 1: Hanya Gambar -> Slideshow gambar
      // Skenario 2: Hanya Video -> Looping video
      // Skenario 3: Ada Keduanya -> Putar video sampai selesai (ended), lalu ganti ke gambar
      if (this.hasVideo) {
        this.playVideo();
      }
    },
    
    playVideo() {
      this.$nextTick(() => {
        const vid = this.$refs.heroVideo;
        if (vid) {
          vid.currentTime = 0;
          vid.play().catch(e => console.log('Autoplay deferred:', e));
        }
      });
    },

    handleVideoEnded() {
      if (this.hasImage) {
        // Jika ada keduanya: setelah video selesai diputar, beralih ke gambar
        this.videoEnded = true;
        this.currentMode = 'image';
      } else {
        // Jika hanya video: looping pemutaran
        const vid = this.$refs.heroVideo;
        if (vid) {
          vid.currentTime = 0;
          vid.play();
        }
      }
    },

    toggleMute() {
      const vid = this.$refs.heroVideo;
      if (vid) {
        this.isMuted = !this.isMuted;
        vid.muted = this.isMuted;
      }
    },

    replayVideo() {
      this.currentMode = 'video';
      this.videoEnded = false;
      this.playVideo();
    },

    switchToImage() {
      this.currentMode = 'image';
    }
  }">

  <div class="relative w-full h-72 sm:h-96 lg:h-[480px] bg-slate-950/90 overflow-hidden group">
    
    <!-- 1. Video Player Container -->
    @if($hasHeroBannerVid)
    <div x-show="currentMode === 'video'"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 w-full h-full">
      
      <video x-ref="heroVideo"
             src="{{ $sekolahData['hero_banner_video'] }}"
             class="w-full h-full object-cover object-center"
             autoplay
             muted
             playsinline
             @ended="handleVideoEnded()"
             {{ !$hasHeroBannerImg ? 'loop' : '' }}>
        Browser Anda tidak mendukung tag video HTML5.
      </video>
    </div>
    @endif

    <!-- 2. Image Container (Slideshow / Cover) -->
    @if($hasHeroBannerImg)
    <div x-show="currentMode === 'image'"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-102"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 w-full h-full"
         style="{{ $hasHeroBannerVid ? 'display: none;' : '' }}">
      
      <img src="{{ $sekolahData['hero_banner'] }}"
           alt="Banner Hero {{ $sekolahData['nama'] }}"
           class="w-full h-full object-cover object-center transform transition duration-700 group-hover:scale-[1.01]"
           loading="lazy">
    </div>
    @endif

    <!-- Overlay Gradien Elegan & Kontras Tinggi -->
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/40 to-transparent pointer-events-none"></div>

    <!-- Teks Overlay Judul & Tagline -->
    <div class="absolute inset-0 flex items-end pointer-events-none">
      <div class="container-custom p-6 sm:p-8 text-white space-y-2.5 w-full pointer-events-auto">
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center px-3 py-1 rounded-md bg-blue-600/90 text-white text-xs font-bold tracking-wide uppercase shadow-2xs">
            Sekolah Pusat Keunggulan
          </span>
          @if($hasHeroBannerVid && $hasHeroBannerImg)
          <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-blue-900/60 backdrop-blur-xs text-[11px] font-semibold text-blue-100 border border-white/10">
            <template x-if="currentMode === 'video'">
              <span class="flex items-center gap-1 text-emerald-400">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Memutar Video
              </span>
            </template>
            <template x-if="currentMode === 'image'">
              <span class="flex items-center gap-1 text-blue-300">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Banner Foto
              </span>
            </template>
          </span>
          @endif
        </div>

        <h2 class="font-heading font-bold text-xl sm:text-2xl lg:text-3xl text-white drop-shadow-xs leading-tight">
          {{ $sekolahData['nama'] }}
        </h2>
        
        <p class="text-xs sm:text-sm text-slate-200 line-clamp-1 sm:line-clamp-2 max-w-2xl font-normal">
          {{ $sekolahData['slogan'] }}
        </p>
      </div>
    </div>

    <!-- Kontrol Interaktif (Audio & Switcher Video/Gambar) -->
    <div class="absolute top-4 right-4 z-20 flex items-center gap-2">
      @if($hasHeroBannerVid)
      <!-- Tombol Audio Mute/Unmute -->
      <button type="button"
              @click="toggleMute()"
              x-show="currentMode === 'video'"
              class="px-3 py-1.5 rounded-lg bg-blue-950/80 hover:bg-blue-950 border border-white/20 text-white text-xs font-semibold backdrop-blur-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer">
        <template x-if="isMuted">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
            <span>Unmute</span>
          </span>
        </template>
        <template x-if="!isMuted">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
            <span>Suara Aktif</span>
          </span>
        </template>
      </button>

      <!-- Tombol Putar Ulang Video bila sudah berganti ke Gambar -->
      @if($hasHeroBannerImg)
      <button type="button"
              @click="replayVideo()"
              x-show="currentMode === 'image'"
              class="px-3 py-1.5 rounded-lg bg-blue-600/90 hover:bg-blue-600 text-white text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Putar Video</span>
      </button>

      <!-- Tombol Langsung Lihat Gambar bila sedang di Video -->
      <button type="button"
              @click="switchToImage()"
              x-show="currentMode === 'video'"
              class="px-3 py-1.5 rounded-lg bg-blue-950/80 hover:bg-blue-950 border border-white/20 text-white text-xs font-semibold backdrop-blur-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <span>Lihat Gambar</span>
      </button>
      @endif
      @endif
    </div>

  </div>
</section>
@endif

<!-- ==========================================
     2. SAMBUTAN KEPALA SEKOLAH & PROFIL SINGKAT
=========================================== -->
@if($fiturList['profil'] ?? true)
<section class="section-py bg-white border-b border-slate-200">
  <div class="container-custom">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

      <!-- Left: Foto Kepsek (Rasio Elegan, Card Bersih) -->
      <div class="lg:col-span-5 flex justify-center">
        <div class="w-full max-w-sm rounded-xl overflow-hidden border border-slate-200 bg-white shadow-sm">
          <img src="{{ $sekolahData['foto_kepsek'] }}"
            alt="{{ $sekolahData['kepsek'] }}"
            class="w-full h-80 sm:h-96 object-cover object-top">
          <div class="p-5 bg-slate-900 text-white">
            <h3 class="font-heading font-bold text-base sm:text-lg text-white leading-tight">{{ $sekolahData['kepsek'] }}</h3>
            <p class="text-xs text-slate-300 font-medium mt-0.5">Kepala SMK Negeri 2 Bandung</p>
            <p class="text-[11px] text-slate-400 mt-1">NIP. {{ $sekolahData['nip_kepsek'] }}</p>
          </div>
        </div>
      </div>

      <!-- Right: Teks Sambutan -->
      <div class="lg:col-span-7 space-y-4">
        <div class="inline-flex items-center text-slate-600 font-semibold text-xs uppercase tracking-wider bg-slate-100 px-3 py-1 rounded-md">
          <span>Sambutan Kepala Sekolah</span>
        </div>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-slate-900 leading-tight">
          Mewujudkan Pendidikan Vokasi yang Unggul, Adaptif, dan Berkarakter
        </h2>
        <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-3">
          <p class="italic text-slate-800 font-medium border-l-4 border-blue-700 pl-4 py-1">
            "{{ $sekolahData['sambutan'] }}"
          </p>
          <p>
            Sebagai sekolah yang berdiri sejak 1951 di jantung Kota Bandung, kami terus berinovasi mengintegrasikan kurikulum industri, penguatan Teaching Factory (TEFA), sertifikasi keahlian berstandar BNSP, dan pembentukan karakter Profil Pelajar Pancasila.
          </p>
        </div>
        <div class="pt-2 flex flex-wrap gap-3">
          <a href="{{ url(app('tenant')->slug . '/profil') }}"
            class="inline-flex items-center px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-lg transition-colors">
            Profil Lengkap
            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
          <a href="{{ url(app('tenant')->slug . '/profil/visi-misi') }}"
            class="inline-flex items-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-sm rounded-lg transition-colors border border-slate-200">
            Visi & Misi Sekolah
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
@endif

<!-- ==========================================
     3. VIDEO PROFIL RESMI SEKOLAH
=========================================== -->
@if(!empty($sekolahData['video_profil']))
<section class="section-py bg-slate-900 text-white border-b border-slate-800">
  <div class="container-custom">
    <div class="max-w-3xl mx-auto text-center mb-8">
      <span class="inline-block px-3 py-1 rounded-md bg-white/10 text-slate-300 font-semibold text-xs uppercase tracking-wider border border-white/20">
        Dokumentasi Audio Visual
      </span>
      <h2 class="font-heading font-bold text-2xl sm:text-3xl text-white mt-2">
        {{ $sekolahData['video_profil_judul'] ?? 'Video Profil Resmi Sekolah' }}
      </h2>
      <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-xl mx-auto leading-relaxed">
        {{ $sekolahData['video_profil_deskripsi'] ?? 'Saksikan tayangan lingkungan belajar, sarana praktik industri, dan kreativitas siswa kami.' }}
      </p>
    </div>

    <div class="max-w-4xl mx-auto rounded-xl overflow-hidden border border-slate-800 shadow-xl bg-black aspect-video relative">
      @php
      $videoUrl = $sekolahData['video_profil'];
      $isYouTube = Str::contains($videoUrl, ['youtube.com', 'youtu.be']);
      $ytEmbed = '';
      if ($isYouTube) {
      if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $videoUrl, $match)) {
      $ytEmbed = 'https://www.youtube.com/embed/' . $match[1] . '?rel=0';
      }
      }
      @endphp

      @if($ytEmbed)
      <iframe
        src="{{ $ytEmbed }}"
        title="{{ $sekolahData['video_profil_judul'] ?? 'Video Profil' }}"
        class="w-full h-full border-0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
      @else
      <video controls class="w-full h-full object-cover">
        <source src="{{ $videoUrl }}" type="video/mp4">
        Browser Anda tidak mendukung pemutar video HTML5.
      </video>
      @endif
    </div>
  </div>
</section>
@endif



<!-- ==========================================
     5. PROGRAM KEAHLIAN (7 JURUSAN UNGGULAN)
=========================================== -->
@if($fiturList['program_keahlian'] ?? true)
<section class="section-py bg-slate-50 border-b border-slate-200" id="jurusan">
  <div class="container-custom">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8">
      <div>
        <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Konsentrasi Keahlian</span>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-slate-900 mt-1">7 Program Keahlian Resmi</h2>
        <p class="text-xs sm:text-sm text-slate-600 mt-1">Kurikulum selaras dengan kebutuhan dunia usaha dan dunia kerja (DUDI)</p>
      </div>
      <a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="inline-flex items-center text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800 shrink-0">
        Lihat Seluruh Detail Kurikulum &rarr;
      </a>
    </div>

    @if($jurusan->isEmpty())
    <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-500">
      Data program keahlian belum tersedia.
    </div>
    @else
    <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
      @foreach($jurusan as $j)
      <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-xl overflow-hidden shadow-xs hover-card border border-slate-200 flex flex-col h-full">
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
              class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs rounded-lg flex items-center justify-center border border-slate-200 transition-colors">
              Detail Kompetensi
              <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
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
<section class="section-py bg-white border-b border-slate-200">
  <div class="container-custom">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

      <!-- Left: Berita Terbaru (8 Cols) -->
      @if($fiturList['berita'] ?? true)
      <div class="lg:col-span-8">
        <div class="flex justify-between items-center mb-6">
          <div>
            <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Publikasi</span>
            <h2 class="font-heading font-bold text-2xl text-slate-900">Kabar & Berita Terbaru</h2>
          </div>
          <a href="{{ url(app('tenant')->slug . '/berita') }}" class="text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800">
            Lihat Semua &rarr;
          </a>
        </div>

        @if($berita->isEmpty())
        <div class="p-8 text-center bg-slate-50 rounded-xl text-slate-500 border border-slate-200">
          Belum ada berita yang dipublikasikan.
        </div>
        @else
        <div class="flex sm:grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
          @foreach($berita as $post)
          <article class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs hover-card flex flex-col h-full">
            <div class="relative h-40 w-full overflow-hidden bg-slate-100">
              <img src="{{ $post->gambar_sampul ?? 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800' }}"
                alt="{{ $post->judul }}"
                class="w-full h-full object-cover">
              @if($post->kategori)
              <span class="absolute top-2.5 left-2.5 bg-slate-900/90 text-white text-[11px] font-semibold px-2 py-0.5 rounded">
                {{ $post->kategori->nama_kategori }}
              </span>
              @endif
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between">
              <div>
                <p class="text-[11px] text-slate-500 font-medium">
                  {{ $post->tgl_publikasi ? $post->tgl_publikasi->translatedFormat('d M Y') : date('d M Y') }}
                </p>
                <h3 class="font-heading font-bold text-sm text-slate-900 mt-1 line-clamp-2 leading-snug">
                  <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="hover:text-blue-700 transition-colors">
                    {{ $post->judul }}
                  </a>
                </h3>
                <p class="text-xs text-slate-600 mt-1.5 line-clamp-2 leading-relaxed">
                  {{ $post->ringkasan }}
                </p>
              </div>
              <div class="pt-3 mt-2 border-t border-slate-100">
                <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800 inline-flex items-center">
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
            <span class="text-slate-600 font-semibold text-xs uppercase tracking-wider">Informasi Resmi</span>
            <h2 class="font-heading font-bold text-2xl text-slate-900">Pengumuman</h2>
          </div>
          <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800">
            Semua &rarr;
          </a>
        </div>

        @if($pengumuman->isEmpty())
        <div class="p-8 text-center bg-slate-50 rounded-xl text-slate-500 border border-slate-200">
          Tidak ada pengumuman saat ini.
        </div>
        @else
        <div class="space-y-3">
          @foreach($pengumuman->take(2) as $p)
          <div class="p-4 bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-xl transition-colors">
            <div class="flex items-center justify-between text-[11px] text-slate-600 font-semibold mb-1">
              <span class="bg-slate-200 text-slate-800 px-2 py-0.5 rounded text-[10px]">PENTING</span>
              <span>{{ $p->tgl_publikasi ? $p->tgl_publikasi->translatedFormat('d M Y') : date('d M Y') }}</span>
            </div>
            <h3 class="font-heading font-bold text-xs sm:text-sm text-slate-900 leading-snug line-clamp-2">
              <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" class="hover:text-blue-700 transition-colors">
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
<section class="section-py bg-slate-50 border-b border-slate-200">
  <div class="container-custom">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
      <div>
        <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Agenda Kegiatan</span>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-slate-900 mt-1">Jadwal & Agenda Sekolah</h2>
        <p class="text-xs sm:text-sm text-slate-600">Aktivitas resmi dan agenda akademik mendatang</p>
      </div>
      <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hidden md:inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">
        Lihat Kalender Lengkap &rarr;
      </a>
    </div>

    @if($agenda->isEmpty())
    <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-500">
      Belum ada agenda terdekat.
    </div>
    @else
    <div class="flex sm:grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
      @foreach($agenda as $item)
      <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-xl border border-slate-200 p-5 shadow-xs hover-card flex flex-col justify-between h-full">
        <div>
          <div class="flex items-start space-x-3 mb-3">
            <!-- Date Badge: Clean Navy -->
            <div class="w-13 h-13 p-2 bg-slate-900 text-white rounded-lg flex flex-col items-center justify-center shrink-0">
              <span class="font-bold text-lg leading-none">{{ $item->tgl_mulai ? $item->tgl_mulai->format('d') : '01' }}</span>
              <span class="text-[10px] uppercase font-semibold text-slate-300 mt-0.5">{{ $item->tgl_mulai ? $item->tgl_mulai->format('M') : 'Jan' }}</span>
            </div>
            <div class="flex-1">
              <span class="text-[11px] font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">
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
              <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>{{ $item->jam_mulai ?? '08.00' }} - {{ $item->jam_selesai ?? 'Selesai' }}</span>
            </div>
            <div class="flex items-center">
              <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              </svg>
              <span class="truncate">{{ $item->lokasi ?? 'SMK Negeri 2 Bandung' }}</span>
            </div>
          </div>
        </div>
        <div class="pt-4 mt-3">
          <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}"
            class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold rounded-lg flex items-center justify-center border border-slate-200 transition-colors">
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
<section class="section-py bg-white border-b border-slate-200">
  <div class="container-custom">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
      <div>
        <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Bakat & Kejuaraan</span>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-slate-900 mt-1">Prestasi Membanggakan</h2>
        <p class="text-xs sm:text-sm text-slate-600">Dedikasi siswa berprestasi di tingkat Kota, Provinsi, dan Nasional</p>
      </div>
      <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hidden md:inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">
        Lihat Seluruh Prestasi &rarr;
      </a>
    </div>

    <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
      @foreach($prestasi as $pres)
      <div class="w-[85vw] max-w-[300px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs hover-card flex flex-col justify-between h-full">
        <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
          <img src="{{ $pres->foto }}" alt="{{ $pres->nama_prestasi }}" class="w-full h-full object-cover">
          <span class="absolute top-3 left-3 bg-slate-900/90 text-white font-semibold text-[10px] px-2.5 py-0.5 rounded">
            Tingkat {{ $pres->tingkat ?? 'Nasional' }}
          </span>
          <span class="absolute top-3 right-3 bg-white/90 text-slate-800 font-semibold text-[10px] px-2 py-0.5 rounded border border-slate-200">
            {{ $pres->tahun ?? date('Y') }}
          </span>
        </div>
        <div class="p-4 flex-1 flex flex-col justify-between">
          <div>
            <p class="text-xs font-semibold text-slate-600">{{ $pres->nama_siswa }}</p>
            <h3 class="font-heading font-bold text-sm text-slate-900 mt-1 line-clamp-2 leading-snug">
              {{ $pres->nama_prestasi }}
            </h3>
            <p class="text-xs text-slate-600 mt-1.5 line-clamp-2">
              {{ $pres->deskripsi }}
            </p>
          </div>
          <div class="pt-3 mt-2 border-t border-slate-100">
            <a href="{{ url(app('tenant')->slug . '/prestasi/' . ($pres->slug ?? $pres->id)) }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">
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
     9. CTA SPMB BANNER (Solid Navy Resmi, Tanpa Gradien Ungu)
=========================================== -->
@if($fiturList['spmb'] ?? true)
<section class="section-py bg-blue-900 text-white border-b border-blue-950">
  <div class="container-custom">
    <div class="max-w-3xl mx-auto text-center space-y-4">
      <span class="inline-block px-3 py-1 rounded-md bg-white/10 text-blue-200 font-semibold text-xs uppercase tracking-wider border border-white/20">
        Penerimaan Peserta Didik Baru
      </span>
      <h2 class="font-heading font-bold text-2xl sm:text-4xl text-white leading-tight">
        Bergabunglah Bersama SMK Negeri 2 Bandung Tahun Ajaran 2026/2027
      </h2>
      <p class="text-xs sm:text-base text-blue-100 max-w-xl mx-auto leading-relaxed">
        Raih kompetensi vokasi terbaik dengan pengakuan sertifikasi industri nasional dan internasional. Dapatkan informasi syarat, jalur, dan alur pendaftaran resmi.
      </p>
      <div class="pt-3 flex flex-wrap justify-center gap-3">
        <a href="{{ url(app('tenant')->slug . '/spmb') }}"
          class="px-6 py-3 bg-white text-blue-900 hover:bg-slate-100 font-semibold text-sm rounded-lg shadow-sm transition-colors">
          Informasi & Syarat SPMB
        </a>
        <a href="{{ url(app('tenant')->slug . '/kontak') }}"
          class="px-6 py-3 bg-transparent hover:bg-white/10 border border-white/30 text-white font-semibold text-sm rounded-lg transition-colors">
          Hubungi Panitia SPMB
        </a>
      </div>
    </div>
  </div>
</section>
@endif

<!-- ==========================================
     10. LOKASI & KONTAK KAMPUS
=========================================== -->
@if($fiturList['kontak'] ?? true)
<section class="section-py bg-slate-50 border-t border-slate-200">
  <div class="container-custom">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
      <div class="lg:col-span-5 space-y-4">
        <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Lokasi Kampus</span>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-slate-900">Kunjungi SMK Negeri 2 Bandung</h2>
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
          <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-lg transition-colors">
            Kirim Pesan / Pengaduan &rarr;
          </a>
        </div>
      </div>

      <div class="lg:col-span-7">
        <div class="rounded-xl overflow-hidden shadow-xs border border-slate-200 h-80 sm:h-96 w-full bg-slate-200">
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