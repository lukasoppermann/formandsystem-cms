@extends('layouts.app')

@section('content')
<div class="o-content o-content--max-width">
    <h2 class="o-headline o-headline--first">General site settings</h2>

        <form class="o-form" action="/settings/site" method="POST">
            {{ csrf_field() }}
            <section class="o-section o-section--no-top-padding o-section--no-bottom-padding">
                @include('forms.input',[
                    'name' => 'site_name',
                    'label' => 'Name of your site',
                    'value' => (isset($form['site_name']) ? $form['site_name']->data : NULL), 'additional_values' => [
                        'id' => (isset($form['site_name']) ? $form['site_name']->id : NULL)
                ]])
            </section>
            <section class="o-section">
                <h3 class="o-headline o-headline--second">Google Analytics</h3>
                @include('forms.input',[
                    'name' => 'analytics_code',
                    'label' => 'Your Google analytics code UA-XXXXXXX-XX',
                    'value' => (isset($form['analytics_code']) ? $form['analytics_code']->data : NULL), 'additional_values' => [
                        'id' => (isset($form['analytics_code']) ? $form['analytics_code']->id : NULL)
                ]])
                @include('forms.toggle',[
                    'name' => 'analytics_anonymize_ip',
                    'label' => 'Anonymize IP',
                    'value' => (isset($form['analytics_anonymize_ip']) ? $form['analytics_anonymize_ip']->data : NULL),
                    'additional_values' => [
                        'id' => (isset($form['analytics_anonymize_ip']) ? $form['analytics_anonymize_ip']->id : NULL)
                ]])

                <div class="o-flex">
                    @include('forms.submit',['label' => 'Save', 'classes' => 'o-flex__item--align-right'])
                </div>
            </section>
        </form>
    </section>
</div>
@endsection
