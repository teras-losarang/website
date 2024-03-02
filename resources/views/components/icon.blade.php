@props([
    'name' => null,
    'size' => null,
    'color' => null,
    'id' => null,
])

@php
    $attributes = $attributes->class([$name, $size => $size, "text-$color" => $color])->merge([
        'id' => $id,
    ]);
@endphp

@if ($name)
    <i {{ $attributes }}></i>
@endif
