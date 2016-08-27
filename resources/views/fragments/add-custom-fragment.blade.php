
<div class="o-fragment c-fragment--custom-add o-grid__column o-grid__user-column--md-{{(config('user.grid-md')/2)}}of{{config('user.grid-md')}}">

    <form action="/fragments" method="post">
        {{ csrf_field() }}
        @include('forms.hidden',['name' => 'type', 'value' => $type])
        @include('forms.hidden',['name' => 'parentType', 'value' => 'collection'])
        @include('forms.hidden',['name' => 'parentId', 'value' => $collection->get('id')])

        <button type="submit" class="o-button o-button--squared o-button--icon">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--sm">
                <use xlink:href="#svg-icon--plus"></use>
            </svg>
            Add item
        </button>
    </form>

</div>
