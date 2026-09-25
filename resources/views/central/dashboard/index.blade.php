@extends('layouts.central')

@section('title', 'Ringkasan Platform')
@section('page_title', 'Ringkasan Platform')
@section('page_subtitle', 'Statistik operasional seluruh tenant sekolah yang terdaftar di platform')

@section('content')
<div class="space-y-8">
    
    <!-- Hero / Quick Overview Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Selamat datang, {{ Auth::guard('superadmin')->user()->nama }}</h2>
            <p class="text-sm text-slate-500 mt-0.5">Platform saat ini menaungi <span class="font-semibold text-slate-800">{{ $totalSekolah }} institusi pendidikan</span> dengan <span class="font-semibold text-slate-800">{{ $sekolahAktif }} tenant aktif</span>.</p>
        </div>
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('superadmin.tenants.create') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-xs transition-colors min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Sekolah</span>
            </a>
            <a 
                href="{{ route('superadmin.tenants.index') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors min-h-[44px]"
            >
                <span>Lihat Semua</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Sekolah -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Sekolah</span>
                <span class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <div class="text-3xl font-bold text-slate-900">{{ $totalSekolah }}</div>
                <div class="text-xs text-slate-500">Tenant terdaftar</div>
            </div>
        </div>

        <!-- Sekolah Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sekolah Aktif</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <div class="text-3xl font-bold text-emerald-600">{{ $sekolahAktif }}</div>
                <div class="text-xs text-slate-500">
                    {{ $totalSekolah > 0 ? round(($sekolahAktif / $totalSekolah) * 100) : 0 }}% dari total
                </div>
            </div>
        </div>

        <!-- Sekolah Nonaktif / Suspend -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nonaktif / Suspend</span>
                <span class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <div class="text-3xl font-bold text-rose-600">{{ $sekolahNonaktif }}</div>
                <div class="text-xs text-slate-500">Masa aktif habis / ditangguhkan</div>
            </div>
        </div>

        <!-- Total Domain -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Domain</span>
                <span class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <div class="text-3xl font-bold text-slate-900">{{ $totalDomain }}</div>
                <div class="text-xs text-slate-500">Subdomain & Kustom Domain</div>
            </div>
        </div>
    </div>

    <!-- Jenjang Breakdown -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Distribusi Jenjang Pendidikan</h3>
        <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-9 gap-3">
            @php
                $jenjangList = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];
            @endphp
            @foreach ($jenjangList as $jenjang)
                @php
                    $count = $jenjangCounts[$jenjang] ?? 0;
                @endphp
                <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/70 text-center">
                    <span class="text-xs font-bold text-slate-600 block">{{ $jenjang }}</span>
                    <span class="text-lg font-bold text-slate-900 block mt-1">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Schools Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Sekolah Terbaru Didaftarkan</h3>
                <p class="text-xs text-slate-500">5 pendaftaran tenant terakhir di sistem</p>
            </div>
            <a href="{{ route('superadmin.tenants.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                Buka Direktori Lengkap &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Nama Sekolah</th>
                        <th class="py-3 px-4">Jenjang</th>
                        <th class="py-3 px-4">Domain Terhubung</th>
                        <th class="py-3 px-4">Masa Aktif</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($sekolahTerbaru as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                <a href="{{ route('superadmin.tenants.show', $item) }}" class="hover:text-indigo-600 transition-colors">
                                    {{ $item->nama_sekolah }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $item->jenjang }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-indigo-600">
                                {{ $item->domains->first()?->domain ?? 'Belum ada domain' }}
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                {{ $item->tgl_berakhir ? $item->tgl_berakhir->format('d M Y') : 'Tanpa batas' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($item->status_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Suspend
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a 
                                        href="{{ route('superadmin.tenants.show', $item) }}" 
                                        class="p-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-slate-100 min-h-[36px] min-w-[36px] flex items-center justify-center transition-colors"
                                        title="Lihat Detail"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a 
                                        href="{{ route('superadmin.tenants.edit', $item) }}" 
                                        class="p-2 rounded-lg text-slate-600 hover:text-amber-600 hover:bg-slate-100 min-h-[36px] min-w-[36px] flex items-center justify-center transition-colors"
                                        title="Ubah Konfigurasi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">
                                Belum ada sekolah yang didaftarkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
