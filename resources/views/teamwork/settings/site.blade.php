@extends('layouts.app')

@section('content')
    @include('teamwork.settings.menu')

    <form class="o-form" action="/settings/site" method="POST" style="width: 300px;">
        {{ csrf_field() }}
        <section class="o-section o-section--no-top-padding o-section--no-bottom-padding">
            @include('forms.input',[
                'name' => 'site_name',
                'label' => 'Name of your site',
                'value' => (isset($form['site_name']) ? $form['site_name']->get('data') : NULL),
                'additional_values' => [
                    'id' => (isset($form['site_name']) ? $form['site_name']->get('id') : NULL)
                ]
            ])
            @include('forms.input',[
                'name' => 'site_url',
                'label' => 'URL of your site',
                'value' => (isset($form['site_url']) ? $form['site_url']->get('data') : NULL),
                'additional_values' => [
                    'id' => (isset($form['site_url']) ? $form['site_url']->get('id') : NULL)
                ]
            ])
            @include('forms.input',[
                'name' => 'dir_images',
                'label' => 'Public directory where your images are stored',
                'value' => (isset($form['dir_images']) ? $form['dir_images']->get('data') : NULL),
                'additional_values' => [
                    'id' => (isset($form['dir_images']) ? $form['dir_images']->get('id') : NULL)
                ]
            ])
            <div class="o-flex-bar">
                @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item o-flex-bar__item--right'])
            </div>
        </section>
    </form>

@endsection
