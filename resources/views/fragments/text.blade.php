<form action="/fragments/{{$fragment->get('id')}}" method="POST" class="u-show-on-fragment-hover-parent">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    @if(!isset($fragment->get('meta')['autosave']) || $fragment->get('meta')['autosave'] !== true)
        <textarea class="mark" name="data"
            data-toggle-if-filled="save-button-{{$fragment->get('id')}}"
            placeholder="{{$label or $fragment->get('name')}}">{{$fragment->get('data')}}</textarea>
        <div class="o-flex u-show-on-fragment-hover-item" data-target="save-button-{{$fragment->get('id')}}">
            @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex__item--align-right'])
        </div>
    @else
        <div class="o-textarea">
            <textarea name="data" class="o-textarea_textarea"
                placeholder="{{$label or $fragment->get('name')}}"
                data-autosubmit-form="3000"
                data-patch-url="{{url('/fragments/'.$fragment->get('id'))}}">{{$fragment->get('data')}}</textarea>
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
    @endif
</form>
