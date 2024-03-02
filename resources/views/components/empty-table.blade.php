@props(['colspan' => null])

@php
    $attributes = $attributes->class([])->merge([
        'colspan' => $colspan,
    ]);
@endphp

<tr>
    <td {{ $attributes }}>{{ $slot }}</td>
</tr>
