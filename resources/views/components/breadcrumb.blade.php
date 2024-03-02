@props(['currentPage' => '', 'pages' => []])

<nav aria-label="breadcrumb" {{ $attributes->class(['']) }}>
    <ol class="breadcrumb">
        @if (count($pages[0]) < 1)
            <li class="breadcrumb-item active" aria-current="page">{{ $currentPage }}</li>
        @else
            @foreach ($pages[0] as $page)
                <li class="breadcrumb-item"><a href="{{ $page['link'] }}">{{ $page['text'] }}</a></li>
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{ $currentPage }}</li>
        @endif
    </ol>
</nav>
