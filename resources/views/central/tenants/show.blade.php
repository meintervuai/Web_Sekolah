@extends('layouts.central')

@section('title', $tenant->nama_sekolah)
@section('page_title', 'Detail Tenant Sekolah')
@section('page_subtitle', 'Informasi terperinci konfigurasi dan status operasional tenant')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation / Breadcrumb -->
    <div class="flex items-center justify-between">
        <a 
            href="{{ route('superadmin.tenants.index') }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Sekolah</span>
        </a>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('superadmin.tenants.edit', $tenant) }}" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold transition-colors min-h-[40px]"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Konfigurasi</span>
            </a>
            
            <form method="POST" action="{{ route('superadmin.tenants.toggle-status', $tenant) }}" class="inline">
                @csrf
                @method('PATCH')
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold border transition-colors min-h-[40px] {{ $tenant->status_aktif ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}"
                >
                    <span>{{ $tenant->status_aktif ? 'Suspend Tenant' : 'Aktifkan Kembali' }}</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Header Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2.5 mb-2">
                    <span class="inline-flex px-3 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                        {{ $tenant->jenjang }}
                    </span>
                    @if ($tenant->status_aktif)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Aktif Beroperasi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Ditangguhkan (Suspend)
                        </span>
                    @endif
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $tenant->nama_sekolah }}</h1>
                <div class="mt-2 text-xs text-slate-500 font-mono">
                    UUID: <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-700">{{ $tenant->id }}</span>
                </div>
            </div>

            <div class="sm:text-right text-xs text-slate-500">
                <div>Terdaftar Sejak:</div>
                <div class="font-semibold text-slate-800 text-sm mt-0.5">{{ $tenant->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Domain & Akses -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                Domain Terhubung
            </h3>

            <div class="space-y-2">
                @forelse ($tenant->domains as $d)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            <span class="font-mono text-sm font-semibold text-indigo-600">{{ $d->domain }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400">DNS Aktif</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 italic">Belum ada domain terdaftar.</div>
                @endforelse
            </div>
            <p class="text-xs text-slate-400">
                Domain digunakan untuk merutekan pengunjung langsung ke database terisolasi milik sekolah ini.
            </p>
        </div>

        <!-- Masa Berakhir & Langganan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Masa Operasional
            </h3>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500">Batas Waktu Operasional:</span>
                    <span class="font-semibold text-slate-800">
                        {{ $tenant->tgl_berakhir ? $tenant->tgl_berakhir->format('d F Y') : 'Tanpa Batas (Unlimited)' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500">Sisa Durasi:</span>
                    <span class="font-semibold {{ $tenant->tgl_berakhir && $tenant->tgl_berakhir->isPast() ? 'text-rose-600' : 'text-emerald-600' }}">
                        @if ($tenant->tgl_berakhir)
                            {{ $tenant->tgl_berakhir->diffForHumans() }}
                        @else
                            Aktif Permanen
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Kontak & Alamat -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Informasi Kontak & Lokasi
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Nomor Telepon:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['telepon'] ?? '-' }}</div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Email Resmi:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['email'] ?? '-' }}</div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-slate-400 font-medium">Alamat:</div>
                    <div class="text-slate-800 font-semibold mt-1">{{ $tenant->data['alamat'] ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Visibilitas Menu & Rute Publik (Super Admin Controller) -->
        <div 
            class="md:col-span-2 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-2xs space-y-6"
            x-data="menuVisibilityController({
                toggleUrl: '{{ route('superadmin.tenants.toggle-menu', $tenant) }}',
                csrfToken: '{{ csrf_token() }}',
                initialItems: {{ json_encode($menuItems ?? []) }}
            })"
        >
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Kontrol Visibilitas Menu & Rute Tenant
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Pengaturan master status tayang menu navigasi navbar dan akses rute publik sekolah. Hanya Super Admin yang berwenang mengaktifkan atau menonaktifkan modul.
                    </p>
                </div>

                <!-- Status Feedback Badge -->
                <div class="flex items-center gap-2" x-cloak>
                    <div x-show="isSaving" class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 animate-pulse">
                        <svg class="w-3.5 h-3.5 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Menyinkronkan...</span>
                    </div>
                    <div x-show="saveSuccess" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 transition-all duration-300">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Perubahan tersimpan!</span>
                    </div>
                    <div x-show="errorMessage" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <span x-text="errorMessage"></span>
                    </div>
                </div>
            </div>

            <!-- List Menu & Sub-menu -->
            <div class="divide-y divide-slate-100">
                <template x-for="item in items" :key="item.key">
                    <div class="py-4 first:pt-0 last:pb-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-800" x-text="item.label"></span>
                                    <span 
                                        class="px-2 py-0.5 rounded text-[11px] font-mono"
                                        :class="item.type === 'menu' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-700 border border-slate-200'"
                                        x-text="item.type === 'menu' ? 'Menu Navbar' : 'Sub-Bagian'"
                                    ></span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed" x-text="item.description"></p>
                            </div>

                            <!-- Switch Button -->
                            <div class="flex items-center shrink-0 pt-0.5">
                                <button 
                                    type="button" 
                                    role="switch" 
                                    :aria-checked="item.aktif ? 'true' : 'false'"
                                    @click="toggleItem(item)"
                                    :disabled="isSaving"
                                    class="relative inline-flex h-6 w-11 p-0.5 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-hidden focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="item.aktif ? 'bg-emerald-600' : 'bg-slate-300'"
                                >
                                    <span class="sr-only" x-text="'Ubah visibilitas ' + item.label"></span>
                                    <span 
                                        aria-hidden="true" 
                                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-xs ring-0 transition-transform duration-200 ease-in-out"
                                        :class="item.aktif ? 'translate-x-5' : 'translate-x-0'"
                                    ></span>
                                </button>
                            </div>
                        </div>

                        <!-- Sub-Sections List jika ada -->
                        <template x-if="item.sub_sections && item.sub_sections.length > 0">
                            <div class="mt-3.5 pl-4 sm:pl-6 border-l-2 border-slate-100 space-y-3">
                                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    Sub-Komponen / Bagian Terkait
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <template x-for="sub in item.sub_sections" :key="sub.key">
                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
                                            <div class="min-w-0">
                                                <div class="text-xs font-semibold text-slate-700 truncate" x-text="sub.label"></div>
                                                <div class="text-[11px] text-slate-400 truncate font-mono" x-text="sub.key"></div>
                                            </div>
                                            <button 
                                                type="button" 
                                                role="switch" 
                                                :aria-checked="sub.aktif ? 'true' : 'false'"
                                                @click="toggleSubSection(sub, item)"
                                                :disabled="isSaving"
                                                class="relative inline-flex h-5 w-9 p-0.5 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-hidden focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 disabled:opacity-50"
                                                :class="sub.aktif ? 'bg-emerald-600' : 'bg-slate-300'"
                                            >
                                                <span class="sr-only" x-text="'Ubah ' + sub.label"></span>
                                                <span 
                                                    aria-hidden="true" 
                                                    class="pointer-events-none inline-block h-4 w-4 rounded-full bg-white shadow-xs ring-0 transition-transform duration-200 ease-in-out"
                                                    :class="sub.aktif ? 'translate-x-4' : 'translate-x-0'"
                                                ></span>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <!-- Script Controller Alpine.js -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menuVisibilityController', (config) => ({
                items: config.initialItems,
                isSaving: false,
                saveSuccess: false,
                errorMessage: '',

                async toggleItem(item) {
                    const newState = !item.aktif;
                    this.isSaving = true;
                    this.errorMessage = '';
                    this.saveSuccess = false;

                    try {
                        const response = await fetch(config.toggleUrl, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': config.csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                key: item.key,
                                type: item.type,
                                aktif: newState
                            })
                        });

                        const result = await response.json();

                        if (!response.ok || !result.success) {
                            throw new Error(result.message || 'Gagal memperbarui visibilitas menu');
                        }

                        // Update state lokal
                        item.aktif = newState;

                        // Jika cascade otomatis dari controller
                        if (item.sub_sections && item.sub_sections.length > 0) {
                            item.sub_sections.forEach(sub => {
                                sub.aktif = newState;
                            });
                        }

                        this.saveSuccess = true;
                        setTimeout(() => {
                            this.saveSuccess = false;
                        }, 3000);
                    } catch (err) {
                        console.error('Error toggling menu:', err);
                        this.errorMessage = err.message || 'Terjadi kesalahan sistem';
                        setTimeout(() => {
                            this.errorMessage = '';
                        }, 5000);
                    } finally {
                        this.isSaving = false;
                    }
                },

                async toggleSubSection(sub, parentItem) {
                    const newState = !sub.aktif;
                    this.isSaving = true;
                    this.errorMessage = '';
                    this.saveSuccess = false;

                    try {
                        const response = await fetch(config.toggleUrl, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': config.csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                key: sub.key,
                                type: sub.type,
                                aktif: newState
                            })
                        });

                        const result = await response.json();

                        if (!response.ok || !result.success) {
                            throw new Error(result.message || 'Gagal memperbarui status sub-bagian');
                        }

                        sub.aktif = newState;

                        // Jika sub-bagian diaktifkan, pastikan parent juga aktif di UI jika sebelumnya mati
                        if (newState && !parentItem.aktif) {
                            parentItem.aktif = true;
                        }

                        this.saveSuccess = true;
                        setTimeout(() => {
                            this.saveSuccess = false;
                        }, 3000);
                    } catch (err) {
                        console.error('Error toggling subsection:', err);
                        this.errorMessage = err.message || 'Terjadi kesalahan sistem';
                        setTimeout(() => {
                            this.errorMessage = '';
                        }, 5000);
                    } finally {
                        this.isSaving = false;
                    }
                }
            }));
        });
    </script>

    <!-- Danger Zone Delete -->
    <div class="p-6 rounded-2xl border border-rose-200 bg-rose-50/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-sm font-bold text-rose-900">Hapus Permanen Tenant</h4>
            <p class="text-xs text-rose-700 mt-0.5">Menghapus tenant ini akan mencabut seluruh domain terdaftar dan data konfigurasi terkait.</p>
        </div>
        <form 
            method="POST" 
            action="{{ route('superadmin.tenants.destroy', $tenant) }}"
            onsubmit="return confirm('PENTING: Apakah Anda benar-benar yakin ingin menghapus sekolah {{ $tenant->nama_sekolah }} secara permanen?');"
        >
            @csrf
            @method('DELETE')
            <button 
                type="submit" 
                class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-xs transition-colors min-h-[40px]"
            >
                Hapus Tenant Sekolah
            </button>
        </form>
    </div>

</div>
@endsection
