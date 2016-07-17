<?php
if(!in_array($item->get('type'), ['image','section','text','collection','input'])){
    $custom_class = 'c-fragment--custom';
}
// get columns
$meta = $item->get('meta');
if(isset($meta['columns']) && isset($meta['columns']['md'])){
    $md = $meta['columns']['md'];
}
?>
<div class="{{$sortable_class or ''}} o-fragment o-fragment--{{$item->get('type')}} o-grid__column o-grid__user-column--md-{{$md or '12'}}of{{config('user.grid-md')}} {{$custom_class or ''}}" data-id="{{$item->get('id')}}">

    {{-- Handle for sortable --}}
    @if(isset($sortable_class) && $sortable_class !== NULL)
        <div class="{{$sortable_class}}-handle c-sortable-fragment__handle"></div>
    @endif

    {{-- Settings Icon --}}
    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$item->get('id')}}" data-dialog-link="/dialog/fragmentSettings?id={{$item->get('id')}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>

    {{-- Fragment content --}}
    @if (in_array($item->get('type'), ['image','section','text','collection','input']))
        @include('fragments.'.$item->get('type'), [
            'fragment' => $item
        ])
    @else
        @include('fragments.custom', ['fragment' => $item])
    @endif

</div>
