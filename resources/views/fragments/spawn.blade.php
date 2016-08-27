<form action="{{url('/fragments')}}" method="post" data-spawn-form>
    {{ csrf_field() }}
    @include('forms.hidden',['name' => 'parentType', 'value' => $parentType])
    @include('forms.hidden',['name' => 'parentId', 'value' => $parentId])
    @include('forms.hidden', ['name'  => 'type', 'value' => $spawn['type']])
    @include('forms.hidden', ['name'  => 'classes','value' => isset($spawn['meta']['classes']) ? $spawn['meta']['classes'] : ''])
    <button data-ajax-form-submit class="o-button o-fragment__spawn">{{$label}}</button>
</form>
