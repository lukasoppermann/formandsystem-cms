<ul class="c-navigation__list">
    @foreach($list as $type => $items)
        @if($type === 'title')
            @include('navigation.navigation-title', ['title' => $items])
        @endif
        @if($type === 'items')
            @each( isset($list['item']) ? $list['item'] : 'navigation.navigation-item', $items, 'item')
        @endif
        <!-- Add elements -->
        @if($type === 'elements')
            @foreach($items as $element)
                {!! $element !!}
            @endforeach
        @endif
    @endforeach

    @if(isset($list['add']))
        @include('navigation.navigation-add-item', ['item' => $list['add']])
    @endif
</ul>
