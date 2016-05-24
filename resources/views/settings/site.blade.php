@extends('layouts.app')

@section('content')
<div class="o-content o-content--max-width">
    <section class="o-section">
        <h3 class="o-headline o-headline--second">General site settings</h3>

        <form class="o-form" action="/settings/site" method="POST">
            {{ csrf_field() }}
            @include('forms.input',['name' => 'site_name', 'label' => 'Name of your site'])
            <div class="o-flex">
                @include('forms.submit',['label' => 'Save', 'classes' => 'o-flex__item--align-right'])
            </div>
        </form>
    </section>
</div>
@endsection
