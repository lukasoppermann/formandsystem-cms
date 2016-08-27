<nav class="c-navigation">
    {!! Menu::main() !!}

    {{-- FOOTER --}}
    <div class="c-navigation__footer">
        <form action="/settings/developers/bust-cache" method="post">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <button type="submit" class="c-navigation__item">
                <div class="c-navigation__link">Refresh cache</div>
            </button>
        </form>
        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

    {{-- @if( config('app.user')->account()->isSetup() )
        @if(is_array($navigation['header']))
            @include('navigation.navigation-header', $navigation['header'])
        @else
            {!!$navigation['header']!!}
        @endif

        @if(is_array($navigation['lists']))
            <div class="c-navigation__body">
                @each('navigation.navigation-list', $navigation['lists'], 'list')
            </div>
        @endif

        @include('navigation.navigation-footer')
    @else
        @include('navigation.navigation-header', [
            'title' => 'Form&System',
        ])
    @endif --}}
</nav>
