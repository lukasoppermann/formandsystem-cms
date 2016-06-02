
<div class="o-dialog o-dialog--absolute is-hidden" data-target="fragment-new-{{$fragment_id}}">
    <div class="o-dialog__box c-fragment-settings-dialog">
        <div class="o-dialog__body o-grid">
            <a href="/fragments/section?fragment={{$fragment_id}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Section</a>
            <a href="/fragments/text?fragment={{$fragment_id}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Text</a>
            <a href="/fragments/image?fragment={{$fragment_id}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Image</a>
        </div>
    </div>
    <div class="o-dialog__bg" data-toggle-dialog="fragment-new-{{$fragment_id}}"></div>
</div>

<div class="o-fragment c-fragment-new c-fragment-new-section o-grid__column o-grid__column--md-{{config('user.grid-md')}}of{{config('user.grid-md')}}" data-toggle-dialog="fragment-new-{{$fragment_id}}">
    Create a new fragment
</div>
