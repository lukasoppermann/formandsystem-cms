<a class="o-menu__link test {{ $item->get('icon') ? ' c-navigation__link--with-icon' : '' }}" {{$attr or ''}} href="{{$item->get('prefix').$item->get('link')}}">
    @if(isset($item['icon']))
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--{{$item->get('icon')}}"></use>
        </svg>

    @endif
    {{$item->get('label')}}
</a>
