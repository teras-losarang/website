@props([
    'thead' => null,
    'tbody' => null,
    'tfoot' => null,
    'isComplete' => false,
])

<div class="table-responsive">
    <table {{ $attributes->class(['table']) }}>
        @if ($isComplete)
            @if ($thead)
                <thead {{ $thead->attributes->class([]) }}>
                    <tr>
                        {{ $thead }}
                    </tr>
                </thead>
            @endif
            @if ($tbody)
                <tbody {{ $tbody->attributes->class([]) }}>
                    {{ $tbody }}
                </tbody>
            @endif
            @if ($tfoot)
                <tfoot {{ $tfoot->attributes->class([]) }}>
                    {{ $tfoot }}
                </tfoot>
            @endif
        @else
            {{ $slot }}
        @endif
    </table>
</div>
