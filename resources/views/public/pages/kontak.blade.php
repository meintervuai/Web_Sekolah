@extends('layouts.public')

@section('title', 'Hubungi Kami & Layanan Informasi - ' . $sekolah['nama'])
@section('meta_description', 'Kontak resmi, lokasi peta Google Maps, jam operasional layanan, dan formulir pesan informasi ' . $sekolah['nama'] . ' Bandung.')

@section('content')
<!-- Header & Breadcrumb -->
<section class="theme-bg-dark text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(var(--theme-accent)_1px,transparent_1px)] [background-size:16px_16px]"></div>
    @if(!empty($gambarBanner ?? $banner ?? null))
        <!-- Right-Side Artistic Banner Image with Gradual Mask/Fade to Left & Theme Dark Overlay -->
        <div class="absolute inset-y-0 right-0 w-full md:w-3/5 lg:w-1/2 pointer-events-none z-0">
            <img src="{{ $gambarBanner ?? $banner }}" alt="Hubungi Kami" 
                 class="w-full h-full object-cover object-center opacity-40 lg:opacity-60 [mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_left,rgba(0,0,0,1)_20%,rgba(0,0,0,0.6)_60%,transparent_100%)]">
            <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-header,#0f172a)] via-transparent to-transparent opacity-80"></div>
        </div>
    @endif
    <div class="container-custom relative z-10">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition drop-shadow-xs">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium drop-shadow-xs">Kontak &amp; Lokasi</li>
            </ol>
        </nav>
        <div class="max-w-4xl lg:max-w-5xl">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-heading mb-3 drop-shadow-sm">
                Hubungi Kami
            </h1>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl drop-shadow-xs">
                Kami siap melayani kebutuhan informasi seputar akademik, kemitraan industri (DUDI), legalisir dokumen, dan pendaftaran peserta didik baru.
            </p>
        </div>
    </div>
</section>

<!-- Main Contact Section -->
<section class="section-py bg-slate-50">
    <div class="container-custom">
        
        <!-- Flash Success Notification -->
        @if(session('sukses'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center space-x-4 text-emerald-800">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Pesan Berhasil Dikirim!</h4>
                <p class="text-xs text-emerald-700">{{ session('sukses') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Contact Details & Map (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-6 pb-3 border-b border-slate-100">
                        Informasi Kantor & Layanan
                    </h2>

                    <ul class="space-y-5 text-xs md:text-sm">
                        <!-- Alamat -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Alamat Sekolah</span>
                                <p class="text-slate-600 leading-relaxed">{{ $sekolah['alamat'] ?? 'Jl. Ciliwung No. 4, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114' }}</p>
                            </div>
                        </li>

                        <!-- Telepon -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Telepon Kantor</span>
                                <p class="text-slate-600">{{ $sekolah['telepon'] ?? '(022) 7234285' }}</p>
                            </div>
                        </li>

                        <!-- Email -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Surat Elektronik (Email)</span>
                                <a href="mailto:{{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}" class="text-blue-600 hover:underline">
                                    {{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}
                                </a>
                            </div>
                        </li>

                        <!-- WhatsApp Hotline -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.968 0-9.013 4.045-9.015 9.017a8.98 8.98 0 0 0 1.374 4.815L3 21l4.303-1.129a9.014 9.014 0 0 0 4.748 1.325h.004c4.968 0 9.013-4.046 9.015-9.017a8.963 8.963 0 0 0-2.667-6.541zm-6.35 13.684h-.003a7.51 7.51 0 0 1-3.832-1.051l-.275-.163-2.85.748.76-2.778-.179-.284a7.485 7.485 0 0 1-1.147-3.978c.002-4.14 3.37-7.508 7.513-7.508a7.472 7.472 0 0 1 5.309 2.199 7.48 7.48 0 0 1 2.196 5.31c-.002 4.14-3.37 7.508-7.512 7.508zm4.12-5.625c-.225-.113-1.334-.658-1.541-.733-.207-.075-.357-.113-.508.113-.15.225-.583.733-.715.884-.131.15-.263.169-.489.056-.225-.113-.951-.35-1.812-1.118-.671-.598-1.124-1.338-1.256-1.564-.132-.226-.014-.348.099-.46.102-.101.226-.263.339-.395.113-.131.15-.225.226-.375.075-.15.038-.282-.019-.395-.056-.113-.508-1.224-.696-1.677-.183-.441-.369-.381-.508-.388l-.433-.008c-.15 0-.395.056-.602.282-.207.226-.79.771-.79 1.88 0 1.109.809 2.179.921 2.33.113.15 1.59 2.428 3.854 3.404.538.233.959.372 1.286.476.541.172 1.034.148 1.423.09.434-.065 1.334-.546 1.522-1.072.188-.527.188-.978.132-1.072-.057-.094-.207-.15-.433-.263z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Hotline Pelayanan Publik (WhatsApp)</span>
                                <a href="https://wa.me/62{{ ltrim($sekolah['whatsapp'] ?? '081222333444', '0') }}" target="_blank" class="text-emerald-700 font-semibold hover:underline">
                                    {{ $sekolah['whatsapp'] ?? '081222333444' }}
                                </a>
                            </div>
                        </li>

                        <!-- Jam Layanan -->
                        <li class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Jam Operasional Layanan</span>
                                <p class="text-slate-600 leading-relaxed text-xs sm:text-sm whitespace-pre-line">{{ $sekolah['jam_layanan'] ?? 'Senin - Jumat: 07.00 - 16.00 WIB (Sabtu, Minggu & Libur Nasional Tutup)' }}</p>
                            </div>
                        </li>
                    </ul>

                    <!-- Media Sosial Resmi Sekolah -->
                    @php
                        $isValidSocial = function(?string $url): bool {
                            if (empty($url)) return false;
                            $trimmed = trim($url);
                            return $trimmed !== '' && $trimmed !== '-' && $trimmed !== '#' && !in_array(strtolower($trimmed), ['null', 'none', '-']);
                        };
                        $formatSocialUrl = function(?string $url, string $prefix): string {
                            $trimmed = trim($url ?? '');
                            if (str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://')) {
                                return $trimmed;
                            }
                            return rtrim($prefix, '/') . '/' . ltrim($trimmed, '@/');
                        };
                        $hasSocial = $isValidSocial($sekolah['instagram'] ?? null) 
                                  || $isValidSocial($sekolah['tiktok'] ?? null) 
                                  || $isValidSocial($sekolah['youtube'] ?? null) 
                                  || $isValidSocial($sekolah['facebook'] ?? null) 
                                  || $isValidSocial($sekolah['twitter'] ?? null);
                    @endphp

                    @if($hasSocial)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-slate-900 uppercase tracking-wider">Media Sosial Resmi</span>
                            <span class="text-[11px] text-slate-500 font-medium">Kanal Publikasi Sekolah</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            <!-- Instagram -->
                            @if($isValidSocial($sekolah['instagram'] ?? null))
                            <a href="{{ $formatSocialUrl($sekolah['instagram'], 'https://instagram.com') }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                <span class="text-xs font-semibold">Instagram</span>
                            </a>
                            @endif

                            <!-- TikTok -->
                            @if($isValidSocial($sekolah['tiktok'] ?? null))
                            <a href="{{ $formatSocialUrl($sekolah['tiktok'], 'https://tiktok.com') }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298 0 .591.045.87.134V9.42a6.35 6.35 0 0 0-.87-.06 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.75a8.28 8.28 0 0 0 4.84 1.55v-3.5a4.85 4.85 0 0 1-1.07-.11z"/></svg>
                                </div>
                                <span class="text-xs font-semibold">TikTok</span>
                            </a>
                            @endif

                            <!-- YouTube -->
                            @if($isValidSocial($sekolah['youtube'] ?? null))
                            <a href="{{ $formatSocialUrl($sekolah['youtube'], 'https://youtube.com') }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </div>
                                <span class="text-xs font-semibold">YouTube</span>
                            </a>
                            @endif

                            <!-- Facebook -->
                            @if($isValidSocial($sekolah['facebook'] ?? null))
                            <a href="{{ $formatSocialUrl($sekolah['facebook'], 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </div>
                                <span class="text-xs font-semibold">Facebook</span>
                            </a>
                            @endif

                            <!-- X / Twitter -->
                            @if($isValidSocial($sekolah['twitter'] ?? null))
                            <a href="{{ $formatSocialUrl($sekolah['twitter'], 'https://x.com') }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </div>
                                <span class="text-xs font-semibold">X (Twitter)</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Google Maps Card -->
                @if(!empty($sekolah['peta_embed']))
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs">
                    <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800">Peta Lokasi Kampus</span>
                        <a href="https://maps.google.com/?q={{ urlencode($sekolah['nama'] . ' ' . $sekolah['alamat']) }}" target="_blank" class="text-[11px] text-blue-600 hover:underline">Buka di Google Maps &raquo;</a>
                    </div>
                    <div class="aspect-4/3 w-full bg-slate-100">
                        @php
                            $mapsSrc = $sekolah['peta_embed'];
                            if (preg_match('/src=["\']([^"\']+)["\']/', $mapsSrc, $matchIframe)) {
                                $mapsSrc = $matchIframe[1];
                            }
                        @endphp
                        <iframe src="{{ $mapsSrc }}" 
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi {{ $sekolah['nama'] }}"></iframe>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Interactive Contact Form (7 cols) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-xs">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-heading mb-2">
                        Kirim Pesan atau Pertanyaan
                    </h2>
                    <p class="text-xs md:text-sm text-slate-500 mb-8">
                        Silakan lengkapi formulir di bawah ini. Tim humas kami akan merespons pesan Anda dalam waktu 1x24 jam kerja.
                    </p>

                    <form method="POST" onsubmit="sendToWhatsApp(event)" class="space-y-5">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama_pengirim" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required
                                   placeholder="Contoh: Budi Santoso"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('nama_pengirim') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('nama_pengirim')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon / WhatsApp -->
                        <div>
                            <label for="no_telepon" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Nomor WhatsApp / HP <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('no_telepon') ? 'border-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('no_telepon')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subjek Pesan -->
                        <div>
                            <label for="subjek" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Subjek / Kategori Pesan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" required
                                   placeholder="Contoh: Informasi Pendaftaran Siswa Baru / Kerja Sama Industri"
                                   class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('subjek') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            @error('subjek')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Isi Pesan -->
                        <div>
                            <label for="pesan" class="block text-xs md:text-sm font-semibold text-slate-800 mb-1.5">
                                Pesan Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="pesan" name="pesan" rows="5" required
                                      placeholder="Tuliskan pertanyaan, masukan, atau permohonan informasi Anda secara rinci di sini..."
                                      class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('pesan') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-200' }} rounded-xl text-xs md:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm rounded-xl shadow-md hover:shadow-lg transition">
                                <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.638A8.955 8.955 0 0 0 12.053 3c-4.968 0-9.013 4.045-9.015 9.017a8.98 8.98 0 0 0 1.374 4.815L3 21l4.303-1.129a9.014 9.014 0 0 0 4.748 1.325h.004c4.968 0 9.013-4.046 9.015-9.017a8.963 8.963 0 0 0-2.667-6.541zm-6.35 13.684h-.003a7.51 7.51 0 0 1-3.832-1.051l-.275-.163-2.85.748.76-2.778-.179-.284a7.485 7.485 0 0 1-1.147-3.978c.002-4.14 3.37-7.508 7.513-7.508a7.472 7.472 0 0 1 5.309 2.199 7.48 7.48 0 0 1 2.196 5.31c-.002 4.14-3.37 7.508-7.512 7.508zm4.12-5.625c-.225-.113-1.334-.658-1.541-.733-.207-.075-.357-.113-.508.113-.15.225-.583.733-.715.884-.131.15-.263.169-.489.056-.225-.113-.951-.35-1.812-1.118-.671-.598-1.124-1.338-1.256-1.564-.132-.226-.014-.348.099-.46.102-.101.226-.263.339-.395.113-.131.15-.225.226-.375.075-.15.038-.282-.019-.395-.056-.113-.508-1.224-.696-1.677-.183-.441-.369-.381-.508-.388l-.433-.008c-.15 0-.395.056-.602.282-.207.226-.79.771-.79 1.88 0 1.109.809 2.179.921 2.33.113.15 1.59 2.428 3.854 3.404.538.233.959.372 1.286.476.541.172 1.034.148 1.423.09.434-.065 1.334-.546 1.522-1.072.188-.527.188-.978.132-1.072-.057-.094-.207-.15-.433-.263z"/></svg>
                                <span>Kirim via WhatsApp</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
function sendToWhatsApp(event) {
    event.preventDefault();
    
    const nama = document.getElementById('nama_pengirim').value;
    const telepon = document.getElementById('no_telepon').value;
    const subjek = document.getElementById('subjek').value;
    const pesan = document.getElementById('pesan').value;
    
    const waNumber = "62{{ ltrim($sekolah['whatsapp'] ?? '081222333444', '0') }}";
    
    const template = `*Halo, saya ingin menghubungi ${ '{{ $sekolah["nama"] ?? "Humas" }}' }*
    
*Nama Lengkap:* ${nama}
*No. WhatsApp / HP:* ${telepon ? telepon : '-'}
*Subjek/Kategori:* ${subjek}

*Pesan:*
${pesan}`;

    const textEncoded = encodeURIComponent(template);
    const waUrl = `https://wa.me/${waNumber}?text=${textEncoded}`;
    
    window.open(waUrl, '_blank');
}
</script>
@endpush
@endsection
