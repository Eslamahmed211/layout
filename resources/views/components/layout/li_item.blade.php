@props(['class', 'title', 'paths'])

<li data-title="{{ $title }}" class="{{ $class }} has-items" id="flip-products">
    
    <a href="#">
        {{ $slot }}
        {{ $title }}
        <i class="fa-solid fa-sort-down flip-orders-icon mx-2"></i>
    </a>

    <div class="sub_items" id="panel-products">

        @foreach ($paths as $path)

            <div class="{{ $path['class'] }} d-flex"><a href="/{{ $path['path'] }}">  <x-icons.sub></x-icons.sub> {{ $path['title'] }} </a>

            </div>
        @endforeach
    </div>
    
</li>


