@extends('layouts.tenant_admin')

@section('title', 'Fasilitas Sekolah')
@section('header_title', 'Kelola Fasilitas & Sarana Belajar')

@section('content')
<div class="space-y-6" x-data="{ viewMode: 'list' }">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Fasilitas, Bengkel & Lab Sekolah</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Kelola sarana dan prasarana pendukung belajar mengajar dan standar industri.</p>
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

                <a href="{{ route('tenant.admin.fasilitas.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Fasilitas
                </a>
            </div>
        </div>

        <!-- Mode List (Tabel) -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Foto Utama</th>
                        <th class="px-5 py-3.5">Nama Sarana / Fasilitas</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fasilitas as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-3.5">
                            @if($item->foto_utama)
                            <img src="{{ $item->foto_utama }}" alt="{{ $item->nama_fasilitas }}" class="w-14 h-9 rounded-lg object-cover border border-slate-200">
                            @else
                            <div class="w-14 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 font-bold">NO PIC</div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 max-w-md">
                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $item->nama_fasilitas }}</div>
                            <div class="text-[11px] text-slate-400 font-medium line-clamp-1 mt-0.5">{{ $item->deskripsi }}</div>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($item->is_aktif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.fasilitas.edit', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition shadow-2xs">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.fasilitas.destroy', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs transition shadow-2xs cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-medium">Belum ada fasilitas yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mode Grid (Kartu) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            @if($fasilitas->isEmpty())
                <div class="py-12 text-center text-slate-400 text-xs font-medium">
                    Belum ada fasilitas yang ditambahkan.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($fasilitas as $item)
                        <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden flex flex-col justify-between hover:shadow-xs transition shadow-2xs">
                            <div>
                                <div class="aspect-16/10 bg-slate-100 overflow-hidden relative border-b border-slate-100">
                                    @if($item->foto_utama)
                                        <img src="{{ $item->foto_utama }}" alt="{{ $item->nama_fasilitas }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-slate-400 font-bold">Tanpa Foto</div>
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        @if($item->is_aktif)
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white shadow-xs">Aktif</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-600 text-white shadow-xs">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-5 space-y-2">
                                    <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $item->nama_fasilitas }}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed font-medium">{{ $item->deskripsi ?? 'Sarana pendukung kegiatan belajar di sekolah.' }}</p>
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-2">
                                <a href="{{ route('tenant.admin.fasilitas.edit', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition shadow-2xs">
                                    Edit
                                </a>
                                <form action="{{ route('tenant.admin.fasilitas.destroy', ['tenant' => $tenant->slug, 'fasilitas' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus fasilitas ini?')">
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
            @endif
        </div>
    </div>

</div>
@endsection
