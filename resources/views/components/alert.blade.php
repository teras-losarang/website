@props([
    'label' => null,
    'color' => 'success',
    'dismissible' => false,
])

@php
    $attributes = $attributes->class(["alert alert-$color fade show mb-0", 'alert-dismissible' => $dismissible])->merge([
        'role' => 'alert',
    ]);
@endphp

<div {{ $attributes }}>
    @if ($dismissible)
        <x-close dismiss="alert"></x-close>
    @endif

    {{ $label ?? $slot }}

</div>
