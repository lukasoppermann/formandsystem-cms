@extends('layouts.app')

@section('content')
    @foreach ($items as $item)
        @include('fragments.fragment', [
            'item' => $item,
            'collection' => $collection
        ])
    @endforeach
@endsection
