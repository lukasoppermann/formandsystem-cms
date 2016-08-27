<!-- include sub-fragments -->
<div class="o-user-grid js-sortable-fragments" data-patch-url="{{url('/fragments').'/'}}">
    @if($sortable_class !== NULL)
        <div class="{{$sortable_class}}-handle c-sortable-fragment__handle"></div>
    @endif

    @if($item->fragments() !== NULL)
        @foreach($item->fragments()->sortBy('position') as $subfragment)
            @include('fragments.fragment', [
                'item' => $subfragment,
                'sortable_class' => 'js-sortable-fragment-item',
            ])
        @endforeach
    @endif

    @include('fragments.new', ['fragment_id' => $item->get('id')])
</div>
