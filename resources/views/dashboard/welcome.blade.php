@extends('layouts.app')

@section('content')
    <div class="o-content o-content--max-width">
        <h1 class="o-headline o-headline--first">Form&System</h1>
        <p class="o-copy o-content__paragraph">Welcome to the Form&System Content Managment System.</p>
        @foreach ($content as $key => $value)
            {{$value->get('name')}}
        @endforeach
    </div>
@stop
