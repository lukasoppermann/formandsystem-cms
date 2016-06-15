<li class="c-navigation__item{{ '/collections/'.$item['slug'] === $active_item ? ' is-active' : '' }}">

    {{-- Edit button --}}
    @if(isset($item['id']))
        <button class="o-button-none c-navigation__delete" data-open-dialog="edit-collection" data-link="/dialog/editCollection?id={{$item['id']}}">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white o-icon--small">
              <use xlink:href="#svg-icon--edit"></use>
            </svg>
        </button>
    @endif
    {{-- END Edit button --}}

    <a class="c-navigation__link c-navigation__link--with-icon" href="{{url('collections/'.$item['slug'])}}">
        <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
          <use xlink:href="#svg-icon--collection"></use>
        </svg>
        {{$item['name']}}
    </a>
</li>
