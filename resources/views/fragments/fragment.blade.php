<?php
if(!in_array($item->get('type'), ['image','section','text','collection','input'])){
    $custom_class = 'c-fragment--custom';
}
?>
<div class="o-fragment o-fragment--{{$item->get('type')}} o-grid__column o-grid__user-column--md-{{$item->metadetails()->get('columns_medium', '12')}}of{{config('user.grid-md')}} {{$custom_class or ''}}">

    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$item->get('id')}}" data-dialog-link="/dialog/fragmentSettings?id={{$item->get('id')}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>

    @if (in_array($item->get('type'), ['image','section','text','collection','input']))
        @include('fragments.'.$item->get('type'), ['fragment' => $item])
    @else
        @include('fragments.custom', ['fragment' => $item])
    @endif



</div>
