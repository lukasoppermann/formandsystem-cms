<li class="c-navigation__item">
    <form action="{{$action or ''}}" method="post">
        {{ csrf_field() }}
        @if(isset($method))
            {{ method_field($method) }}
        @endif

        @if(isset($fields))
            @foreach($fields as $name => $value)
                @include('forms.hidden', ['name' => $name, 'value' => $value])
            @endforeach
        @endif

        <button type="submit" class="c-navigation__link c-navigation__link--with-icon">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--white c-icon--{{$icon or 'plus'}}">
              <use xlink:href="#svg-icon--{{$icon or 'plus'}}"></use>
            </svg>
            {{$label or 'Add item'}}
        </button>

    </form>
</li>
