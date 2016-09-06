<a class="o-media o-media--center o-menu__link {{$class or ''}}" {{$attr or ''}} href="{{ url('/logout') }}"
    onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
    @if(isset($icon))
        {{ svg_icon($icon, 'o-icon--'.$icon.' o-media__figure')->inline() }}
    @endif
    <span class="o-media__body">
        {{$label or ''}}
    </span>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</a>
