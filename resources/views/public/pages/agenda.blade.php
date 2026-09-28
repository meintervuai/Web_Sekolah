@extends('layouts.public')

@section('title', 'Kalender & Agenda Kegiatan - ' . $sekolah['nama'])
@section('meta_description', 'Kalender agenda akademik, workshop kejuruan, asesmen, seminar, dan event resmi di ' . $sekolah['nama'])

@section('content')
<!-- ==========================================
     HERO SECTION (Base Tailwind + Events Reference)
=========================================== -->
<section class="relative py-16 md:py-24 bg-slate-900 text-white overflow-hidden">
    <!-- Subtle geometric background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/25 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px] opacity-15"></div>
    </div>

    <div class="container-custom relative z-10">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex items-center space-x-2 text-xs md:text-sm text-slate-300">
                <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-white transition">Beranda</a></li>
                <li><span class="text-slate-500">/</span></li>
                <li class="text-sky-300 font-medium">Kalender & Agenda</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold mb-4 font-heading tracking-tight leading-tight">
                Agenda & <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-300">Kegiatan Sekolah</span>
            </h1>
            <p class="text-slate-300 text-sm sm:text-base md:text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                Jadwal lengkap asesmen akademik, sertifikasi kompetensi industri, pameran inovasi TEFA, dan agenda kesiswaan {{ $sekolah['nama'] }}.
            </p>

            <!-- Featured Highlight Cards (From Events Ref) -->
            @if(isset($featuredAgenda) && $featuredAgenda->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-left max-w-4xl mx-auto">
                    @foreach($featuredAgenda as $feat)
                        @php
                            $tglF = \Carbon\Carbon::parse($feat->tgl_mulai);
                        @endphp
                        <a href="{{ url(app('tenant')->slug . '/agenda/' . $feat->slug) }}" 
                           class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/15 hover:bg-white/15 transition-all group block shadow-lg">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-400/20 text-sky-300 border border-sky-400/30">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    Agenda Unggulan
                                </span>
                                <span class="text-xs text-slate-300 font-medium">
                                    {{ $tglF->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-white group-hover:text-sky-300 transition-colors font-heading mb-2 line-clamp-1">
                                {{ $feat->judul }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 line-clamp-2 leading-relaxed mb-4">
                                {{ $feat->ringkasan ?? $feat->deskripsi }}
                            </p>
                            <div class="flex items-center text-xs font-bold text-sky-400 group-hover:translate-x-1 transition-transform">
                                <span>Lihat Rincian Agenda</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<!-- ==========================================
     MAIN CONTENT (3-COLUMN LAYOUT REFERENCE)
=========================================== -->
<section class="section-py bg-slate-50"
         x-data="{
             selectedMonth: new Date().getMonth(),
             selectedYear: new Date().getFullYear(),
             selectedDateStr: null,
             activeCategory: 'Semua',
             searchQuery: '',
             allEvents: {{ Js::from($allAgenda->map(function($a) {
                 return [
                     'id' => $a->id,
                     'judul' => $a->judul,
                     'slug' => $a->slug,
                     'tgl_mulai' => $a->tgl_mulai ? $a->tgl_mulai->format('Y-m-d') : null,
                     'tgl_selesai' => $a->tgl_selesai ? $a->tgl_selesai->format('Y-m-d') : null,
                     'tgl_label' => $a->tgl_mulai ? $a->tgl_mulai->translatedFormat('d F Y') : '',
                     'jam' => $a->jam_mulai ? substr($a->jam_mulai, 0, 5) . ($a->jam_selesai ? ' - ' . substr($a->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Jadwal Ditentukan',
                     'lokasi' => $a->lokasi ?? 'Kampus SMKN 2 Bandung',
                     'penyelenggara' => $a->penyelenggara ?? 'Sekolah',
                     'deskripsi' => $a->deskripsi ?? $a->ringkasan,
                     'gambar' => $a->gambar_sampul,
                     'link' => url(app('tenant')->slug . '/agenda/' . $a->slug),
                 ];
             })) }},
             daysInMonth() {
                 return new Date(this.selectedYear, this.selectedMonth + 1, 0).getDate();
             },
             firstDayOfMonth() {
                 return new Date(this.selectedYear, this.selectedMonth, 1).getDay();
             },
             monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
             prevMonth() {
                 if (this.selectedMonth === 0) {
                     this.selectedMonth = 11;
                     this.selectedYear--;
                 } else {
                     this.selectedMonth--;
                 }
             },
             nextMonth() {
                 if (this.selectedMonth === 11) {
                     this.selectedMonth = 0;
                     this.selectedYear++;
                 } else {
                     this.selectedMonth++;
                 }
             },
             hasEventOnDate(day) {
                 const dStr = this.selectedYear + '-' + String(this.selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                 return this.allEvents.some(e => e.tgl_mulai === dStr);
             },
             selectDate(day) {
                 const dStr = this.selectedYear + '-' + String(this.selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                 if (this.selectedDateStr === dStr) {
                     this.selectedDateStr = null; // deselect
                 } else {
                     this.selectedDateStr = dStr;
                 }
             },
             isEventVisible(event) {
                 if (this.selectedDateStr && event.tgl_mulai !== this.selectedDateStr) {
                     return false;
                 }
                 if (this.activeCategory !== 'Semua') {
                     const catLower = this.activeCategory.toLowerCase();
                     const titleLower = event.judul.toLowerCase();
                     const descLower = (event.deskripsi || '').toLowerCase();
                     const matchCat = titleLower.includes(catLower) || descLower.includes(catLower) || (event.penyelenggara || '').toLowerCase().includes(catLower);
                     if (!matchCat) return false;
                 }
                 if (this.searchQuery.trim() !== '') {
                     const q = this.searchQuery.toLowerCase();
                     const matchQ = event.judul.toLowerCase().includes(q) || (event.lokasi || '').toLowerCase().includes(q) || (event.deskripsi || '').toLowerCase().includes(q);
                     if (!matchQ) return false;
                 }
                 return true;
             }
         }">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- ==========================================
                 LEFT COLUMN: CALENDAR & CATEGORIES (4 cols)
            =========================================== -->
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- Calendar Card Widget -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 font-heading flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Kalender Agenda
                        </h2>
                        <!-- Month / Year Navigator -->
                        <div class="flex items-center space-x-1">
                            <button @click="prevMonth()" 
                                    class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition"
                                    aria-label="Bulan Sebelumnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <span class="text-xs font-bold text-slate-800 min-w-[100px] text-center" x-text="monthNames[selectedMonth] + ' ' + selectedYear"></span>
                            <button @click="nextMonth()" 
                                    class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition"
                                    aria-label="Bulan Berikutnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="border border-slate-100 rounded-xl p-3 bg-slate-50/50">
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-slate-400 mb-2">
                            <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-xs">
                            <!-- Empty offset days -->
                            <template x-for="blank in firstDayOfMonth()" :key="'b' + blank">
                                <span class="h-8 flex items-center justify-center text-transparent">-</span>
                            </template>
                            <!-- Month Days -->
                            <template x-for="day in daysInMonth()" :key="'d' + day">
                                <button type="button"
                                        @click="selectDate(day)"
                                        :class="{
                                            'bg-blue-600 text-white font-bold shadow-sm': selectedDateStr === (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')),
                                            'bg-sky-100 text-blue-900 font-bold hover:bg-sky-200': hasEventOnDate(day) && selectedDateStr !== (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')),
                                            'text-slate-700 hover:bg-slate-200/70': !hasEventOnDate(day) && selectedDateStr !== (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0'))
                                        }"
                                        class="h-8 w-full rounded-lg flex flex-col items-center justify-center transition text-xs relative">
                                    <span x-text="day"></span>
                                    <template x-if="hasEventOnDate(day)">
                                        <span class="w-1.5 h-1.5 rounded-full mt-0.5"
                                              :class="selectedDateStr === (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')) ? 'bg-white' : 'bg-blue-600'"></span>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Filter Date Reset Notice -->
                    <template x-if="selectedDateStr">
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-blue-700 font-medium">Filter Tanggal: <strong x-text="selectedDateStr"></strong></span>
                            <button @click="selectedDateStr = null" class="text-red-500 hover:underline font-bold text-[11px]">Reset</button>
                        </div>
                    </template>
                </div>

                <!-- Categories & Filter Widget -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 font-heading mb-3 flex items-center">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori Agenda
                    </h3>
                    <div class="space-y-1.5">
                        @php
                            $categories = [
                                'Semua' => 'Semua Agenda',
                                'Asesmen' => 'Ujian & Asesmen',
                                'Workshop' => 'Workshop & Seminar',
                                'Industri' => 'Kemitraan Industri',
                                'Kesiswaan' => 'Kegiatan Kesiswaan',
                                'Akademik' => 'Kalender Akademik',
                            ];
                        @endphp
                        @foreach($categories as $catKey => $catLabel)
                            <button type="button"
                                    @click="activeCategory = '{{ $catKey }}'"
                                    :class="activeCategory === '{{ $catKey }}' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                                    class="w-full text-left px-3.5 py-2 rounded-xl text-xs flex items-center justify-between border transition">
                                <span>{{ $catLabel }}</span>
                                <span class="w-2 h-2 rounded-full" :class="activeCategory === '{{ $catKey }}' ? 'bg-blue-600' : 'bg-transparent'"></span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Academic Calendar Link Card -->
                <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-5 border border-slate-800 shadow-sm">
                    <h3 class="text-sm font-bold text-white font-heading mb-1.5">Kalender Akademik Resmi</h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        Unduh atau tinjau dokumen PDF resmi Kalender Akademik Semester Ganjil & Genap tahun ajaran berjalan.
                    </p>
                    <a href="{{ url(app('tenant')->slug . '/kalender') }}" 
                       class="inline-flex items-center text-xs font-bold text-sky-300 hover:text-white transition">
                        <span>Buka Kalender Akademik</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <!-- ==========================================
                 RIGHT COLUMN: EVENTS LIST (8 cols)
            =========================================== -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Search & Status Bar -->
                <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="relative flex-1">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Cari nama agenda, lokasi, atau kata kunci..." 
                               class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Server Filter Tabs -->
                    <div class="flex items-center space-x-1 text-xs shrink-0">
                        <a href="{{ url(app('tenant')->slug . '/agenda?filter=mendatang') }}" 
                           class="px-3 py-1.5 rounded-lg font-medium transition {{ $filter === 'mendatang' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                            Mendatang
                        </a>
                        <a href="{{ url(app('tenant')->slug . '/agenda?filter=lampau') }}" 
                           class="px-3 py-1.5 rounded-lg font-medium transition {{ $filter === 'lampau' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                            Selesai
                        </a>
                        <a href="{{ url(app('tenant')->slug . '/agenda?filter=semua') }}" 
                           class="px-3 py-1.5 rounded-lg font-medium transition {{ $filter === 'semua' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                            Semua
                        </a>
                    </div>
                </div>

                <!-- Event Cards List (Events Reference Style: Horizontal with Image on Left) -->
                <div class="space-y-5">
                    @forelse($agenda as $item)
                        @php
                            $tglMulai = \Carbon\Carbon::parse($item->tgl_mulai);
                            $isUpcoming = $tglMulai->isFuture() || $tglMulai->isToday();
                            $coverImg = $item->gambar_sampul ?: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800&auto=format&fit=crop';
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden group"
                             x-show="isEventVisible({
                                 id: {{ $item->id }},
                                 judul: '{{ addslashes($item->judul) }}',
                                 tgl_mulai: '{{ $item->tgl_mulai ? $item->tgl_mulai->format('Y-m-d') : '' }}',
                                 lokasi: '{{ addslashes($item->lokasi ?? '') }}',
                                 deskripsi: '{{ addslashes(strip_tags($item->deskripsi ?? '')) }}',
                                 penyelenggara: '{{ addslashes($item->penyelenggara ?? '') }}'
                             })">
                            <div class="flex flex-col md:flex-row">
                                <!-- Image Thumbnail Left -->
                                <div class="md:w-5/12 lg:w-4/12 relative bg-slate-100 overflow-hidden shrink-0">
                                    <img src="{{ $coverImg }}" 
                                         alt="{{ $item->judul }}" 
                                         class="h-48 md:h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <!-- Badge Overlay -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold shadow-sm {{ $isUpcoming ? 'bg-blue-600 text-white' : 'bg-slate-800/90 text-slate-200' }}">
                                            {{ $tglMulai->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    @if($item->penyelenggara)
                                        <div class="absolute bottom-3 left-3 right-3">
                                            <span class="inline-block px-2 py-0.5 bg-black/60 backdrop-blur-xs text-white text-[10px] rounded truncate max-w-full font-medium">
                                                {{ $item->penyelenggara }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Event Details Right -->
                                <div class="p-5 md:p-6 md:w-7/12 lg:w-8/12 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="inline-flex items-center text-xs font-semibold {{ $isUpcoming ? 'text-blue-600' : 'text-slate-500' }}">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                                {{ $isUpcoming ? 'Akan Datang' : 'Telah Terlaksana' }}
                                            </span>
                                            @if($item->link_pendaftaran)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    Registrasi Dibuka
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading mb-2 leading-snug">
                                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}">
                                                {{ $item->judul }}
                                            </a>
                                        </h2>

                                        <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                                            {{ $item->ringkasan ?? $item->deskripsi }}
                                        </p>

                                        <!-- Metadata Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-600 mb-5 pb-4 border-b border-slate-100">
                                            <div class="flex items-center truncate">
                                                <svg class="w-4 h-4 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span class="truncate">{{ $item->jam_mulai ? substr($item->jam_mulai, 0, 5) . ($item->jam_selesai ? ' - ' . substr($item->jam_selesai, 0, 5) . ' WIB' : ' WIB') : 'Jadwal menyesuaikan' }}</span>
                                            </div>
                                            <div class="flex items-center truncate">
                                                <svg class="w-4 h-4 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span class="truncate">{{ $item->lokasi ?? 'Kampus SMKN 2 Bandung' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Action -->
                                    <div class="flex items-center justify-between pt-1">
                                        <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}" 
                                           class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                                            <span>Rincian & Informasi</span>
                                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>

                                        @if($item->link_pendaftaran)
                                            <a href="{{ $item->link_pendaftaran }}" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="inline-flex items-center px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                                Daftar Kegiatan
                                            </a>
                                        @else
                                            <a href="{{ url(app('tenant')->slug . '/agenda/' . $item->slug) }}" 
                                               class="inline-flex items-center px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                                                Detail Acara
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center bg-white rounded-2xl border border-slate-200/80 p-8 shadow-sm">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 font-heading mb-1">Belum Ada Agenda Terdaftar</h3>
                            <p class="text-xs md:text-sm text-slate-500 max-w-sm mx-auto mb-4">
                                Belum ada agenda kegiatan yang cocok dengan kriteria filter saat ini.
                            </p>
                            <a href="{{ url(app('tenant')->slug . '/agenda?filter=semua') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition">
                                Lihat Semua Agenda
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Server Pagination -->
                <div class="mt-8">
                    {{ $agenda->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
