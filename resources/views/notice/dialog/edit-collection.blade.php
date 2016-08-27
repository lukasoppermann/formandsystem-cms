<h4 class="o-headline o-headline--second">Collection Settings</h4>
<form class="o-form" action="/collections/{{$id}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    @include('forms.input',['name' =>'name', 'label' => 'Collection Name', 'value' => $name, 'attr' => 'required'])

    @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'value' => $slug, 'attr' => 'required'])

    <div class="o-flex-bar">
        <a class="o-button o-button--link o-button--link--red o-flex-bar__item" href="/collections/delete/{{$id}}">Delete</a>
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item o-flex-bar__item--right'])
    </div>
</form>
