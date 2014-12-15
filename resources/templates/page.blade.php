@extends('partials/app')

@section('content')
  @each('partials/section', $content['data'], 'section', 'partials/no-sections')
@stop
