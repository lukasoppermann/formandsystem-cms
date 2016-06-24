<form action="/fragments/{{$fragment->id}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <textarea class="mark" name="data" data-toggle-if-filled="save-button-{{$fragment->id}}" placeholder="{{$label or $fragment->name}}">{{$fragment->data}}</textarea>
    <div class="o-flex" data-target="save-button-{{$fragment->id}}">
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue  o-flex__item--align-right'])
    </div>
</form>
