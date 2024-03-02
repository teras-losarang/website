@props([
    'header' => null,
    'footer' => null,
    'body' => null,
    'image' => null,
    'imageHeight' => '100%',
    'imageWidth' => '100%',
])

<div {{ $attributes->class(['card']) }}>
    @if ($image)
        <img src="{{ $image }}" class="card-img-top" height="{{ $imageHeight }}" width="{{ $imageWidth }}">
    @endif
    @if ($header)
        <div {{ $header->attributes->class(['card-header']) }}>
            {{ $header }}
        </div>
    @endif

    @if ($body)
        <div {{ $body->attributes->class(['card-body']) }}>
            {{ $body }}
        </div>
    @else
        <div class="card-body">
            {{ $slot }}
        </div>
    @endif

    @if ($footer)
        <div {{ $footer->attributes->class(['card-footer']) }}>
            {{ $footer }}
        </div>
    @endif
</div>
