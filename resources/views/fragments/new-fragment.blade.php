<form class="{{$classes or ''}}" action="/fragments" method="post">
    {{ csrf_field() }}
    @include('forms.hidden',['name' => 'type', 'value' => $type])
    @include('forms.hidden',['name' => 'parentType', 'value' => $related])
    @include('forms.hidden',['name' => 'parentId', 'value' => $related_id])
    @include('forms.submit',['label' => $label, 'classes' => "o-fragment c-fragment-new o-button-none".(isset($button_classes) ? ' '.$button_classes : '')])
</form>
