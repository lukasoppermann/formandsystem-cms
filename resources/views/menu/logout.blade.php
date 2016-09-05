<a class="o-media o-media--center o-menu__link {{$item->get('class')}}" {!!$item->get('attr')!!} href="{{ url('/logout') }}"
    onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
    @if(isset($item['icon']))
        {{ svg_icon($item->get('icon'), 'o-icon--'.$item->get('icon').' o-media__figure')->inline() }}
    @endif
    <span class="o-media__body">
        {{$item->get('label')}}
    </span>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</a>
