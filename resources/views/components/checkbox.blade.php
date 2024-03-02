@props([
    'id' => null,
    'label' => null,
    'type' => 'checkbox',
    'size' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'disabled' => null,
    'readonly' => null,
    'error' => null,
])

@php
    $attributes = $attributes->class(['form-check-input', 'is-invalid' => $errors->has($id)])->merge([
        'type' => $type,
        'name' => $id,
        'id' => $id,
        'required' => $required,
        'value' => $value,
        'autofocus' => $autofocus,
        'disabled' => $disabled,
        'readonly' => $readonly,
        'style' => 'cursor: pointer',
    ]);
@endphp

<div class="form-check mb-3">
    <input {{ $attributes }}>
    <label class="form-check-label" for="{{ $id }}">
        {{ $label ?? $slot }}
    </label>
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
