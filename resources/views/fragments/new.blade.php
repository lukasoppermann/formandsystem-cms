<?php
    if(isset($fragment_id)){
        $param = "?fragment=".$fragment_id;
    }
?>
<div class="o-dialog o-dialog--absolute is-hidden" data-target="fragment-new">
    <div class="o-dialog__box c-fragment-settings-dialog">
        <div class="o-dialog__body o-grid">
            <a href="/fragments/section{{$param}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Section</a>
            <a href="/fragments/text{{$param}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Text</a>
            <a href="/fragments/image{{$param}}" class="c-fragment-new__selection o-grid__column o-grid__column--md-4of12">Image</a>
        </div>
    </div>
    <div class="o-dialog__bg" data-toggle-dialog="fragment-new"></div>
</div>

<div class="o-fragment c-fragment-new c-fragment-new-section o-grid__column o-grid__column--md-{{config('user.grid-md')}}of{{config('user.grid-md')}}" data-toggle-dialog="fragment-new">
    Create a new fragment
</div>
