@extends('layouts.tenant_admin')

@section('title', 'Slider Banner Beranda')
@section('header_title', 'Kelola Slider Beranda')

@section('content')
<div class="space-y-6" x-data="{ viewMode: 'list' }">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Banner Hero Beranda</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Banner ini akan tampil secara dinamis dan bergantian di bagian paling atas halaman publik.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- View Mode Toggle -->
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200/80">
                    <button type="button" @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-2 rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer" title="Tampilan Tabel">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <button type="button" @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" class="p-2 rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer" title="Tampilan Grid">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                </div>

                <a href="{{ route('tenant.admin.slider.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Slider
                </a>
            </div>
        </div>

        @if($sliders->isEmpty())
            <div class="p-12 text-center text-slate-400 text-xs font-medium">
                Belum ada slider yang ditambahkan. Silakan klik tombol Tambah Slider di atas.
            </div>
        @else
            <!-- Mode List (Tabel) -->
            <div x-show="viewMode === 'list'" class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-6 w-16 text-center">Urutan</th>
                            <th class="py-3.5 px-5 w-32">Pratinjau</th>
                            <th class="py-3.5 px-5">Judul & Subjudul</th>
                            <th class="py-3.5 px-5">Tautan Tombol</th>
                            <th class="py-3.5 px-5 text-center">Status</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($sliders as $slider)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-6 text-center font-mono text-xs font-bold text-slate-500">{{ $slider->urutan }}</td>
                                <td class="py-3.5 px-5">
                                    <div class="w-24 h-14 rounded-lg bg-slate-900 overflow-hidden border border-slate-200 relative group">
                                        @if($slider->gambar)
                                            <img src="{{ $slider->gambar }}" alt="{{ $slider->judul }}" class="w-full h-full object-cover">
                                        @elseif($slider->video)
                                            <div class="w-full h-full flex items-center justify-center bg-slate-950 text-white">
                                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif

                                        @if($slider->video)
                                            <div class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-blue-600/90 text-white text-[9px] font-bold uppercase tracking-wider flex items-center gap-0.5">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                                Video
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 max-w-xs sm:max-w-md">
                                    <div class="flex items-center gap-2">
                                        <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $slider->judul ?? '(Tanpa Judul)' }}</div>
                                        @if($slider->video)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                                Video
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-slate-500 text-xs font-medium line-clamp-1 mt-0.5">{{ $slider->subjudul ?? '-' }}</p>
                                </td>
                                <td class="py-3.5 px-5">
                                    @if($slider->link_tombol)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg font-mono border border-slate-200/80">
                                            {{ $slider->teks_tombol ?? 'Link' }}: {{ $slider->link_tombol }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $slider->is_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/50' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $slider->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('tenant.admin.slider.edit', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition shadow-2xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('tenant.admin.slider.destroy', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs transition shadow-2xs cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mode Grid (Kartu) -->
            <div x-show="viewMode === 'grid'" x-cloak class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sliders as $slider)
                        <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden flex flex-col justify-between hover:shadow-xs transition shadow-2xs">
                            <div>
                                <div class="aspect-16/9 bg-slate-900 overflow-hidden relative border-b border-slate-100">
                                    @if($slider->gambar)
                                        <img src="{{ $slider->gambar }}" alt="{{ $slider->judul }}" class="w-full h-full object-cover">
                                    @elseif($slider->video)
                                        <div class="w-full h-full flex items-center justify-center bg-slate-950 text-white">
                                            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-3 left-3 px-2.5 py-0.5 rounded-lg text-[10px] font-mono font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                        #{{ $slider->urutan }}
                                    </div>

                                    @if($slider->video)
                                        <div class="absolute bottom-3 left-3 px-2.5 py-1 rounded-lg bg-blue-600 text-white text-[10px] font-bold flex items-center gap-1 shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                            Media Video
                                        </div>
                                    @endif

                                    <div class="absolute top-3 right-3">
                                        @if($slider->is_aktif)
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white shadow-xs">Aktif</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-600 text-white shadow-xs">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $slider->judul ?? '(Tanpa Judul)' }}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed font-medium">{{ $slider->subjudul ?? '-' }}</p>
                                    @if($slider->link_tombol)
                                        <div class="pt-2 text-xs text-slate-600 flex items-center gap-1.5 truncate font-mono">
                                            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            <span class="truncate">{{ $slider->teks_tombol ?? 'Link' }}: {{ $slider->link_tombol }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-2">
                                <a href="{{ route('tenant.admin.slider.edit', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition shadow-2xs">
                                    Edit
                                </a>
                                <form action="{{ route('tenant.admin.slider.destroy', ['tenant' => $tenant->slug, 'slider' => $slider->id]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-white border border-rose-200 text-rose-600 text-xs font-bold hover:bg-rose-50 transition shadow-2xs cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
