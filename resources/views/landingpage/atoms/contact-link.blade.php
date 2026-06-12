@props([
    'href',
    'label',
    'prefix' => null,
])

<li>
    @if ($prefix)
        {{ $prefix }}:
    @endif
    <a href="{{ $href }}">{{ $label }}</a>
</li>
