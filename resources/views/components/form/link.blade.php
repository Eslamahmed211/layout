@props(['title', 'icon', 'path', 'target'])

@isset($icon)
    @php
        $icon = match ($icon) {
            'plus'
                => '<svg width="16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
</svg>',
            'excel'
                => '<svg width="18px" style="margin-left: 10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z" clip-rule="evenodd"></path></svg>',
        };
    @endphp
@endisset

<a {{ $attributes->merge() }} target="{{ $target ?? '_self' }}" href="/{{ $path }}">
    <div>
        <button type="button" {{ $attributes->merge() }} class="default"> {!! $icon ?? '' !!} {{ $title }}
        </button>
    </div>
</a>
