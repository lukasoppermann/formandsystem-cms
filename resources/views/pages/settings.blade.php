<?php
    $item = isset($page) ? $page : $item;
?>
<div class="c-settings-panel__toggle" data-toggle="settings-panel">
    <svg viewBox="0 0 512 512" class="o-icon">
      <use xlink:href="#svg-icon--settings"></use>
    </svg>
</div>
<section class="c-settings-panel" data-target="settings-panel">

    <div class="o-content">

        <h4 class="o-headline o-headline--second">Page Settings</h4>
        <form class="o-form" action="/pages" method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('forms.hidden',['name' => 'id', 'value' => $item->get('id')])
            @include('forms.hidden',['name' => 'collection', 'value' => $collection->get('id')])

            <div class="o-grid">
                <div class="o-grid__column o-grid__column--md-6of12">
                    @include('forms.input',['name' =>'menu_label', 'label' => 'Navigation Title', 'value' => $item->get('label')])
                    @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'value' => $item->get('slug')])
                </div>
                <div class="o-grid__column o-grid__column--md-6of12">
                    @include('forms.input',['name' =>'title', 'label' => 'Meta Title', 'value' => $item->get('title'), 'attr' => 'required'])
                    @include('forms.textarea',['name' =>'description', 'label' => 'Meta Description', 'value' => $item->get('description'), 'attr' => 'required'])
                </div>
            </div>

            <div class="o-flex">
                @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex__item--align-right'])
            </div>

        </form>
    </div>
</section>
