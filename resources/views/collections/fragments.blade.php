@extends('layouts.app')

@section('content')
    <div class="o-user-grid o-content o-content--wide js-sortable-fragments" data-patch-url="{{url('/fragments').'/'}}">
        @foreach ($items as $item)
            @include('fragments.fragment', [
                'item' => $item,
                'collection' => $collection,
                'sortable_class' => 'js-sortable-fragment-item',
            ])
        @endforeach
        @if(is_array($elements))
            @foreach ($elements as $element)
                {!!$element!!}
            @endforeach
        @endif
    </div>
@endsection
