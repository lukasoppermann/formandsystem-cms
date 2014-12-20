@extends('partials/app')

@section('content')
  @if( count($content['sections']) > 0 )
    @each('partials/section', $content['sections'], 'section')
  @endif

@stop
