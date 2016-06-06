<?php
    $collection = isset($collection) ? $collection : NULL;

    $cols = [];
    $collections->each(function($item) use(&$cols, $collection){
        if($collection === NULL || $item->id !== $collection->id){
            $cols[$item->id] = $item->name;
        }
    });

    if(!$fragment->collections->isEmpty()){
        $collection_id = $fragment->collections->first()->id;
    }


?>
<form action="/fragments/{{$fragment->id}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    @include('forms.select', [
        'name' => 'collection',
        'label' => 'Select a collection',
        'values' => $cols,
        'attr' => "onchange=form.submit();",
        'selected' => isset($collection_id) ? $collection_id : NULL,
    ])
</form>
