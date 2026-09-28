@extends('layouts.tenant_admin')

@section('title', 'Prestasi Siswa')
@section('header_title', 'Kelola Prestasi Siswa')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden" x-data="{ viewMode: 'list' }">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Prestasi & Penghargaan Siswa</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola capaian lomba LKS, kompetisi akademik, olahraga, dan seni.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- List vs Grid Toggle -->
                <div class="flex items-center gap-1 bg-slate-200/80 p-1 rounded-xl">
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" 
                        class="p-1.5 rounded-lg transition" 
                        title="Tampilan Tabel Rinci"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" 
                        class="p-1.5 rounded-lg transition" 
                        title="Tampilan Grid Kartu"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                </div>

                <a href="{{ route('tenant.admin.prestasi.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Prestasi
                </a>
            </div>
        </div>

        <!-- 1. Tampilan List (Tabel) -->
        <div x-show="viewMode === 'list'" class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Foto</th>
                        <th class="px-4 py-3">Nama Kejuaraan / Prestasi</th>
                        <th class="px-4 py-3">Nama Siswa / Tim</th>
                        <th class="px-4 py-3">Tingkat</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($prestasi as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_prestasi }}" class="w-12 h-9 rounded object-cover border border-slate-200">
                            @else
                            <div class="w-12 h-9 rounded bg-slate-200 flex items-center justify-center text-[9px] text-slate-400">NO PIC</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-xs">
                            <div class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->nama_prestasi }}</div>
                            <div class="text-[11px] text-slate-400 line-clamp-1">{{ $item->deskripsi }}</div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-700">
                            {{ $item->nama_siswa }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-bold text-[11px]">
                                {{ $item->tingkat }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-600">
                            {{ $item->tahun }}
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.prestasi.edit', ['tenant' => $tenant->slug, 'prestasi' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.prestasi.destroy', ['tenant' => $tenant->slug, 'prestasi' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data prestasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-md bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold transition cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data prestasi siswa yang dicatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 2. Tampilan Grid (Kartu Prestasi) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($prestasi as $item)
                <div class="border border-slate-200/90 rounded-2xl overflow-hidden bg-white shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 bg-slate-100 overflow-hidden">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_prestasi }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center text-xs text-slate-400 font-bold">PIALA PRESTASI</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-amber-500 text-slate-950 shadow-xs">
                                    {{ $item->tingkat }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                    {{ $item->tahun }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 space-y-1.5">
                            <div class="text-[11px] font-bold text-blue-700">{{ $item->nama_siswa }}</div>
                            <h4 class="font-bold text-slate-900 text-sm leading-snug line-clamp-2">
                                {{ $item->nama_prestasi }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-slate-100 flex items-center justify-between mt-3">
                        <a href="{{ route('tenant.admin.prestasi.edit', ['tenant' => $tenant->slug, 'prestasi' => $item->id]) }}" class="text-xs font-bold text-blue-700 hover:text-blue-800">
                            Edit Data &rarr;
                        </a>
                        <form action="{{ route('tenant.admin.prestasi.destroy', ['tenant' => $tenant->slug, 'prestasi' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus data prestasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-10 text-center text-slate-400 text-xs">Belum ada data prestasi siswa yang dicatat.</div>
                @endforelse
            </div>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $prestasi->links() }}
        </div>
    </div>

</div>
@endsection
