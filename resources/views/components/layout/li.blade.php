@props(['class', 'title', 'path'])

<li class="{{ $class }}"><a href="/{{ $path }}">
        @if (isset($slot))
            {{ $slot }}
        @endif {{ $title }}
    </a>
</li>
