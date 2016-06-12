<li class="c-navigation__item{{ $item['link'] === $active_item ? ' is-active' : '' }}">
    @if(isset($item['deletable']) && isset($item['id']))
        <form action="{{$action or ''}}" method="post">
            @include('forms.hidden', ['name' => 'id', 'value' => $item['id']])
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="c-navigation__delete">
                <svg viewBox="0 0 512 512" class="o-icon o-icon--white o-icon--small">
                  <use xlink:href="#svg-icon--trash"></use>
                </svg>
            </button>
        </form>
    @endif

    <a class="c-navigation__link{{ isset($item['icon']) ? ' c-navigation__link--with-icon' : '' }}" href="{{url($item['link'])}}">
        @if(isset($item['icon']))
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
              <use xlink:href="#svg-icon--{{$item['icon']}}"></use>
            </svg>
        @endif
        {{$item['label']}}
    </a>
</li>
