<form class="o-grid__column o-grid__column--md-12of12" action="/fragments" method="post">
    {{ csrf_field() }}
    @include('forms.hidden',['name' => 'type', 'value' => 'section'])
    @include('forms.hidden',['name' => 'parentType', 'value' => 'page'])
    @include('forms.hidden',['name' => 'parentId', 'value' => $page_id])
    @include('forms.submit',['label' => 'Create a new Section', 'classes' => "o-fragment c-fragment-new o-button-none"])
</form>
