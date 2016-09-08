<form action="{{url('/images')}}" method="POST" enctype="multipart/form-data" class="o-fragment__image-upload {{$fragment->images()->isEmpty() ? 'is-empty' : ''}}" data-fragment-form={{$fragment->get("id")}}>
    {{ csrf_field() }}
    @include('forms.hidden',['name' => 'fragment', 'value' => $fragment->get('id')])
    <div class="c-fragment__image-delete-button o-button o-button--red o-flex__item--align-center" data-parent-form="{{$fragment->get('id')}}">Delete</div>
    @include('forms.file', ['name' => 'file', 'label' => 'Upload image', 'classes' => 'c-fragment-new__selection c-fragment-new__image', 'attr' => 'data-image-onchange="'.$fragment->get("id").'"'])
    <?php
        if(!$fragment->images()->isEmpty()){
            $img_id         = $fragment->images()->first()->get('id');
            $img_filename   = $fragment->images()->first()->get('filename');
            $img_title      = $fragment->images()->first()->get('title');
        }
    ?>
    @if(isset($img_filename))
        <img class="o-fragment__image"
            data-image-id="{{$img_id or ''}}"
            data-base-url="{{trim(config('site_url'),'/').'/'.trim(config('img_dir'),'/').'/'}}"
            src="{{trim(config('site_url'),'/').'/'.trim(config('img_dir'),'/').'/'}}{{$img_filename or ''}}"
            alt="{{$img_title or ''}}" />
    @endif
</form>
