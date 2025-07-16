<h4 class="mx-2">{{ $title ?? "" }}</h4>
<div class="row aplus-bg-light-gray border border-end-0 overflow-auto m-2 p-2">
    @if(!empty($cards))
        @foreach ($cards as $card)
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                <x-card :title="$card->title" :description="$card->description" :url="$card->url" :id="$card->id"/>
            </div>
        @endforeach
    @else
        <p class="aplus-text-dark-red">No items to show</p>
    @endif
</div>