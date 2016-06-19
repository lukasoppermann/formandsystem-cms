<?php
    $available_types = ['image','markdown','input','text'];
?>
@foreach ($fragment->get('elements') as $name => $section)
    @if(in_array($section['type'], $available_types))
        @include('fragments.'.$section['type'], [
            'fragment'      => $item,
            'name'          => $name,
            'validation'    => $section['validation'],
            'classes'       => $section['classes'],
        ])
    @endif
@endforeach
