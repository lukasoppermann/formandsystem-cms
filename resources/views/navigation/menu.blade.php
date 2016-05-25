<nav class="c-navigation">
    @include('navigation.navigation-header', $navigation['header'])
    @if(isset($navigation['lists']))
        @each('navigation.navigation-list', $navigation['lists'], 'list')
    @endif
</nav>
