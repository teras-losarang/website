@props(['id' => null, 'title' => null, 'form' => null, 'footer' => null])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $id }}Label">{!! $title ?? 'Modal title' !!}</h1>
            </div>
            @if ($form)
                <form action="{{ $form }}" method="post" class="needs-validation" novalidate>
                    @csrf
            @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if ($footer)
                <div {{ $footer->attributes->class(['modal-footer']) }}>
                    {{ $footer }}
                </div>
            @endif
            @if ($form)
                </form>
            @endif
        </div>
    </div>
</div>
