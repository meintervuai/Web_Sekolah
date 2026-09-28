@extends('layouts.tenant_admin')

@section('title', 'Direktori Guru & Staf')
@section('header_title', 'Kelola Guru & Tenaga Kependidikan')

@section('content')
<div class="max-w-6xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden" x-data="{ viewMode: 'list' }">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Direktori Guru & Tenaga Kependidikan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data pendidik, bidang mata pelajaran yang diampu, jabatan, serta foto profil resmi.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- List vs Grid View Toggle -->
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

                <a href="{{ route('tenant.admin.guru.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Guru/Staf
                </a>
            </div>
        </div>

        <!-- 1. Tampilan List (Tabel) -->
        <div x-show="viewMode === 'list'" class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Foto</th>
                        <th class="px-4 py-3">Nama Lengkap & NIP</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($guru as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                            @else
                            <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-[10px] text-slate-500 font-bold">
                                {{ substr($item->nama_lengkap, 0, 1) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-slate-800 text-sm">{{ $item->nama_lengkap }}</div>
                            <div class="text-[11px] text-slate-400 font-mono">NIP: {{ $item->nip ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-700">
                            {{ $item->jabatan }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $item->mata_pelajaran ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($item->status_aktif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('tenant.admin.guru.edit', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.guru.destroy', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendidik ini?')">
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
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data guru/staf yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 2. Tampilan Grid (Kartu Profil) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @forelse($guru as $item)
                <div class="border border-slate-200/90 rounded-2xl overflow-hidden bg-white shadow-2xs hover:shadow-md transition flex flex-col justify-between text-center p-5">
                    <div>
                        <div class="relative w-20 h-20 mx-auto rounded-full overflow-hidden border-2 border-blue-600/30 mb-3 shadow-sm bg-slate-100 flex items-center justify-center">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_lengkap }}" class="w-full h-full object-cover">
                            @else
                            <span class="text-xl font-bold text-slate-500">{{ substr($item->nama_lengkap, 0, 1) }}</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">
                            {{ $item->nama_lengkap }}
                        </h4>
                        <div class="text-[11px] font-semibold text-blue-700 mt-0.5">{{ $item->jabatan }}</div>
                        <div class="text-[11px] text-slate-500 mt-1 line-clamp-1">
                            {{ $item->mata_pelajaran ?? 'Tenaga Kependidikan' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">NIP: {{ $item->nip ?? '-' }}</div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-4">
                        @if($item->status_aktif)
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
                        @else
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Nonaktif</span>
                        @endif

                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('tenant.admin.guru.edit', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.guru.destroy', ['tenant' => $tenant->slug, 'guru' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus data pendidik ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 py-10 text-center text-slate-400 text-xs">Belum ada data guru/staf yang ditambahkan.</div>
                @endforelse
            </div>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $guru->links() }}
        </div>
    </div>

</div>
@endsection
