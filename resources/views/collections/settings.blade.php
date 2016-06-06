<div class="o-dialog o-dialog--absolute is-hidden" data-target="collection-settings">
    <div class="o-dialog__box c-fragment-settings-dialog">
        <div class="o-dialog__body">

            <h4 class="o-headline o-headline--second">Collection Settings</h4>
            <form class="o-form" action="/collections/{{$collection->id}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                @include('forms.input',['name' =>'name', 'label' => 'Collection Name', 'value' => $collection->name])

                @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'value' => $collection->slug])

                <div class="o-grid">
                    <a class="o-grid__column o-button o-button--link o-button--link--red o-flex__item--auto" href="/collections/delete/{{$collection->id}}">Delete</a>
                    @include('forms.submit',['label' => 'Save', 'classes' => 'o-grid__column o-flex__item--align-right o-flex__item--auto'])
                </div>

            </form>

        </div>
    </div>
    <div class="o-dialog__bg" data-toggle-dialog="collection-settings"></div>
</div>
