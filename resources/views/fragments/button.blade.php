<form action="/fragments/{{$fragment->id}}" method="POST" class="o-form__section">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="o-input {{$classes or ''}}">
        <input class="o-input__input {{$fragment->data == NULL ? ' is-empty' : ''}}" name="data" value="{{$fragment->data}}" type="text" data-check-empty>
        <span class="o-input__bar"></span>
        <label class="o-input__label">Button Label</label>
    </div>
    <div class="o-input {{$classes or ''}}">
        <input class="o-input__input {{$fragment->data == NULL ? ' is-empty' : ''}}" name="data" value="{{$fragment->data}}" type="text" data-check-empty>
        <span class="o-input__bar"></span>
        <label class="o-input__label">Button Link</label>
    </div>

    <div class="o-flex-bar" data-target="save-button-{{$fragment->id}}">
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item--right'])
    </div>
</form>
