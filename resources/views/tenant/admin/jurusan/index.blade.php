@extends('layouts.tenant_admin')

@section('title', 'Program Keahlian / Jurusan')
@section('header_title', 'Kelola Program Keahlian (Jurusan)')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden" x-data="{ viewMode: 'list' }">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Konsentrasi Keahlian Vokasi</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Kelola informasi program keahlian, deskripsi kompetensi, foto bengkel/lab, dan status publikasi.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- List vs Grid Toggle -->
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200/80">
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                        class="p-2 rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer" 
                        title="Tampilan Tabel"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800'" 
                        class="p-2 rounded-lg transition text-xs flex items-center gap-1.5 cursor-pointer" 
                        title="Tampilan Grid Kartu"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                </div>

                <a href="{{ route('tenant.admin.jurusan.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Program
                </a>
            </div>
        </div>

        <!-- 1. Tampilan List (Tabel) -->
        <div x-show="viewMode === 'list'" class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Urutan</th>
                        <th class="px-5 py-3.5">Foto / Ikon</th>
                        <th class="px-5 py-3.5">Nama Jurusan</th>
                        <th class="px-5 py-3.5">Singkatan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jurusan as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-6 py-3.5 font-mono text-slate-500 font-bold text-xs">{{ $item->urutan }}</td>
                        <td class="px-5 py-3.5">
                            @if($item->ikon_atau_foto)
                            <img src="{{ $item->ikon_atau_foto }}" alt="{{ $item->nama_jurusan }}" class="w-14 h-9 rounded-lg object-cover border border-slate-200">
                            @else
                            <div class="w-14 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] text-slate-400 font-bold">NA</div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $item->nama_jurusan }}</div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $item->slug }}</div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-bold text-[11px] border border-slate-200/80">{{ $item->singkatan }}</span>
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
                            <a href="{{ route('tenant.admin.jurusan.edit', ['tenant' => $tenant->slug, 'jurusan' => $item->id]) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition shadow-2xs">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.jurusan.destroy', ['tenant' => $tenant->slug, 'jurusan' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus program keahlian ini?')">
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
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 font-medium">Belum ada program keahlian yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 2. Tampilan Grid (Kartu Jurusan) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jurusan as $item)
                <div class="border border-slate-200/90 rounded-2xl overflow-hidden bg-white shadow-2xs hover:shadow-xs transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 bg-slate-100 overflow-hidden">
                            @if($item->ikon_atau_foto)
                            <img src="{{ $item->ikon_atau_foto }}" alt="{{ $item->nama_jurusan }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-xs text-slate-400 font-bold">FOTO JURUSAN</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-900 text-white shadow-xs">
                                    {{ $item->singkatan }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                @if($item->is_aktif)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white shadow-xs">Aktif</span>
                                @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-600 text-white shadow-xs">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <h4 class="font-bold text-slate-900 text-sm leading-snug line-clamp-2">
                                {{ $item->nama_jurusan }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed font-medium">
                                {{ $item->deskripsi_singkat ?? 'Program keahlian unggulan dengan sertifikasi industri dan kurikulum berbasis kompetensi.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <a href="{{ route('tenant.admin.jurusan.edit', ['tenant' => $tenant->slug, 'jurusan' => $item->id]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                            Edit Detail &rarr;
                        </a>
                        <form action="{{ route('tenant.admin.jurusan.destroy', ['tenant' => $tenant->slug, 'jurusan' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus program keahlian ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs font-medium">Belum ada program keahlian yang ditambahkan.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
