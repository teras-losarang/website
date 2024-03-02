@props([
    'label' => null,
    'for' => null,
    'class' => null,
    'id' => null,
])

@php
    $attributes = $attributes->class(["$class"])->merge([
        'for' => $for,
        'id' => $id,
    ]);
@endphp

@if ($label || !$slot->isEmpty())
    <label {{ $attributes }}>
        {{ $label ?? $slot }}
    </label>
@endif
