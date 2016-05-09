<li class="c-navigation__item{{ isset($item['is_active']) && $item['is_active'] === true ? ' is-active' : '' }}">
    <a class="c-navigation__link{{ isset($item['icon']) ? ' c-navigation__link--with-icon' : '' }}" href="{{url($item['link'])}}">
        @if(isset($item['icon']))
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
              <use xlink:href="#svg-icon--{{$item['icon']}}"></use>
            </svg>
        @endif
        {{$item['label']}}
    </a>
</li>
