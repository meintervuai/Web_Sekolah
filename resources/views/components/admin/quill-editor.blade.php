@props([
    'name' => 'isi_konten',
    'value' => '',
    'label' => 'Isi Konten / Tulisan',
    'placeholder' => 'Mulai tulis artikel, narasi atau informasi di sini...',
    'required' => false,
    'height' => '250px'
])

@php
    $editorId = 'quill_editor_' . \Illuminate\Support\Str::random(8);
    $textareaId = 'quill_textarea_' . \Illuminate\Support\Str::random(8);
@endphp

<div class="space-y-1.5" x-data="quillComponent('{{ $editorId }}', '{{ $textareaId }}')">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-semibold text-slate-700">
            {{ $label }}
            @if($required) <span class="text-rose-500">*</span> @endif
        </label>
        <span class="text-[10px] text-slate-400 font-medium">WYSIWYG Rich Text</span>
    </div>

    <div class="bg-white rounded-xl shadow-2xs">
        <!-- Quill Editor Mount Point -->
        <div id="{{ $editorId }}" style="min-height: {{ $height }};">
            {!! $value !!}
        </div>
        <!-- Hidden input connected with Form submission -->
        <input type="hidden" name="{{ $name }}" id="{{ $textareaId }}" value="{{ $value }}">
    </div>
</div>

@once
@push('scripts')
<script>
function quillComponent(editorId, textareaId) {
    return {
        init() {
            this.$nextTick(() => {
                if (typeof Quill === 'undefined') {
                    console.error('Quill is not loaded');
                    return;
                }
                const editorElement = document.getElementById(editorId);
                const hiddenInput = document.getElementById(textareaId);

                if (!editorElement || editorElement.__quill) return;

                const quill = new Quill(editorElement, {
                    theme: 'snow',
                    placeholder: '{{ addslashes($placeholder) }}',
                    modules: {
                        toolbar: [
                            [{ 'header': [2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['blockquote', 'code-block'],
                            ['link', 'clean']
                        ]
                    }
                });

                editorElement.__quill = quill;

                // Sync Quill HTML content to hidden input
                quill.on('text-change', () => {
                    const html = editorElement.querySelector('.ql-editor').innerHTML;
                    hiddenInput.value = (html === '<p><br></p>') ? '' : html;
                });
            });
        }
    };
}
</script>
@endpush
@endonce
