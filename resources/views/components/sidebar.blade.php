<div class="col-3 aplus-bg-dark-teal text-white p-3 d-flex flex-column sticky-top">
    <ul class="nav flex-column">
        @foreach ($sidebarButtons as $button)
            <x-sidebar-button :text="$button['text']" :url="$button['url']" :icon="$button['icon']" />
        @endforeach
    </ul>
</div>