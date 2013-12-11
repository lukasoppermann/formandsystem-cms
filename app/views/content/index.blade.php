@extends('template')

@section('content')

<div class="content-wrapper">
	<input class="headline" type="text" placeholder="Type your title" />
	<textarea class="mark">
		{{$content}}
	</textarea>
</div>

@stop