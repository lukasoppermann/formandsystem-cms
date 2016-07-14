<form action="/fragments/{{$fragment->get('id')}}" method="POST" class="u-show-on-fragment-hover-parent">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <textarea class="mark" name="data" data-toggle-if-filled="save-button-{{$fragment->get('id')}}" placeholder="{{$label or $fragment->get('name')}}">{{$fragment->get('data')}}</textarea>
    <div class="o-flex u-show-on-fragment-hover-item" data-target="save-button-{{$fragment->get('id')}}">
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex__item--align-right'])
    </div>
</form>
