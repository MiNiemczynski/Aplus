<h4 class="mx-2">{{ $title ?? "" }}</h4>
<div class="row aplus-bg-light-gray border border-end-0 overflow-auto m-2 p-2">
    <div class="d-flex flex-nowrap" style="min-width: max-content;">
        @if(!empty($cards))
            @foreach ($cards as $card)
                <x-card :title="$card['title']" :description="$card['description']" :url="$card['url']"/>
            @endforeach
        @else
            <p class="aplus-text-dark-red">No items to show</p>
        @endif
    </div>
</div>