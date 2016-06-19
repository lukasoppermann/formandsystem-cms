<h4 class="o-headline o-headline--second">New Collection</h4>
<form class="o-form" action="/collections" method="POST" name="newCollection">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <div class="o-grid">
        @include('forms.input',['name' =>'name', 'label' => 'Collection Name', 'attr' => 'required', 'classes' => 'o-grid__column o-grid__column--md-6of12'])

        @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'attr' => 'required', 'classes' => 'o-grid__column o-grid__column--md-6of12'])
    </div>
    <h4 class="o-headline o-headline--third">Select the content type for your collection</h4>

        @include('forms.radio-group', [
            'name' => 'type',
            'classes' => 'o-button o-button--squared o-grid__column o-grid__column--md-6of12',
            'values' =>
            [
                'pages' => 'Pages',
                'news'  => 'News',
            ],
        ])
        @include('forms.submit', ['label' => 'submit', 'classes' => 'is-hidden'])
    </div>
</form>
