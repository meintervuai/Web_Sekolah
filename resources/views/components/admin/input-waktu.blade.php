@props([
    'name' => 'jam',
    'value' => '08:00 WIB',
    'label' => 'Jam Pelaksanaan',
    'required' => false
])

@php
    // Pisahkan nilai time dan zona dari value jika ada
    $val = trim((string) $value);
    $timePart = '08:00';
    $zonePart = 'WIB';

    if (preg_match('/^(\d{1,2}[:.]\d{2})\s*(WIB|WITA|WIT)?$/i', $val, $matches)) {
        $timePart = str_replace('.', ':', $matches[1]);
        if (strlen($timePart) === 4) { // e.g. 8:00 -> 08:00
            $timePart = '0' . $timePart;
        }
        $zonePart = !empty($matches[2]) ? strtoupper($matches[2]) : 'WIB';
    }
@endphp

<div class="space-y-1.5" x-data="{
    time: '{{ $timePart }}',
    zone: '{{ $zonePart }}',
    get combined() {
        return this.time ? `${this.time} ${this.zone}` : '';
    }
}">
    <label class="block text-xs font-semibold text-slate-700">
        {{ $label }}
        @if($required) <span class="text-rose-500">*</span> @endif
    </label>
    
    <!-- Hidden input yang menyimpan string gabungan waktu e.g. 08:00 WIB -->
    <input type="hidden" :name="'{{ $name }}'" :value="combined">

    <div class="flex items-center gap-2">
        <div class="relative flex-1">
            <input 
                type="time" 
                x-model="time" 
                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500"
                @if($required) required @endif
            >
        </div>
        <div class="w-28 shrink-0">
            <select 
                x-model="zone" 
                class="w-full px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500 cursor-pointer"
            >
                <option value="WIB">WIB (Barat)</option>
                <option value="WITA">WITA (Tengah)</option>
                <option value="WIT">WIT (Timur)</option>
            </select>
        </div>
    </div>
</div>
