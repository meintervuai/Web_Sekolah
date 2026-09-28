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

<div class="space-y-2.5 bg-slate-50/70 p-4 rounded-xl border border-slate-200/90" x-data="{ mode: '{{ !empty($value) ? 'url' : 'file' }}', preview: '{{ $value }}', urlValue: '{{ $value }}' }">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-bold text-slate-800">
            {{ $label }}
            @if($required) <span class="text-rose-500">*</span> @endif
        </label>
        <div class="inline-flex rounded-lg bg-slate-200/80 p-0.5 text-xs font-semibold">
            <button type="button" @click="mode = 'file'" :class="mode === 'file' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition cursor-pointer">
                Upload File
            </button>
            <button type="button" @click="mode = 'url'" :class="mode === 'url' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition cursor-pointer">
                Input URL
            </button>
        </div>
    </div>

    <!-- Hidden Input untuk menjaga nilai yang sedang aktif/tersimpan -->
    <input type="hidden" name="{{ $name }}" :value="urlValue">

    <!-- Opsi 1: Upload File Gambar dengan Auto Compress WebP -->
    <div x-show="mode === 'file'" class="space-y-2">
        <input 
            type="file" 
            name="{{ $name }}_file" 
            id="{{ $inputId }}" 
            accept="image/png,image/jpeg,image/webp,image/jpg" 
            @change="const file = $event.target.files[0]; if (file) { preview = URL.createObjectURL(file); }"
            class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border border-slate-200 rounded-xl transition"
        >
        <p class="text-[11px] text-slate-500 flex items-center gap-1.5 font-medium">
            <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $recommended }} Sistem otomatis mengompres & mengonversi ke <strong>.webp</strong>.</span>
        </p>
    </div>

    <!-- Opsi 2: Input URL Gambar -->
    <div x-show="mode === 'url'" class="space-y-1">
        <input 
            type="text" 
            id="{{ $urlId }}" 
            x-model="urlValue"
            @input="preview = urlValue"
            placeholder="https://..." 
            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition"
        >
        <p class="text-[11px] text-slate-400 font-medium">Gunakan tautan CDN atau gambar eksternal valid.</p>
    </div>

    <!-- Preview Box -->
    <template x-if="preview">
        <div class="mt-3 pt-3 border-t border-slate-200 flex items-center gap-3">
            <div class="w-16 h-14 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0 shadow-2xs">
                <img :src="preview" alt="Preview" class="w-full h-full object-cover">
            </div>
            <div class="text-xs text-slate-600 font-medium line-clamp-1">
                Pratinjau visual terdeteksi. Siap dipublikasikan.
            </div>
        </div>
    </template>
</div>
