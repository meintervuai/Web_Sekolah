@extends('layouts.central')

@section('title', 'Edit ' . $tenant->nama_sekolah)
@section('page_title', 'Ubah Konfigurasi Sekolah')
@section('page_subtitle', 'Perbarui identitas, domain, dan parameter operasional tenant')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a 
            href="{{ route('superadmin.tenants.show', $tenant) }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Sekolah</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Perbarui Data Tenant</h2>
                <p class="text-xs text-slate-500 mt-0.5">ID Tenant: <span class="font-mono text-slate-700">{{ $tenant->id }}</span></p>
            </div>
            <span class="inline-flex px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                {{ $tenant->jenjang }}
            </span>
        </div>

        <form action="{{ route('superadmin.tenants.update', $tenant) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Sekolah -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    1. Identitas & Jenjang Pendidikan
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Sekolah -->
                    <div class="sm:col-span-2">
                        <label for="nama_sekolah" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Sekolah / Institusi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_sekolah" 
                            name="nama_sekolah" 
                            value="{{ old('nama_sekolah', $tenant->nama_sekolah) }}" 
                            required 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('nama_sekolah')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang -->
                    <div>
                        <label for="jenjang" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jenjang Pendidikan <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="jenjang" 
                            name="jenjang" 
                            required
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                            @foreach ($daftarJenjang as $j)
                                <option value="{{ $j }}" {{ old('jenjang', $tenant->jenjang) == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenjang')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Domain -->
                    <div>
                        <label for="domain" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Domain / Subdomain Utama <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="domain" 
                            name="domain" 
                            value="{{ old('domain', $primaryDomain) }}" 
                            required 
                            class="w-full px-4 py-3 font-mono bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('domain')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Langganan & Masa Aktif -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    2. Masa Operasional & Status
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Tanggal Berakhir -->
                    <div>
                        <label for="tgl_berakhir" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Tanggal Masa Berakhir
                        </label>
                        <input 
                            type="date" 
                            id="tgl_berakhir" 
                            name="tgl_berakhir" 
                            value="{{ old('tgl_berakhir', $tenant->tgl_berakhir?->format('Y-m-d')) }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                        @error('tgl_berakhir')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="flex items-center sm:pt-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="status_aktif" 
                                value="1" 
                                {{ old('status_aktif', $tenant->status_aktif) ? 'checked' : '' }}
                                class="w-5 h-5 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            <div>
                                <span class="text-sm font-semibold text-slate-800">Status Aktif Beroperasi</span>
                                <p class="text-xs text-slate-500">Uncheck untuk menangguhkan (suspend) akses website sekolah.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kontak & Informasi Tambahan -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    3. Data Kontak & Alamat Sekolah
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nomor Telepon Sekolah
                        </label>
                        <input 
                            type="text" 
                            id="telepon" 
                            name="telepon" 
                            value="{{ old('telepon', $tenant->data['telepon'] ?? '') }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Email Resmi Sekolah
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $tenant->data['email'] ?? '') }}" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 min-h-[44px]"
                        >
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Lengkap Institusi
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2" 
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600"
                        >{{ old('alamat', $tenant->data['alamat'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('superadmin.tenants.show', $tenant) }}" 
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors min-h-[44px] flex items-center"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm transition-colors min-h-[44px] flex items-center"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
