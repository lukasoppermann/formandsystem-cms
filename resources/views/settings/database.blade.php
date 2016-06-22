<section class="o-section">
    <h3 class="o-headline o-headline--second">Database settings</h3>
    <p class="o-copy o-content__paragraph">These settings are used to connect to your database to add and receive all data. The information is stored in a secure, encrypted manner. To change the database you need to delete the settings and add new ones.</p>

    <form class="o-form" action="/settings/developers/database" method="POST">
        {{ csrf_field() }}
        @if(!isset($database))
            @include('forms.input',['name' => 'connection_name', 'label' => 'Name your connection'])
            @include('forms.select',['name' => 'db_type', 'label' => 'Database type', 'values' => ['mysql' => 'MySQL'], 'selected' => 'MySQL'])
            @include('forms.input',['name' => 'host', 'label' => 'Database host e.g. 202.54.10.20'])
            @include('forms.input',['name' => 'database', 'label' => 'Database name'])
            @include('forms.input',['name' => 'db_user', 'label' => 'Database user name'])
            @include('forms.input',['name' => 'db_password', 'label' => 'Password for your database', 'type' => 'password'])
            <div class="o-flex">
                @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex__item--align-right'])
            </div>
        @else
            {{ method_field('DELETE') }}
            <div class="o-flex-bar">
                <p class="o-flex-bar__item o-flex-bar__item--fill"><span class="type--bold">Database connection: </span><span class="type--grey">{{substr($database,0,20)}}</span></p>
                @include('forms.submit',['label' => 'Delete database connection', 'classes' => 'o-button o-flex__item o-flex__item--fill o-button--red'])
            </div>
        @endif
    </form>
</section>
