@props(['paginator' => null])

@if ($paginator->hasPages())
    <nav class="d-flex align-items-center justify-content-md-end justify-content-center ms-3">
        <p class="me-2 mt-2 d-flex align-items-center">
            @if ($paginator->firstItem())
                <span>{{ $paginator->firstItem() }}</span>
                <span>&nbsp;-&nbsp;</span>
                <span>{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
        </p>
        <p class="me-2 mt-2">dari</p>
        <p class="mt-2">{{ $paginator->total() }}</p>
        <p class="mt-2">
            @if ($paginator->onFirstPage())
                <span class="btn pointer-block no-border show-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 8 8 12 12 16"></polyline>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                    </svg>
                </span>
            @else
                <a class="btn no-border show-block" href="{{ $paginator->previousPageUrl() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-arrow-left-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 8 8 12 12 16"></polyline>
                        <line x1="16" y1="12" x2="8" y2="12"></line>
                    </svg>
                </a>
            @endif
        </p>
        <p class="mt-2">
            @if ($paginator->hasMorePages())
                <a class="btn show-block no-border" href="{{ $paginator->nextPageUrl() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-arrow-right-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 16 16 12 12 8"></polyline>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </a>
            @else
                <span class="btn pointer-block show-block no-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-arrow-right-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 16 16 12 12 8"></polyline>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </span>
            @endif
        </p>
    </nav>
@endif

<style>
    .pointer-block {
        cursor: no-drop;
    }

    .no-border {
        border: none;
    }

    .show-block:hover {
        background-color: rgba(0, 0, 0, 0.035);
    }
</style>
