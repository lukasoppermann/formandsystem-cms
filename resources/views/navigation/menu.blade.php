<nav class="c-navigation">
    @if(is_array($navigation['header']))
        @include('navigation.navigation-header', $navigation['header'])
    @else
        {!!$navigation['header']!!}
    @endif

    @if(is_array($navigation['lists']))
        @each('navigation.navigation-list', $navigation['lists'], 'list')
    @endif
</nav>
