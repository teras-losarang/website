@props([
    'label' => null,
    'color' => 'primary',
])

@php
    $attributes = $attributes->class(["badge bg-$color"]);
@endphp

<span {{ $attributes }}>
    {{ $label ?? $slot }}
</span>
