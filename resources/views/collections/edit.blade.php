<h4 class="o-headline o-headline--second">Collection Settings</h4>
<form class="o-form" action="/collections/{{$id}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    @include('forms.input',['name' =>'name', 'label' => 'Collection Name', 'value' => $name])

    @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'value' => $slug])

    <div class="o-grid">
        <a class="o-grid__column o-button o-button--link o-button--link--red o-flex__item--auto" href="/collections/delete/{{$id}}">Delete</a>
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue  o-grid__column o-flex__item--align-right o-flex__item--auto'])
    </div>
</form>
