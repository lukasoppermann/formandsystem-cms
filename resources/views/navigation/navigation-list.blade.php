<ul class="c-navigation__list">
    @each( isset($list['item']) ? $list['item'] : 'navigation.navigation-item', $list['items'], 'item')

    @if(isset($list['add']))
        @include('navigation.navigation-add-item', ['item' => $list['add']])
    @endif
</ul>
