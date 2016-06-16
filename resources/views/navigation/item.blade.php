<li class="c-navigation__item{{ isset($slug) && $slug === $active_item ? ' is-active' : '' }}">

    <a class="c-navigation__link{{ isset($icon) ? ' c-navigation__link--with-icon' : '' }}" {{$attr or ''}}>
        @if(isset($icon))
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
              <use xlink:href="#svg-icon--{{$icon}}"></use>
            </svg>
        @endif
        {{$label}}
    </a>
</li>
