@extends('partials/app')

@section('content')
  <div data-page data-page-id="">
    @if( count($content['sections']) > 0 )
      @foreach ($content['sections'] as $key => $section)
        @include('partials/section', array('pos' => $key, 'section' => $section))
      @endforeach

    @endif
    @include('partials/section-new')
  </div>
@stop
