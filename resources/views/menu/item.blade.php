<a class="o-menu__link c-navigation__link{{ $item->get('icon') ? ' c-navigation__link--with-icon' : '' }}" {{$attr or ''}} href="{{$item->get('prefix').$item->get('link')}}">
    @if(isset($item['icon']))
        <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon--{{$item->get('icon')}}"></use>
        </svg>
    @endif
    {{$item->get('label')}}
</a>
