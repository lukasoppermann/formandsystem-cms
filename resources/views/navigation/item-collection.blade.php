<li class="c-navigation__item{{ '/collections/'.$item['slug'] === $active_item ? ' is-active' : '' }}">
    <a class="c-navigation__link c-navigation__link--with-icon" href="{{url('collections/'.$item['slug'])}}">
        <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
          <use xlink:href="#svg-icon--collection"></use>
        </svg>
        {{$item['name']}}
    </a>
</li>
