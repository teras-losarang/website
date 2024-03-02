@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'size' => null,
    'rows' => null,
    'cols' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => '',
    'error' => null,
])

@php
    $attributes = $attributes->class(['form-control', "form-control-$size" => $size, 'is-invalid' => $errors->has($id)])->merge([
        'name' => $id,
        'id' => $id,
        'autofocus' => $autofocus,
        'required' => $required,
        'placeholder' => $placeholder,
        'rows' => $rows,
        'cols' => $cols,
    ]);
@endphp

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <textarea {{ $attributes }}>{!! $value ?? $slot !!}</textarea>
    <div class="invalid-feedback">
        @if ($errors->has($id))
            @error($id)
                {{ $message }}
            @enderror
        @else
            {{ strtolower($label) . ' wajib diisi!' }}
        @endif
    </div>
</div>
