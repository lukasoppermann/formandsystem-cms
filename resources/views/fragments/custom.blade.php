<?php
    $available_types = ['image','markdown','input','text','collection'];
?>
@foreach ($fragment->get('elements') as $name => $section)
    @if(in_array($section['type'], $available_types))
        @include('fragments.'.$section['type'], [
            'fragment'      => $item,
            'name'          => $name,
            'collection'    => $item->ownedByCollections->first(),
            'collections'   => $collections,
            'validation'    => $section['validation'],
            'classes'       => $section['classes'],
        ])
    @endif
@endforeach
