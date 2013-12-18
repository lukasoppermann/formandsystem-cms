@extends('template')
@include('content.menu')

@section('content')

<div class="content-wrapper">
	<input class="headline" type="text" placeholder="Type your title" />
	<textarea class="mark">
		{{$content}}
	</textarea>
</div>

@stop