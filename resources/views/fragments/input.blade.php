<form action="/fragments/{{$fragment->get('id')}}" method="POST" class="o-flex-bar o-flex-bar--middle">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="o-input {{$classes or ''}} o-flex-bar__item o-flex-bar__item--fill">
        <input class="o-input__input {{$fragment->get('data') == NULL ? ' is-empty' : ''}}" name="data" value="{{$fragment->get('data')}}" type="text" data-check-empty>
        <span class="o-input__bar"></span>
        <label class="o-input__label">{{$label or $fragment->get('name')}}</label>
    </div>
    @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item'])
</form>
