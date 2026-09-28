@extends('layouts.tenant_admin')

@section('title', 'Manajemen Media & Berkas')
@section('header_title', 'Pengelola Media & Berkas')

@section('content')
<div class="space-y-6" x-data="mediaManager()">

    <!-- Stat Cards Overview -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="text-[11px] font-semibold text-slate-500">Total Berkas</div>
                <div class="text-base font-bold text-slate-900">{{ $stats['total_files'] }} <span class="text-xs font-normal text-slate-400">({{ $stats['total_size'] }})</span></div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="text-[11px] font-semibold text-slate-500">Gambar</div>
                <div class="text-base font-bold text-slate-900">{{ $stats['images'] }} Berkas</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="text-[11px] font-semibold text-slate-500">Video</div>
                <div class="text-base font-bold text-slate-900">{{ $stats['videos'] }} Berkas</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="text-[11px] font-semibold text-slate-500">Dokumen</div>
                <div class="text-base font-bold text-slate-900">{{ $stats['documents'] }} Berkas</div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        
        <!-- Action Toolbar -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Filter Pills & Search -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug]) }}" 
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $filterType === 'all' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Semua ({{ $stats['total_files'] }})
                </a>
                <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'type' => 'image']) }}" 
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $filterType === 'image' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Gambar ({{ $stats['images'] }})
                </a>
                <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'type' => 'video']) }}" 
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $filterType === 'video' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Video ({{ $stats['videos'] }})
                </a>
                <a href="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug, 'type' => 'document']) }}" 
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $filterType === 'document' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Dokumen ({{ $stats['documents'] }})
                </a>

                <!-- Search Input Form -->
                <form action="{{ route('tenant.admin.media.index', ['tenant' => $tenant->slug]) }}" method="GET" class="relative inline-flex items-center">
                    @if($filterType !== 'all')
                    <input type="hidden" name="type" value="{{ $filterType }}">
                    @endif
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari nama berkas..." 
                           class="w-48 sm:w-56 pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-slate-900">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
            </div>

            <!-- Right Controls: View Switcher (Grid/List) & Upload Button -->
            <div class="flex items-center gap-3">
                <!-- Segmented Control List/Grid View -->
                <div class="inline-flex rounded-lg bg-slate-200/80 p-0.5 text-xs">
                    <button type="button" @click="viewMode = 'grid'" 
                            :class="viewMode === 'grid' ? 'bg-white text-blue-700 font-bold shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-2.5 py-1 rounded-md transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Grid</span>
                    </button>
                    <button type="button" @click="viewMode = 'list'" 
                            :class="viewMode === 'list' ? 'bg-white text-blue-700 font-bold shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                            class="px-2.5 py-1 rounded-md transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span>List</span>
                    </button>
                </div>

                <!-- Upload Modal Trigger Button -->
                <button type="button" @click="uploadModalOpen = true" 
                        class="px-3.5 py-1.5 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Unggah Berkas</span>
                </button>
            </div>

        </div>

        <!-- Notification Toast -->
        <div x-show="toastMsg" x-cloak 
             x-transition 
             class="fixed bottom-6 right-6 z-50 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-semibold shadow-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span x-text="toastMsg"></span>
        </div>

        <!-- CONTENT: GRID VIEW -->
        <div x-show="viewMode === 'grid'" class="p-6">
            @if(count($filesData) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($filesData as $file)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden group hover:border-blue-400 hover:shadow-sm transition flex flex-col justify-between">
                    <!-- Media Preview Area -->
                    <div class="aspect-square bg-slate-100 relative overflow-hidden flex items-center justify-center border-b border-slate-100">
                        @if($file['type'] === 'image')
                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @elseif($file['type'] === 'video')
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-300">
                                <svg class="w-10 h-10 text-indigo-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-[10px] font-bold uppercase text-slate-400">{{ $file['extension'] }}</span>
                            </div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 text-slate-400">
                                <svg class="w-10 h-10 text-amber-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-[10px] font-bold uppercase">{{ $file['extension'] }}</span>
                            </div>
                        @endif

                        <!-- Hover Overlay Quick Buttons -->
                        <div class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 p-2 backdrop-blur-2xs">
                            <button type="button" @click="copyUrl('{{ $file['url'] }}')" title="Salin Tautan" class="p-1.5 rounded-lg bg-white/90 hover:bg-white text-slate-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            </button>
                            <a href="{{ $file['url'] }}" target="_blank" title="Lihat Penuh" class="p-1.5 rounded-lg bg-white/90 hover:bg-white text-slate-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @if($file['type'] === 'image')
                            <button type="button" @click="openCropModal('{{ $file['path'] }}', '{{ $file['url'] }}')" title="Crop / Potong Gambar" class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Details -->
                    <div class="p-2.5 space-y-1">
                        <div class="text-[11px] font-bold text-slate-800 truncate" title="{{ $file['name'] }}">
                            {{ $file['name'] }}
                        </div>
                        <div class="flex items-center justify-between text-[10px] text-slate-400">
                            <span>{{ $file['size'] }}</span>
                            <span class="uppercase font-semibold">{{ $file['extension'] }}</span>
                        </div>
                    </div>

                    <!-- Action Bar Bottom -->
                    <div class="px-2.5 py-1.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px]">
                        <button type="button" @click="openRenameModal('{{ $file['path'] }}', '{{ $file['name'] }}')" class="text-blue-600 hover:text-blue-800 font-semibold cursor-pointer">
                            Ganti Nama
                        </button>
                        <form action="{{ route('tenant.admin.media.destroy', ['tenant' => $tenant->slug]) }}" method="POST" onsubmit="return confirm('Hapus berkas ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="path" value="{{ $file['path'] }}">
                            <button type="submit" class="text-rose-500 hover:text-rose-700 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500">Tidak ada berkas yang sesuai dengan kriteria filter.</p>
            </div>
            @endif
        </div>

        <!-- CONTENT: LIST VIEW (TABLE) -->
        <div x-show="viewMode === 'list'" class="p-6">
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Pratinjau</th>
                            <th class="px-4 py-3">Nama Berkas</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Ukuran</th>
                            <th class="px-4 py-3">Terakhir Diubah</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($filesData as $file)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-2.5">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    @if($file['type'] === 'image')
                                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                                    @elseif($file['type'] === 'video')
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2.5 font-bold text-slate-800">
                                <a href="{{ $file['url'] }}" target="_blank" class="hover:text-blue-700 transition">
                                    {{ $file['name'] }}
                                </a>
                            </td>
                            <td class="px-4 py-2.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase 
                                      {{ $file['type'] === 'image' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($file['type'] === 'video' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                    {{ $file['extension'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 text-slate-500">{{ $file['size'] }}</td>
                            <td class="px-4 py-2.5 text-slate-500">{{ $file['last_modified'] }}</td>
                            <td class="px-4 py-2.5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button" @click="copyUrl('{{ $file['url'] }}')" class="p-1 rounded text-slate-500 hover:text-slate-800 cursor-pointer" title="Salin URL">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    </button>
                                    @if($file['type'] === 'image')
                                    <button type="button" @click="openCropModal('{{ $file['path'] }}', '{{ $file['url'] }}')" class="text-blue-600 hover:text-blue-800 font-semibold cursor-pointer text-xs">
                                        Crop
                                    </button>
                                    @endif
                                    <button type="button" @click="openRenameModal('{{ $file['path'] }}', '{{ $file['name'] }}')" class="text-slate-600 hover:text-slate-900 font-semibold cursor-pointer text-xs">
                                        Ganti Nama
                                    </button>
                                    <form action="{{ route('tenant.admin.media.destroy', ['tenant' => $tenant->slug]) }}" method="POST" onsubmit="return confirm('Hapus berkas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="path" value="{{ $file['path'] }}">
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada berkas dalam media manager.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL 1: UNGGAH BERKAS BARU -->
    <div x-show="uploadModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl border border-slate-200" @click.away="uploadModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h4 class="text-sm font-bold text-slate-900">Unggah Berkas Baru</h4>
                <button type="button" @click="uploadModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('tenant.admin.media.upload', ['tenant' => $tenant->slug]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Berkas (Gambar, Video, atau Dokumen)</label>
                    <input type="file" name="file" required class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[11px] text-slate-400 mt-1">Mendukung format JPG, PNG, WebP, MP4, WebM, PDF. Maksimal 25MB.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori / Folder Penyimpanan</label>
                    <select name="folder" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800">
                        <option value="media">Media Umum</option>
                        <option value="berita">Berita & Artikel</option>
                        <option value="galeri">Galeri Foto & Video</option>
                        <option value="jurusan">Jurusan & Vokasi</option>
                        <option value="prestasi">Prestasi Siswa</option>
                        <option value="guru">Guru & Staf</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="uploadModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs cursor-pointer">Unggah Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: GANTI NAMA BERKAS -->
    <div x-show="renameModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl border border-slate-200" @click.away="renameModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h4 class="text-sm font-bold text-slate-900">Ganti Nama Berkas</h4>
                <button type="button" @click="renameModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('tenant.admin.media.rename', ['tenant' => $tenant->slug]) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="path" x-model="renameItem.path">
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Baru Berkas (Tanpa Ekstensi)</label>
                    <input type="text" name="new_name" x-model="renameItem.newName" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="renameModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs cursor-pointer">Simpan Nama Baru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: CROP & EDIT GAMBAR DENGAN CANVAS INTERAKTIF -->
    <div x-show="cropModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-3 sm:p-5">
        <div class="bg-white rounded-2xl max-w-3xl w-full p-6 space-y-5 shadow-2xl border border-slate-200" @click.away="cropModalOpen = false">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h4 class="text-sm font-bold text-slate-900">Crop & Potong Gambar Interaktif</h4>
                    <p class="text-[11px] text-slate-500">Sesuaikan rasio aspek dan area potong gambar dengan mudah.</p>
                </div>
                <button type="button" @click="cropModalOpen = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Aspect Ratio Selector Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-semibold text-slate-600 mr-1">Rasio Aspek:</span>
                <button type="button" @click="setAspectRatio('free')" :class="aspectRatio === 'free' ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer">Bebas</button>
                <button type="button" @click="setAspectRatio('1:1')" :class="aspectRatio === '1:1' ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer">1:1 (Persegi)</button>
                <button type="button" @click="setAspectRatio('16:9')" :class="aspectRatio === '16:9' ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer">16:9 (Banner)</button>
                <button type="button" @click="setAspectRatio('4:3')" :class="aspectRatio === '4:3' ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer">4:3 (Standar)</button>
                <button type="button" @click="setAspectRatio('3:4')" :class="aspectRatio === '3:4' ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer">3:4 (Pas Foto)</button>
            </div>

            <!-- Canvas Work Area -->
            <div class="relative bg-slate-900 rounded-xl overflow-hidden flex items-center justify-center min-h-[300px] max-h-[460px] p-2 border border-slate-800">
                <canvas id="cropCanvas" class="max-w-full max-h-[440px] cursor-crosshair shadow-md"></canvas>
            </div>

            <!-- Controls & Mode Simpan -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <label class="text-xs font-semibold text-slate-700">Simpan Sebagai:</label>
                    <label class="inline-flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="crop_save_mode" value="new" x-model="cropSaveMode" class="text-blue-600 focus:ring-blue-500">
                        <span>Berkas Baru (Rekomendasi)</span>
                    </label>
                    <label class="inline-flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="crop_save_mode" value="replace" x-model="cropSaveMode" class="text-blue-600 focus:ring-blue-500">
                        <span>Timpa Berkas Asli</span>
                    </label>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-auto">
                    <button type="button" @click="cropModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="button" @click="executeCrop()" :disabled="isCropping" class="px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-xs cursor-pointer inline-flex items-center gap-1.5 disabled:opacity-50">
                        <span x-show="!isCropping">Simpan Hasil Crop</span>
                        <span x-show="isCropping">Memproses...</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
function mediaManager() {
    return {
        viewMode: 'grid',
        toastMsg: '',
        uploadModalOpen: false,
        renameModalOpen: false,
        cropModalOpen: false,
        renameItem: { path: '', newName: '' },
        cropItem: { path: '', url: '' },
        aspectRatio: 'free',
        cropSaveMode: 'new',
        isCropping: false,
        canvas: null,
        ctx: null,
        img: null,
        cropRect: { x: 50, y: 50, w: 200, h: 200 },
        isDragging: false,
        dragHandle: null,

        copyUrl(url) {
            const absoluteUrl = window.location.origin + url;
            navigator.clipboard.writeText(absoluteUrl).then(() => {
                this.showToast('Tautan berkas berhasil disalin!');
            });
        },

        showToast(msg) {
            this.toastMsg = msg;
            setTimeout(() => { this.toastMsg = ''; }, 3000);
        },

        openRenameModal(path, filename) {
            this.renameItem.path = path;
            this.renameItem.newName = filename.substring(0, filename.lastIndexOf('.')) || filename;
            this.renameModalOpen = true;
        },

        openCropModal(path, url) {
            this.cropItem.path = path;
            this.cropItem.url = url;
            this.cropModalOpen = true;
            this.$nextTick(() => {
                this.initCropCanvas(url);
            });
        },

        setAspectRatio(ratio) {
            this.aspectRatio = ratio;
            this.adjustCropBox();
            this.drawCropCanvas();
        },

        adjustCropBox() {
            if (!this.img) return;
            const w = this.cropRect.w;
            if (this.aspectRatio === '1:1') this.cropRect.h = w;
            else if (this.aspectRatio === '16:9') this.cropRect.h = Math.round(w * 9 / 16);
            else if (this.aspectRatio === '4:3') this.cropRect.h = Math.round(w * 3 / 4);
            else if (this.aspectRatio === '3:4') this.cropRect.h = Math.round(w * 4 / 3);
        },

        initCropCanvas(url) {
            this.canvas = document.getElementById('cropCanvas');
            if (!this.canvas) return;
            this.ctx = this.canvas.getContext('2d');
            this.img = new Image();
            this.img.crossOrigin = 'anonymous';
            this.img.onload = () => {
                const maxW = 700;
                const maxH = 420;
                let scale = Math.min(maxW / this.img.width, maxH / this.img.height, 1);
                this.canvas.width = this.img.width * scale;
                this.canvas.height = this.img.height * scale;
                
                const boxSize = Math.min(this.canvas.width, this.canvas.height) * 0.6;
                this.cropRect = {
                    x: (this.canvas.width - boxSize) / 2,
                    y: (this.canvas.height - boxSize) / 2,
                    w: boxSize,
                    h: boxSize
                };
                this.adjustCropBox();
                this.drawCropCanvas();
                this.setupCanvasEvents();
            };
            this.img.src = url;
        },

        drawCropCanvas() {
            if (!this.ctx || !this.img) return;
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            this.ctx.drawImage(this.img, 0, 0, this.canvas.width, this.canvas.height);

            // Shading background
            this.ctx.fillStyle = 'rgba(0, 0, 0, 0.55)';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

            // Clear crop area
            this.ctx.clearRect(this.cropRect.x, this.cropRect.y, this.cropRect.w, this.cropRect.h);
            this.ctx.drawImage(this.img, 
                this.cropRect.x * (this.img.width / this.canvas.width),
                this.cropRect.y * (this.img.height / this.canvas.height),
                this.cropRect.w * (this.img.width / this.canvas.width),
                this.cropRect.h * (this.img.height / this.canvas.height),
                this.cropRect.x, this.cropRect.y, this.cropRect.w, this.cropRect.h
            );

            // Draw border & gridlines
            this.ctx.strokeStyle = '#38bdf8';
            this.ctx.lineWidth = 2;
            this.ctx.strokeRect(this.cropRect.x, this.cropRect.y, this.cropRect.w, this.cropRect.h);

            // Rule of thirds
            this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
            this.ctx.lineWidth = 1;
            const thirdW = this.cropRect.w / 3;
            const thirdH = this.cropRect.h / 3;
            this.ctx.beginPath();
            this.ctx.moveTo(this.cropRect.x + thirdW, this.cropRect.y);
            this.ctx.lineTo(this.cropRect.x + thirdW, this.cropRect.y + this.cropRect.h);
            this.ctx.moveTo(this.cropRect.x + thirdW * 2, this.cropRect.y);
            this.ctx.lineTo(this.cropRect.x + thirdW * 2, this.cropRect.y + this.cropRect.h);
            this.ctx.moveTo(this.cropRect.x, this.cropRect.y + thirdH);
            this.ctx.lineTo(this.cropRect.x + this.cropRect.w, this.cropRect.y + thirdH);
            this.ctx.moveTo(this.cropRect.x, this.cropRect.y + thirdH * 2);
            this.ctx.lineTo(this.cropRect.x + this.cropRect.w, this.cropRect.y + thirdH * 2);
            this.ctx.stroke();
        },

        setupCanvasEvents() {
            let startX, startY;
            this.canvas.onmousedown = (e) => {
                const rect = this.canvas.getBoundingClientRect();
                startX = e.clientX - rect.left;
                startY = e.clientY - rect.top;
                if (startX >= this.cropRect.x && startX <= this.cropRect.x + this.cropRect.w &&
                    startY >= this.cropRect.y && startY <= this.cropRect.y + this.cropRect.h) {
                    this.isDragging = true;
                }
            };

            window.onmousemove = (e) => {
                if (!this.isDragging || !this.cropModalOpen) return;
                const rect = this.canvas.getBoundingClientRect();
                const curX = e.clientX - rect.left;
                const curY = e.clientY - rect.top;
                const dx = curX - startX;
                const dy = curY - startY;
                startX = curX;
                startY = curY;

                this.cropRect.x = Math.max(0, Math.min(this.canvas.width - this.cropRect.w, this.cropRect.x + dx));
                this.cropRect.y = Math.max(0, Math.min(this.canvas.height - this.cropRect.h, this.cropRect.y + dy));
                this.drawCropCanvas();
            };

            window.onmouseup = () => {
                this.isDragging = false;
            };
        },

        executeCrop() {
            if (!this.img || this.isCropping) return;
            this.isCropping = true;

            const scaleX = this.img.width / this.canvas.width;
            const scaleY = this.img.height / this.canvas.height;
            const sx = this.cropRect.x * scaleX;
            const sy = this.cropRect.y * scaleY;
            const sw = this.cropRect.w * scaleX;
            const sh = this.cropRect.h * scaleY;

            const outCanvas = document.createElement('canvas');
            outCanvas.width = sw;
            outCanvas.height = sh;
            const outCtx = outCanvas.getContext('2d');
            outCtx.drawImage(this.img, sx, sy, sw, sh, 0, 0, sw, sh);

            const base64Data = outCanvas.toDataURL('image/webp', 0.9);

            fetch('{{ route("tenant.admin.media.crop", ["tenant" => $tenant->slug]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    path: this.cropItem.path,
                    cropped_image: base64Data,
                    save_mode: this.cropSaveMode
                })
            })
            .then(res => res.json())
            .then(data => {
                this.isCropping = false;
                if (data.success) {
                    this.cropModalOpen = false;
                    this.showToast(data.message);
                    setTimeout(() => { window.location.reload(); }, 900);
                } else {
                    alert(data.message || 'Gagal memproses crop gambar.');
                }
            })
            .catch(err => {
                this.isCropping = false;
                alert('Terjadi kesalahan saat memproses crop gambar.');
            });
        }
    };
}
</script>
@endpush
@endsection
