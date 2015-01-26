@extends('partials/app')

@section('content')

  @if( count($content['sections']) > 0 )
    @each('partials/section', $content['sections'], 'section')
  @endif
  <ul class="sortable">
		<li class="item">
			Section ONE
		</li>
    <li class="item">
			Section
		</li>
	</ul>
@stop
