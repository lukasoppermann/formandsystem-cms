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
            @include('forms.hidden',['name' => 'id', 'value' => $page->id])

            <div class="o-grid">
                <div class="o-grid__column">
                    @include('forms.input',['name' =>'menu_label', 'label' => 'Navigation Title', 'value' => $page->label])
                    @include('forms.input',['name' =>'slug', 'label' => 'Path/Slug', 'value' => $page->slug])
                </div>
                <div class="o-grid__column">
                    @include('forms.input',['name' =>'title', 'label' => 'Meta Title', 'value' => $page->title])
                    @include('forms.textarea',['name' =>'description', 'label' => 'Meta Description', 'value' => $page->description])
                </div>
            </div>

            <div class="o-flex">
                @include('forms.submit',['label' => 'Save', 'classes' => 'o-flex__item--align-right'])
            </div>

        </form>
    </div>
</section>
