@props([
    'label' => null,
    'color' => null,
    'route' => null,
    'url' => null,
    'parameter' => null,
    'href' => '#',
])

@php
    if ($route) {
        $href = route($route, $parameter);
    } elseif ($url) {
        $href = url($url);
    }

    $attributes = $attributes
        ->class([
            'text-' . $color => $color,
        ])
        ->merge([
            'href' => $href,
        ]);
@endphp

<a {{ $attributes }}>
    {{ $label ?? $slot }}
</a>
