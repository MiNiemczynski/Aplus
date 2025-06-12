<a class="text-decoration-none content-link clickable" data-url="{{ $url }}">
    <div class="mx-2 my-3 d-flex flex-column justify-content-center align-items-center {{ $colorClass }} text-white"
        style="width: 12rem; height: 10rem;">
        <h4 class="mx-auto text-center">{{ $title }}</h4>
        @if(isset($description) && !empty($description))
            <h5 class="mx-auto">{{ $description }}</h5>
        @endif
    </div>
</a>