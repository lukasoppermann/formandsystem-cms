@extends('partials/app')

@section('content')
  <div data-page data-page-id="{{$content['id']}}">
    @if( count($content['sections']) > 0 )
      @each('partials/section', $content['sections'], 'section')
    @endif
  </div>
@stop
