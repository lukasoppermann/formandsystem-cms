<?php
    $collections = config('app.user')->account()->collections();

    $cols = $collections->filter(function($item) use($collection){
        return $item->get('id') !== $collection->get('id');
    })->keyBy('id')->map(function($item){
        return $item['name'];
    });
    if(!$item->collections()->isEmpty()){
        $collection_id = $item->collections()->first()->get('id');
    }


?>
SELECTS are not updating fragments correctly
<form action="/fragments/{{$item->get('id')}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    @include('forms.select', [
        'name' => 'collection',
        'label' => 'Select a collection',
        'values' => array_merge([false => 'select'],$cols->toArray()),
        'attr' => "onchange=form.submit();",
        'selected' => isset($collection_id) ? $collection_id : NULL,
    ])
</form>
