<form action="/fragments/{{$fragment->get('id')}}" method="POST" class="o-flex-bar o-flex-bar--middle">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="o-input {{$classes or ''}} o-flex-bar__item o-flex-bar__item--fill">
        <input class="o-input__input {{$fragment->get('data') == NULL ? ' is-empty' : ''}}" name="data" value="{{$fragment->get('data')}}" type="text" data-check-empty data-autosubmit-form="3000" data-patch-url="{{url('/fragments/'.$fragment->get('id'))}}">
        <span class="o-input__bar"></span>
        <label class="o-input__label">{{$label or $fragment->get('name')}}</label>
        <div class="o-input__loading">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--blue o-icon--loading-circle">
              <use xlink:href="#svg-icon--loading-circle"></use>
            </svg>
        </div>
        <div class="o-input__success">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--green">
              <use xlink:href="#svg-icon--check"></use>
            </svg>
        </div>
        <div class="o-input__failed">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--red">
              <use xlink:href="#svg-icon--x"></use>
            </svg>
        </div>
    </div>
    {{-- @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item']) --}}
</form>
