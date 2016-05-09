<header class="c-navigation__header">
    <div class="c-navigation__icon">
        @if(!isset($link) || $link === NULL)
            <svg viewBox="0 0 512 512" class="o-icon">
              <use xlink:href="#svg-icon--formandsystem"></use>
            </svg>
        @else
            <a href="{{$link}}" class="o-link o-link--full">
                <svg viewBox="0 0 512 512" class="o-icon">
                  <use xlink:href="#svg-icon--arrow-back"></use>
                </svg>
            </a>
        @endif
    </div>
    <h1 class="c-navigation__title">{{$title}}</h1>
</header>
