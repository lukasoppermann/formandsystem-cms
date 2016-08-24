@if(!$fragment->images()->isEmpty())
    <form action="/images/{{$fragment->images()->first()->get('id')}}" method="POST" enctype="multipart/form-data" class="o-fragment__image-delete">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        @include('forms.hidden',['name' => 'fragment', 'value' => $fragment->get('id')])
        @include('forms.submit',['label' => 'Delete', 'classes' => 'c-fragment__image-delete-button o-button o-button--red o-flex__item--align-center'])
        <img class="o-fragment__image" src="{{trim(config('site_url'),'/').'/'.trim(config('img_dir'),'/').'/'.$fragment->images()->first()->get('link')}}" alt="{{$fragment->images()->first()->get('title')}}" />
    </form>
@else
    <form action="{{url('/images')}}" method="POST" enctype="multipart/form-data" class="o-fragment__image-upload" data-fragment-form={{$fragment->get("id")}}>
        {{ csrf_field() }}
        {{ method_field('POST') }}
        @include('forms.hidden',['name' => 'fragment', 'value' => $fragment->get('id')])
        @include('forms.file', ['name' => 'file', 'label' => 'Upload image', 'classes' => 'c-fragment-new__selection c-fragment-new__image', 'attr' => 'data-image-onchange="'.$fragment->get("id").'"'])
    </form>
@endif
