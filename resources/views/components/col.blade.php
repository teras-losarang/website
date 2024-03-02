@props([
    'xs' => '12',
    'sm' => '12',
    'md' => '12',
    'lg' => '12',
    'xl' => '12',
])

@php
    $attributes = $attributes->class([
        "col-xs-$xs" => $xs,
        "col-sm-$sm" => $sm,
        "col-md-$md" => $md,
        "col-lg-$lg" => $lg,
        "col-xl-$xl" => $xl,
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>
