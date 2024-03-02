@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'size' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => null,
    'error' => null,
    'sm' => '2',
])

@php
    $attributes = $attributes->class(['form-control', "form-control-$size" => $size, 'is-invalid' => $errors->has($id)])->merge([
        'type' => $type,
        'name' => $id,
        'id' => $id,
        'required' => $required,
        'placeholder' => $placeholder,
        'value' => $value,
    ]);
@endphp

<div @class([$margin, 'row align-items-center'])>
    <x-label :for="$id" :label="$label" class="col-sm-{{ $sm }}" />
    <div class="col-sm">
        <input {{ $attributes }}>
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
