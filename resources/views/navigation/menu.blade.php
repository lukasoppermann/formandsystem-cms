<nav class="c-navigation">
    @if( config('app.user')->account()->isSetup() )
        @if(is_array($navigation['header']))
            @include('navigation.navigation-header', $navigation['header'])
        @else
            {!!$navigation['header']!!}
        @endif

        @if(is_array($navigation['lists']))
            @each('navigation.navigation-list', $navigation['lists'], 'list')
        @endif

        @include('navigation.navigation-footer')
    @else
        @include('navigation.navigation-header', [
            'title' => 'Form&System',
        ])
    @endif
</nav>
