<a class="o-media o-media--center o-menu__link {{$class or ''}}" {{$attr or ''}} href="{{$prefix or ''}}{{$url or ''}}">
    @if(isset($icon) && !isset($inline_icon))
        {{ svg_icon($icon, 'o-icon--'.$icon.' o-media__figure')->viewbox("0 0 512 512") }}
    @elseif(isset($icon) && $inline_icon === true)
        {{ svg_icon($icon, 'o-icon--'.$icon.' o-media__figure')->inline() }}
    @endif
    <span class="o-media__body">
        {{$label or ''}}
    </span>
</a>
