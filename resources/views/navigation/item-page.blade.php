<li class="js-sortable-item c-navigation__item{{ '/collections/'.$item['collection'].'/'.$item['slug'] === $active_item ? ' is-active' : '' }}" data-id="{{$item['id']}}">
    <!-- Delete button -->
    @if(isset($item['id']))
        <form class="" action="/pages/{{$item['id']}}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="o-button-none c-navigation__delete">
                <svg viewBox="0 0 512 512" class="o-icon o-icon--white o-icon--small">
                  <use xlink:href="#svg-icon--trash"></use>
                </svg>
            </button>
        </form>
    @endif
    <!-- END Delete button -->
    <a class="c-navigation__link{{ isset($item['icon']) ? ' c-navigation__link--with-icon' : '' }}" href="{{url('/collections/'.$item['collection'].'/'.$item['slug'])}}">
        @if(isset($item['icon']))
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
              <use xlink:href="#svg-icon--{{$item['icon']}}"></use>
            </svg>
        @endif
        {{$item['menu_label']}}
    </a>
</li>
