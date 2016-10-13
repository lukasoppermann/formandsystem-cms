@extends('layouts.app')

@section('content')
    @include('teamwork.settings.menu')

    <div class="o-content o-content--max-width">
        <form class="o-form" action="/settings/site" method="POST">
            {{ csrf_field() }}
            <section class="o-section o-section--no-top-padding o-section--no-bottom-padding">
                @include('forms.input',[
                    'name' => 'project_name',
                    'label' => 'Name of your project',
                    'value' => (isset($form['project_name']) ? $form['project_name']->get('data') : NULL),
                    'additional_values' => [
                        'id' => (isset($form['project_name']) ? $form['project_name']->get('id') : NULL)
                    ]
                ])
                @include('forms.input',[
                    'name' => 'site_url',
                    'label' => 'URL of this website (needed to display images, etc.)',
                    'value' => (isset($form['site_url']) ? $form['site_url']->get('data') : NULL),
                    'additional_values' => [
                        'id' => (isset($form['site_url']) ? $form['site_url']->get('id') : NULL)
                    ]
                ])
                @include('forms.input',[
                    'name' => 'dir_images',
                    'label' => 'Public directory where your images are stored on your server',
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
    </div>

@endsection
