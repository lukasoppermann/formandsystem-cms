@extends('layouts.app')

@section('content')
    <div class="o-user-grid o-content o-content--wide">
        @foreach ($items as $item)
            @include('fragments.fragment', [
                'item' => $item,
                'collection' => $collection
            ])
        @endforeach
        @if(is_array($elements))
            @foreach ($elements as $element)
                {!!$element!!}
            @endforeach
        @endif
    </div>
@endsection
