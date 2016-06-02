<ul class="c-navigation__list">
    @if(isset($list['items']))
        @each( isset($list['item']) ? $list['item'] : 'navigation.navigation-item', $list['items'], 'item')
    @endif

    @if(isset($list['add']))
        @include('navigation.navigation-add-item', ['item' => $list['add']])
    @endif
</ul>
