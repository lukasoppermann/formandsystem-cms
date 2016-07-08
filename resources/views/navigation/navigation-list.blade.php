<ul class="{!! isset($list['patch_url']) ? 'js-sortable' : '' !!} c-navigation__list {{$list['classes'] or ''}}" data-collection-id="{{$list['collection_id'] or ''}}" {!! isset($list['patch_url']) ? 'data-patch-url="'.trim(url($list['patch_url']),'/').'/'.'"' : ''!!}>
    @foreach($list as $type => $items)
        @if($type === 'title')
            @include('navigation.navigation-title', ['title' => $items])
        @endif
        @if($type === 'items')
            @each( isset($list['template']) ? $list['template'] : 'navigation.navigation-item', $items, 'item')
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
