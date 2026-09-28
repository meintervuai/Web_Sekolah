@extends('layouts.tenant_admin')

@section('title', 'Ekstrakurikuler')
@section('header_title', 'Kelola Ekstrakurikuler')

@section('content')
<div class="max-w-6xl space-y-6" x-data="{ viewMode: 'list' }">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Ekstrakurikuler Sekolah</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola organisasi kepemudaan, klub minat bakat, jadwal latihan, dan pembina ekskul.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- View Mode Toggle -->
                <div class="inline-flex items-center p-1 bg-slate-200/80 rounded-xl">
                    <button type="button" @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        List
                    </button>
                    <button type="button" @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Grid
                    </button>
                </div>

                <a href="{{ route('tenant.admin.ekskul.create', ['tenant' => $tenant->slug]) }}" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs shadow-md transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Ekskul
                </a>
            </div>
        </div>

        <!-- Mode List (Tabel) -->
        <div x-show="viewMode === 'list'" class="p-6 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-600 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Foto</th>
                        <th class="px-4 py-3">Nama Ekstrakurikuler</th>
                        <th class="px-4 py-3">Pembina</th>
                        <th class="px-4 py-3">Jadwal Latihan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($ekskul as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3">
                            @if($item->foto)
                            <img src="{{ $item->foto }}" alt="{{ $item->nama_ekstrakurikuler }}" class="w-12 h-9 rounded object-cover border border-slate-200">
                            @else
                            <div class="w-12 h-9 rounded bg-slate-200 flex items-center justify-center text-[9px] text-slate-400">NO PIC</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-xs">
                            <div class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->nama_ekstrakurikuler }}</div>
                            <div class="text-[11px] text-slate-400 line-clamp-1">{{ $item->deskripsi }}</div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-700">
                            {{ $item->pembina ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $item->hari_jadwal ?? '-' }} {{ $item->waktu_jadwal ? '('.$item->waktu_jadwal.')' : '' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($item->is_aktif)
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
                            <a href="{{ route('tenant.admin.ekskul.edit', ['tenant' => $tenant->slug, 'ekskul' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                Edit
                            </a>
                            <form action="{{ route('tenant.admin.ekskul.destroy', ['tenant' => $tenant->slug, 'ekskul' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ekstrakurikuler ini?')">
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
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada ekstrakurikuler yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mode Grid (Kartu) -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-6">
            @if($ekskul->isEmpty())
                <div class="py-12 text-center text-slate-400 text-xs">
                    Belum ada ekstrakurikuler yang ditambahkan.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($ekskul as $item)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col justify-between hover:border-blue-300 transition group shadow-2xs">
                            <div>
                                <div class="aspect-16/10 bg-slate-100 overflow-hidden relative border-b border-slate-100">
                                    @if($item->foto)
                                        <img src="{{ $item->foto }}" alt="{{ $item->nama_ekstrakurikuler }}" class="w-full h-full object-cover group-hover:scale-102 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-slate-400 font-medium">Tanpa Foto</div>
                                    @endif
                                    <div class="absolute top-2.5 right-2.5">
                                        @if($item->is_aktif)
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500 text-white shadow-xs">Aktif</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-slate-500 text-white shadow-xs">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-4 space-y-2">
                                    <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $item->nama_ekstrakurikuler }}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">{{ $item->deskripsi ?? 'Organisasi pembinaan minat bakat siswa.' }}</p>
                                    
                                    <div class="pt-2 border-t border-slate-100 space-y-1 text-[11px]">
                                        <div class="flex items-center justify-between text-slate-600">
                                            <span class="text-slate-400">Pembina:</span>
                                            <span class="font-semibold">{{ $item->pembina ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-slate-600">
                                            <span class="text-slate-400">Jadwal:</span>
                                            <span>{{ $item->hari_jadwal ?? '-' }} {{ $item->waktu_jadwal ? '('.$item->waktu_jadwal.')' : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-2">
                                <a href="{{ route('tenant.admin.ekskul.edit', ['tenant' => $tenant->slug, 'ekskul' => $item->id]) }}" class="px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                                    Edit
                                </a>
                                <form action="{{ route('tenant.admin.ekskul.destroy', ['tenant' => $tenant->slug, 'ekskul' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ekstrakurikuler ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 text-xs font-semibold hover:bg-rose-100 transition cursor-pointer">
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
