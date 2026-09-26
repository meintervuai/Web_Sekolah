@props([
    'name' => 'gambar',
    'value' => '',
    'label' => 'Gambar / Foto',
    'recommended' => 'Format JPG, PNG, atau WebP. Maks 2MB. Rekomendasi lebar 1200 - 1600px.',
    'required' => false
])

@php
    $inputId = 'file_' . \Illuminate\Support\Str::random(8);
    $urlId = 'url_' . \Illuminate\Support\Str::random(8);
    $previewId = 'prev_' . \Illuminate\Support\Str::random(8);
@endphp

<div class="space-y-2 bg-slate-50/70 p-3.5 rounded-xl border border-slate-200" x-data="{ mode: 'file', preview: '{{ $value }}' }">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-bold text-slate-800">
            {{ $label }}
            @if($required) <span class="text-rose-500">*</span> @endif
        </label>
        <div class="inline-flex rounded-lg bg-slate-200/80 p-0.5 text-[11px] font-semibold">
            <button type="button" @click="mode = 'file'" :class="mode === 'file' ? 'bg-white text-blue-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition cursor-pointer">
                Upload File
            </button>
            <button type="button" @click="mode = 'url'" :class="mode === 'url' ? 'bg-white text-blue-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition cursor-pointer">
                Input URL
            </button>
        </div>
    </div>

    <!-- Opsi 1: Upload File Gambar dengan Auto Compress WebP -->
    <div x-show="mode === 'file'" class="space-y-2">
        <input 
            type="file" 
            name="{{ $name }}_file" 
            id="{{ $inputId }}" 
            accept="image/png,image/jpeg,image/webp,image/jpg" 
            @change="const file = $event.target.files[0]; if (file) { preview = URL.createObjectURL(file); }"
            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer bg-white border border-slate-200 rounded-xl"
        >
        <p class="text-[11px] text-slate-500 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $recommended }} Sistem otomatis mengompres & mengonversi ke <strong>.webp</strong>.</span>
        </p>
    </div>

    <!-- Opsi 2: Input URL Gambar -->
    <div x-show="mode === 'url'" class="space-y-1">
        <input 
            type="text" 
            name="{{ $name }}" 
            id="{{ $urlId }}" 
            value="{{ $value }}" 
            @input="preview = $event.target.value"
            placeholder="https://..." 
            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500"
        >
        <p class="text-[11px] text-slate-400">Gunakan tautan CDN atau gambar eksternal valid.</p>
    </div>

    <!-- Preview Box -->
    <template x-if="preview">
        <div class="mt-2 pt-2 border-t border-slate-200/60 flex items-center gap-3">
            <div class="w-16 h-12 rounded-lg bg-slate-200 border border-slate-300/80 overflow-hidden shrink-0">
                <img :src="preview" alt="Preview" class="w-full h-full object-cover">
            </div>
            <div class="text-[11px] text-slate-500 line-clamp-1">
                Pratinjau visual aktif.
            </div>
        </div>
    </template>
</div>
