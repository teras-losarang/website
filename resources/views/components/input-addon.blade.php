@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'size' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => '',
    'error' => null,
])

@php
    $attributes = $attributes->class(['form-control', "form-control-$size" => $size, 'is-invalid' => $errors->has($id)])->merge([
        'type' => $type,
        'name' => $id,
        'id' => $id,
        'required' => $required,
        'placeholder' => $placeholder,
        'value' => $value,
        'autofocus' => $autofocus,
    ]);
@endphp

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <div class="input-group input-group-merge">
        <input {{ $attributes }}>
        {{ $slot }}
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
</div>
