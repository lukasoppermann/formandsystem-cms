<!-- include sub-fragments -->
<div class="o-user-grid">
    @if($item->fragments() !== NULL)
        @foreach($item->fragments() as $subfragment)
            @include('fragments.fragment', ['item' => $subfragment])
        @endforeach
    @endif

    @include('fragments.new', ['fragment_id' => $item->get('id')])
</div>
