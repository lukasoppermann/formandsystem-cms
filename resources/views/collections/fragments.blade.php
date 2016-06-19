@extends('layouts.app')

@section('content')
    <div class="o-user-grid o-content o-content--wide">
        @foreach ($items as $item)
            @include('fragments.fragment', [
                'item' => $item,
                'collection' => $collection
            ])
        @endforeach
        @foreach ($elements as $element)
            {!!$element!!}
        @endforeach
    </div>
@endsection
