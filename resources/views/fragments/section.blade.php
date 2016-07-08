<!-- include sub-fragments -->
<div class="o-user-grid">
    @if($sortable_class !== NULL)
        <div class="js-sortable-handle c-sortable-fragment__handle"></div>
    @endif

    @if($item->fragments() !== NULL)
        @foreach($item->fragments() as $subfragment)
            @include('fragments.fragment', [
                'item' => $subfragment,
                'sortable_class' => NULL
            ])
        @endforeach
    @endif

    @include('fragments.new', ['fragment_id' => $item->get('id')])
</div>
