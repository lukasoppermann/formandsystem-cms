<a class="o-media o-media--center o-menu__link {{$item->get('class')}}" {!!$item->get('attr')!!} href="{{$item->get('prefix').$item->get('link')}}">
    @if(isset($item['icon']) && $item->get('inline_icon') !== true)
        {{ svg_icon($item->get('icon'), 'o-icon--'.$item->get('icon').' o-media__figure')->viewbox("0 0 512 512") }}
    @elseif(isset($item['icon']) && $item->get('inline_icon') === true)
        {{ svg_icon($item->get('icon'), 'o-icon--'.$item->get('icon').' o-media__figure')->inline() }}
    @endif
    <span class="o-media__body">
        {{$item->get('label')}}
    </span>
</a>
