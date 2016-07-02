@if(!$fragment->images()->isEmpty())
    <img class="o-fragment__image" src="{{$fragment->images()->first()->get('link')}}" alt="{{$fragment->images()->first()->get('title')}}" />
@else
    <form action="/images" method="POST" enctype="multipart/form-data" class="o-fragment__image-upload">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        @include('forms.hidden',['name' => 'fragment', 'value' => $fragment->get('id')])
        @include('forms.file', ['name' => 'file', 'label' => 'Upload image', 'classes' => 'c-fragment-new__selection c-fragment-new__image', 'attr' => 'onchange=\'form.submit();\''])
    </form>
@endif
