home.blade.php:304: <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
home.blade.php:495: <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Konsentrasi Keahlian</span>
home.blade.php:499: <a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="inline-flex items-center text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800 shrink-0">
home.blade.php:557: <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Publikasi</span>
home.blade.php:560: <a href="{{ url(app('tenant')->slug . '/berita') }}" class="text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800">
home.blade.php:589: <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="hover:text-blue-700 transition-colors">
home.blade.php:598: <a href="{{ url(app('tenant')->slug . '/berita/' . $post->slug) }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800 inline-flex items-center">
home.blade.php:618: <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="text-xs sm:text-sm font-semibold text-blue-700 hover:text-blue-800">
home.blade.php:636: <a href="{{ url(app('tenant')->slug . '/pengumuman/' . $p->slug) }}" class="hover:text-blue-700 transition-colors">
home.blade.php:662: <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Agenda Kegiatan</span>
home.blade.php:666: <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="hidden md:inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">
home.blade.php:735: <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Bakat & Kejuaraan</span>
home.blade.php:739: <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hidden md:inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">
home.blade.php:767: <a href="{{ url(app('tenant')->slug . '/prestasi/' . ($pres->slug ?? $pres->id)) }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">
home.blade.php:783: <section class="section-py bg-blue-900 text-white border-b border-blue-950">
home.blade.php:786: <span class="inline-block px-3 py-1 rounded-md bg-white/10 text-blue-200 font-semibold text-xs uppercase tracking-wider border border-white/20">
home.blade.php:792: <p class="text-xs sm:text-base text-blue-100 max-w-xl mx-auto leading-relaxed">
home.blade.php:819: <span class="text-blue-700 font-semibold text-xs uppercase tracking-wider">Lokasi Kampus</span>
agenda.blade.php:13: <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/30 rounded-full blur-3xl"></div>
agenda.blade.php:14: <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/25 rounded-full blur-3xl"></div>
agenda.blade.php:24: <li class="text-sky-300 font-medium">Kalender & Agenda</li>
agenda.blade.php:46: <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-400/20 text-sky-300 border border-sky-400/30">
agenda.blade.php:54: <h3 class="text-lg font-bold text-white group-hover:text-sky-300 transition-colors font-heading mb-2 line-clamp-1">
agenda.blade.php:60: <div class="flex items-center text-xs font-bold text-sky-400 group-hover:translate-x-1 transition-transform">
agenda.blade.php:164: <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
agenda.blade.php:198: 'bg-blue-600 text-white font-bold shadow-sm': selectedDateStr === (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')),
agenda.blade.php:199: 'bg-sky-100 text-blue-900 font-bold hover:bg-sky-200': hasEventOnDate(day) && selectedDateStr !== (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')),
agenda.blade.php:206: :class="selectedDateStr === (selectedYear + '-' + String(selectedMonth + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')) ? 'bg-white' : 'bg-blue-600'"></span>
agenda.blade.php:216: <span class="text-blue-700 font-medium">Filter Tanggal: <strong x-text="selectedDateStr"></strong></span>
agenda.blade.php:225: <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
agenda.blade.php:242: :class="activeCategory === '{{ $catKey }}' ? 'bg-blue-50 text-blue-700 font-bold border-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
agenda.blade.php:245: <span class="w-2 h-2 rounded-full" :class="activeCategory === '{{ $catKey }}' ? 'bg-blue-600' : 'bg-transparent'"></span>
agenda.blade.php:252: <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-5 border border-slate-800 shadow-sm">
agenda.blade.php:258: class="inline-flex items-center text-xs font-bold text-sky-300 hover:text-white transition">
agenda.blade.php:324: <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold shadow-sm {{ $isUpcoming ? 'bg-blue-600 text-white' : 'bg-slate-800/90 text-slate-200' }}">
agenda.blade.php:341: <span class="inline-flex items-center text-xs font-semibold {{ $isUpcoming ? 'text-blue-600' : 'text-slate-500' }}">
agenda.blade.php:346: <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
agenda.blade.php:352: <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading mb-2 leading-snug">
agenda.blade.php:378: class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
agenda.blade.php:387: class="inline-flex items-center px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
agenda.blade.php:410: class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition">
agenda_detail.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
agenda_detail.blade.php:17: <li class="text-sky-300 font-medium truncate max-w-xs md:max-w-md">{{ $agenda->judul }}</li>
agenda_detail.blade.php:26: <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $isUpcoming ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-slate-700 text-slate-300' }}">
agenda_detail.blade.php:63: <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0 border border-blue-100">
agenda_detail.blade.php:76: <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-100">
agenda_detail.blade.php:88: <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center shrink-0 border border-rose-100">
agenda_detail.blade.php:98: <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
agenda_detail.blade.php:123: <a href="{{ $agenda->link_pendaftaran }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
agenda_detail.blade.php:132: <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
agenda_detail.blade.php:144: <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
agenda_detail.blade.php:150: <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex flex-col items-center justify-center shrink-0 text-center font-heading">
agenda_detail.blade.php:155: <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2">
agenda_detail.blade.php:172: <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-6 border border-slate-800 shadow-sm">
agenda_detail.blade.php:177: <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-sky-400 hover:text-white transition">
berita.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
berita.blade.php:15: <li class="text-sky-300 font-medium">Berita & Informasi</li>
berita.blade.php:36: class="px-3.5 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ !request('kategori') ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
berita.blade.php:41: class="px-3.5 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ request('kategori') === $kat->slug ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
berita.blade.php:71: <a href="{{ url(app('tenant')->slug . '/berita') }}" class="text-xs text-blue-600 hover:underline">Reset Filter</a>
berita.blade.php:86: <span class="absolute top-3 left-3 bg-blue-900/85 backdrop-blur-xs text-white text-[11px] font-semibold px-2.5 py-1 rounded-full">
berita.blade.php:105: <h2 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2 font-heading">
berita.blade.php:118: class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
berita.blade.php:132: <a href="{{ url(app('tenant')->slug . '/berita') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
berita_detail.blade.php:12: <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
berita_detail.blade.php:14: <li><a href="{{ url(app('tenant')->slug . '/berita') }}" class="hover:text-blue-600 transition">Berita</a></li>
berita_detail.blade.php:17: <li><a href="{{ url(app('tenant')->slug . '/berita?kategori=' . $post->kategori->slug) }}" class="hover:text-blue-600 transition">{{ $post->kategori->nama_kategori }}</a></li>
berita_detail.blade.php:36: <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
berita_detail.blade.php:58: <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
berita_detail.blade.php:83: <p class="text-base md:text-lg font-medium text-slate-700 leading-relaxed border-l-4 border-blue-600 pl-4 py-1 bg-blue-50/50 rounded-r-lg mb-6">
berita_detail.blade.php:97: class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
berita_detail.blade.php:111: <a href="{{ url(app('tenant')->slug . '/berita') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
berita_detail.blade.php:123: <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
berita_detail.blade.php:137: <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2 leading-snug">
berita_detail.blade.php:151: <div class="bg-blue-900 text-white rounded-2xl p-6 shadow-sm">
berita_detail.blade.php:153: <p class="text-xs text-blue-200 mb-4">Pantau jadwal ujian, workshop, dan agenda sekolah lainnya di kalender resmi.</p>
berita_detail.blade.php:154: <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-amber-300 hover:text-amber-200">
ekstrakurikuler.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
ekstrakurikuler.blade.php:15: <li class="text-sky-300 font-medium">Ekstrakurikuler</li>
ekstrakurikuler.blade.php:47: <h2 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
ekstrakurikuler.blade.php:66: class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
ekstrakurikuler_detail.blade.php:12: <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
ekstrakurikuler_detail.blade.php:14: <li><a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="hover:text-blue-600 transition">Ekstrakurikuler</a></li>
ekstrakurikuler_detail.blade.php:31: <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
ekstrakurikuler_detail.blade.php:82: <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
ekstrakurikuler_detail.blade.php:105: <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition truncate">
ekstrakurikuler_detail.blade.php:116: <div class="bg-blue-900 text-white rounded-2xl p-6 shadow-sm">
ekstrakurikuler_detail.blade.php:118: <p class="text-xs text-blue-200 leading-relaxed mb-4">Pendaftaran anggota baru dibuka pada masa Masa Pengenalan Lingkungan Sekolah (MPLS) atau langsung menghubungi pengurus OSIS / MPK.</p>
ekstrakurikuler_detail.blade.php:119: <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-amber-300 hover:text-amber-200">
fasilitas.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
fasilitas.blade.php:15: <li class="text-sky-300 font-medium">Sarana & Prasarana</li>
fasilitas.blade.php:34: <span class="text-2xl font-extrabold text-blue-900 font-heading block">41</span>
fasilitas.blade.php:38: <span class="text-2xl font-extrabold text-blue-900 font-heading block">7+</span>
fasilitas.blade.php:42: <span class="text-2xl font-extrabold text-blue-900 font-heading block">1</span>
fasilitas.blade.php:46: <span class="text-2xl font-extrabold text-blue-900 font-heading block">100%</span>
fasilitas.blade.php:73: <h2 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
galeri.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
galeri.blade.php:15: <li class="text-sky-300 font-medium">Galeri Sekolah</li>
galeri.blade.php:50: <button @click="mediaFilter = 'all'" :class="mediaFilter === 'all' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
galeri.blade.php:53: <button @click="mediaFilter = 'foto'" :class="mediaFilter === 'foto' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
galeri.blade.php:56: <button @click="mediaFilter = 'video'" :class="mediaFilter === 'video' ? 'bg-white text-blue-700 shadow-xs' : 'hover:text-slate-900'" class="px-4 py-2 rounded-xl transition">
galeri.blade.php:64: :class="activeAlbum === 'all' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
galeri.blade.php:70: :class="activeAlbum === '{{ $alb->id }}' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
galeri.blade.php:101: <svg class="w-10 h-10 text-rose-500 mb-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
galeri.blade.php:106: <span class="w-12 h-12 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
galeri.blade.php:125: <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded {{ $isVideo ? 'bg-rose-50 text-rose-700' : 'bg-blue-50 text-blue-700' }}">
guru.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
guru.blade.php:15: <li class="text-sky-300 font-medium">Guru & Tenaga Kependidikan</li>
guru.blade.php:64: <p class="text-xs font-semibold text-blue-600 mb-2">
guru.blade.php:84: <a href="{{ url(app('tenant')->slug . '/guru-staf') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
jurusan.blade.php:8: <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white py-14 border-b border-slate-800">
jurusan.blade.php:10: <nav class="flex items-center space-x-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
jurusan.blade.php:52: class="w-full py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs btn-radius flex items-center justify-center transition shadow-sm">
jurusan_detail.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
jurusan_detail.blade.php:18: <li class="text-sky-300 font-medium truncate max-w-xs md:max-w-md">{{ $jurusan->nama_jurusan }}</li>
jurusan_detail.blade.php:50: <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold font-heading shrink-0 shadow-inner">
jurusan_detail.blade.php:67: <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white rounded-2xl p-6 md:p-8 shadow-md relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6">
jurusan_detail.blade.php:70: <p class="text-sm text-blue-100">Ketahui persyaratan pendaftaran, daya tampung rombel, dan alur pendaftaran peserta didik baru.</p>
jurusan_detail.blade.php:87: <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
jurusan_detail.blade.php:97: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
jurusan_detail.blade.php:113: <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
jurusan_detail.blade.php:120: <div class="w-10 h-10 rounded-lg bg-slate-100 text-blue-900 flex items-center justify-center font-bold text-xs font-heading mr-3 group-hover:bg-blue-600 group-hover:text-white transition">
jurusan_detail.blade.php:124: <h4 class="text-xs md:text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition truncate">
jurusan_detail.blade.php:135: <div class="bg-blue-50 border border-blue-200/60 rounded-2xl p-6">
jurusan_detail.blade.php:136: <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Butuh Konsultasi Jurusan?</h4>
jurusan_detail.blade.php:137: <p class="text-xs text-blue-800 leading-relaxed mb-4">Tim bimbingan konseling dan humas kami siap menjawab pertanyaan seputar program keahlian.</p>
jurusan_detail.blade.php:138: <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
kalender.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
kalender.blade.php:17: <li class="text-sky-300 font-medium">Kalender Akademik</li>
kalender.blade.php:40: <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
kalender.blade.php:54: <a href="{{ Storage::url($file_ganjil) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
kalender.blade.php:71: <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
kalender.blade.php:85: <a href="{{ Storage::url($file_genap) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
kalender.blade.php:105: <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
kalender.blade.php:118: <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex flex-col items-center justify-center shrink-0 border border-blue-100">
kegiatan.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
kegiatan.blade.php:15: <li class="text-sky-300 font-medium">Aktivitas & Kegiatan</li>
kegiatan.blade.php:51: <h3 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
kegiatan.blade.php:72: <a href="{{ url(app('tenant')->slug . '/galeri') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
kegiatan.blade.php:92: <a href="{{ url(app('tenant')->slug . '/agenda') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
kegiatan.blade.php:100: <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex flex-col items-center justify-center shrink-0 text-center font-heading">
kegiatan.blade.php:105: <h4 class="text-sm font-bold text-slate-900 hover:text-blue-600 transition truncate">
kontak.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
kontak.blade.php:15: <li class="text-sky-300 font-medium">Kontak & Lokasi</li>
kontak.blade.php:35: <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center space-x-4 text-emerald-800">
kontak.blade.php:36: <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
kontak.blade.php:58: <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
kontak.blade.php:69: <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
kontak.blade.php:80: <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
kontak.blade.php:85: <a href="mailto:{{ $sekolah['email'] ?? 'humas@smkn2bandung.sch.id' }}" class="text-blue-600 hover:underline">
kontak.blade.php:93: <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
kontak.blade.php:106: <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
kontak.blade.php:126: class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
kontak.blade.php:127: <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
kontak.blade.php:135: class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
kontak.blade.php:136: <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
kontak.blade.php:144: class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
kontak.blade.php:145: <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
kontak.blade.php:153: class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
kontak.blade.php:154: <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
kontak.blade.php:162: class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-50/80 hover:bg-white border border-slate-200/90 hover:border-blue-900/30 text-slate-700 hover:text-blue-900 transition-all shadow-2xs hover:shadow-xs group">
kontak.blade.php:163: <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
kontak.blade.php:176: <a href="https://maps.google.com/?q=SMK+Negeri+2+Bandung" target="_blank" class="text-[11px] text-blue-600 hover:underline">Buka di Google Maps &raquo;</a>
kontak.blade.php:201: Nama Lengkap <span class="text-rose-500">*</span>
kontak.blade.php:207: <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
kontak.blade.php:220: <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
kontak.blade.php:227: Subjek / Kategori Pesan <span class="text-rose-500">*</span>
kontak.blade.php:233: <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
kontak.blade.php:240: Pesan Lengkap <span class="text-rose-500">*</span>
kontak.blade.php:246: <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
kontak.blade.php:253: class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm rounded-xl shadow-md hover:shadow-lg transition">
kurikulum.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
kurikulum.blade.php:17: <li class="text-sky-300 font-medium">Kurikulum</li>
kurikulum.blade.php:46: <a href="{{ url(app('tenant')->slug . '/program-keahlian') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
osis.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
osis.blade.php:17: <li class="text-sky-300 font-medium">OSIS & MPK</li>
osis.blade.php:46: <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
pengumuman.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
pengumuman.blade.php:15: <li class="text-sky-300 font-medium">Pengumuman</li>
pengumuman.blade.php:53: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
pengumuman.blade.php:62: <h2 class="text-lg md:text-xl font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2">
pengumuman.blade.php:75: class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-blue-50 group-hover:bg-blue-600 text-blue-700 group-hover:text-white font-bold text-xs transition">
pengumuman.blade.php:88: <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
pengumuman_detail.blade.php:12: <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
pengumuman_detail.blade.php:14: <li><a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="hover:text-blue-600 transition">Pengumuman</a></li>
pengumuman_detail.blade.php:33: <div class="w-14 h-14 rounded-xl bg-blue-900 text-white flex items-center justify-center font-bold text-xl shrink-0">
pengumuman_detail.blade.php:45: <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-900 font-bold text-xs">
pengumuman_detail.blade.php:65: <div class="bg-amber-50/60 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
pengumuman_detail.blade.php:66: <p class="text-xs md:text-sm font-medium text-amber-900 leading-relaxed">
pengumuman_detail.blade.php:100: <a href="{{ url(app('tenant')->slug . '/pengumuman') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
pengumuman_detail.blade.php:120: <h4 class="text-xs font-bold text-slate-800 hover:text-blue-600 transition line-clamp-2">
pengumuman_detail.blade.php:133: <div class="bg-blue-50 border border-blue-200/70 rounded-2xl p-6">
pengumuman_detail.blade.php:134: <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Pusat Bantuan & Layanan</h4>
pengumuman_detail.blade.php:135: <p class="text-xs text-blue-800 leading-relaxed mb-4">Jika terdapat pertanyaan terkait isi pengumuman atau surat edaran ini, silakan hubungi bagian tata usaha sekolah.</p>
pengumuman_detail.blade.php:136: <a href="{{ url(app('tenant')->slug . '/kontak') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
prestasi.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
prestasi.blade.php:15: <li class="text-sky-300 font-medium">Prestasi Sekolah</li>
prestasi.blade.php:80: <span class="absolute top-3 left-3 bg-amber-500 text-slate-950 font-extrabold text-[11px] px-2.5 py-1 rounded-full shadow-xs">
prestasi.blade.php:92: <span class="inline-block text-xs font-extrabold text-blue-600 uppercase tracking-wider">
prestasi.blade.php:97: <h2 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition font-heading mb-2 line-clamp-2">
prestasi.blade.php:106: <svg class="w-3.5 h-3.5 mr-1.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
prestasi.blade.php:119: class="inline-flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700 transition">
prestasi.blade.php:133: <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition">
prestasi_detail.blade.php:12: <li><a href="{{ url(app('tenant')->slug) }}" class="hover:text-blue-600 transition">Beranda</a></li>
prestasi_detail.blade.php:14: <li><a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="hover:text-blue-600 transition">Prestasi</a></li>
prestasi_detail.blade.php:31: <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
prestasi_detail.blade.php:34: <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
prestasi_detail.blade.php:93: <a href="{{ url(app('tenant')->slug . '/prestasi') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
prestasi_detail.blade.php:110: <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm shrink-0">
prestasi_detail.blade.php:114: <span class="text-[10px] font-bold text-amber-700 uppercase block">
prestasi_detail.blade.php:117: <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition line-clamp-2">
prestasi_detail.blade.php:134: <div class="bg-blue-50 border border-blue-200/70 rounded-2xl p-6">
prestasi_detail.blade.php:135: <h4 class="font-bold text-blue-950 font-heading text-sm mb-2">Pengembangan Minat & Bakat</h4>
prestasi_detail.blade.php:136: <p class="text-xs text-blue-800 leading-relaxed mb-4">SMK Negeri 2 Bandung memfasilitasi pembinaan intensif untuk ajang LKS, olimpiade sains terapan, seni, dan olahraga.</p>
prestasi_detail.blade.php:137: <a href="{{ url(app('tenant')->slug . '/ekstrakurikuler') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900">
profil.blade.php:8: <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white py-14 border-b border-slate-800">
profil.blade.php:10: <nav class="flex items-center space-x-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
profil.blade.php:39: <p><strong class="text-slate-900">Status Akreditasi:</strong> <span class="bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded text-xs">Peringkat A</span></p>
profil.blade.php:86: <p class="text-xs text-blue-700 font-semibold">{{ $st->jabatan }}</p>
profil.blade.php:102: <p class="text-xs text-blue-700 font-semibold">Kepala Sekolah</p>
profil.blade.php:113: <li><a href="#sejarah" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Sejarah Sekolah</a></li>
profil.blade.php:114: <li><a href="#visi-misi" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Visi, Misi & Tujuan</a></li>
profil.blade.php:115: <li><a href="#struktur" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Struktur Organisasi</a></li>
profil.blade.php:116: <li><a href="{{ url(app('tenant')->slug . '/guru-staf') }}" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Direktori Guru & Staf</a></li>
profil.blade.php:117: <li><a href="{{ url(app('tenant')->slug . '/fasilitas') }}" class="block px-3 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium">Fasilitas Sekolah</a></li>
sejarah.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
sejarah.blade.php:17: <li class="text-sky-300 font-medium">Sejarah</li>
sejarah.blade.php:46: <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
spmb.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
spmb.blade.php:15: <li class="text-sky-300 font-medium">SPMB / PPDB</li>
spmb.blade.php:47: <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
spmb.blade.php:53: <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase mb-2">Tahap 1</span>
spmb.blade.php:59: <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase mb-2">Tahap 1</span>
spmb.blade.php:65: <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase mb-2">Tahap 2</span>
spmb.blade.php:71: <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase mb-2">Tahap 2</span>
spmb.blade.php:81: <svg class="w-6 h-6 text-blue-600 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
spmb.blade.php:87: <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">1</div>
spmb.blade.php:95: <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">2</div>
spmb.blade.php:103: <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">3</div>
spmb.blade.php:111: <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">4</div>
spmb.blade.php:124: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Ijazah SMP/MTs/Sederajat atau Surat Keterangan Lulus (SKL) asli.</li>
spmb.blade.php:125: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Akta Kelahiran asli dan fotokopi legalisir.</li>
spmb.blade.php:126: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Kartu Keluarga (KK) yang diterbitkan minimal 1 tahun sebelum tanggal pendaftaran.</li>
spmb.blade.php:127: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Buku Rapor SMP/MTs semester 1 sampai semester 5.</li>
spmb.blade.php:128: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Surat Keterangan Sehat dan Tidak Buta Warna dari dokter pemerintah/Puskesmas.</li>
spmb.blade.php:129: <li class="flex items-start"><span class="text-blue-600 mr-2 font-bold">✓</span> Surat Tanggung Jawab Mutlak (SPTJM) bermaterai dari orang tua/wali.</li>
struktur.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
struktur.blade.php:17: <li class="text-sky-300 font-medium">Struktur Organisasi</li>
struktur.blade.php:49: :class="activeTab === 'pejabat' ? 'bg-white text-blue-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
struktur.blade.php:56: :class="activeTab === 'diagram' ? 'bg-white text-blue-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
struktur.blade.php:77: <p class="text-xs font-semibold text-blue-600 mb-2">
struktur.blade.php:108: class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs rounded-xl transition gap-1.5">
struktur.blade.php:144: :class="activeDiagram === idx ? 'ring-2 ring-blue-600 bg-blue-50/50' : 'bg-white hover:bg-slate-50'"
struktur.blade.php:168: <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
visi-misi.blade.php:8: <section class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white py-12 lg:py-16 relative overflow-hidden">
visi-misi.blade.php:17: <li class="text-sky-300 font-medium">Visi & Misi</li>
visi-misi.blade.php:46: <a href="{{ url(app('tenant')->slug . '/profil') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
