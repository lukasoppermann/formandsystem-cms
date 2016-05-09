<nav class="c-navigation">
    @include('navigation.navigation-header', $navigation['header'])
    @each('navigation.navigation-list', $navigation['lists'], 'list')
</nav>
