@extends('layouts.central')

@section('title', 'Kelola Sekolah (Tenants)')
@section('page_title', 'Kelola Sekolah (Tenants)')
@section('page_subtitle', 'Direktori dan manajemen seluruh institusi sekolah yang terdaftar di platform')

@section('content')
<div class="space-y-6">

    <!-- Action Bar & Filter Controls -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Daftar Tenant Sekolah</h2>
                <p class="text-xs text-slate-500">Kelola status langganan, alokasi domain, dan konfigurasi tenant</p>
            </div>
            <a 
                href="{{ route('superadmin.tenants.create') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-xs transition-colors min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Daftarkan Sekolah Baru</span>
            </a>
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('superadmin.tenants.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2 border-t border-slate-100">
            <!-- Search Keyword -->
            <div class="sm:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari nama sekolah atau domain..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                >
            </div>

            <!-- Filter Jenjang -->
            <div class="sm:col-span-3">
                <select 
                    name="jenjang" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                >
                    <option value="">Semua Jenjang</option>
                    @foreach ($daftarJenjang as $j)
                        <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-2">
                <select 
                    name="status" 
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                >
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspend" {{ request('status') === 'suspend' ? 'selected' : '' }}>Suspend</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="sm:col-span-1 flex gap-2">
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center p-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white min-h-[44px] transition-colors"
                    title="Terapkan Filter"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </button>
                @if (request()->hasAny(['q', 'jenjang', 'status']))
                    <a 
                        href="{{ route('superadmin.tenants.index') }}" 
                        class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 min-h-[44px] flex items-center justify-center transition-colors"
                        title="Reset Filter"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tenants Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-5">Nama Sekolah</th>
                        <th class="py-3.5 px-4">Jenjang</th>
                        <th class="py-3.5 px-4">Domain Terhubung</th>
                        <th class="py-3.5 px-4">Masa Berakhir</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($sekolahList as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5">
                                <a href="{{ route('superadmin.tenants.show', $item) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors block">
                                    {{ $item->nama_sekolah }}
                                </a>
                                <span class="text-xs text-slate-400 font-mono">ID: {{ Str::limit($item->id, 13) }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $item->jenjang }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono text-xs text-indigo-600">
                                @if ($item->domains->isNotEmpty())
                                    <div class="space-y-0.5">
                                        @foreach ($item->domains as $d)
                                            <div>{{ $d->domain }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum terhubung</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                @if ($item->tgl_berakhir)
                                    <div>{{ $item->tgl_berakhir->format('d M Y') }}</div>
                                    @if ($item->tgl_berakhir->isPast())
                                        <span class="text-[10px] text-rose-500 font-medium font-semibold">Telah kedaluwarsa</span>
                                    @else
                                        <span class="text-[10px] text-slate-400">{{ $item->tgl_berakhir->diffForHumans() }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400">Tanpa batas</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <form method="POST" action="{{ route('superadmin.tenants.toggle-status', $item) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit" 
                                        class="cursor-pointer min-h-[32px] inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-colors {{ $item->status_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100' }}"
                                        title="Klik untuk ubah status aktif/suspend"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->status_aktif ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span>{{ $item->status_aktif ? 'Aktif' : 'Suspend' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail -->
                                    <a 
                                        href="{{ route('superadmin.tenants.show', $item) }}" 
                                        class="p-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-slate-100 min-h-[36px] min-w-[36px] flex items-center justify-center transition-colors"
                                        title="Lihat Detail Sekolah"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a 
                                        href="{{ route('superadmin.tenants.edit', $item) }}" 
                                        class="p-2 rounded-lg text-slate-600 hover:text-amber-600 hover:bg-slate-100 min-h-[36px] min-w-[36px] flex items-center justify-center transition-colors"
                                        title="Edit Data"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Hapus -->
                                    <form 
                                        method="POST" 
                                        action="{{ route('superadmin.tenants.destroy', $item) }}" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus tenant {{ $item->nama_sekolah }}? Tindakan ini tidak dapat dibatalkan.');"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 min-h-[36px] min-w-[36px] flex items-center justify-center transition-colors"
                                            title="Hapus Tenant"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <p class="text-sm font-medium">Tidak ada data sekolah yang ditemukan.</p>
                                <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau daftarkan sekolah baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($sekolahList->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $sekolahList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
