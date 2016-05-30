@extends('layouts.app')

@section('content')
    @include('pages.settings')
    <div class="o-content o-content--max-width">
        <h1 class="o-headline o-headline--first">{{$page->title}}</h1>
        <p class="o-copy o-content__paragraph">{{$page->description}}</p>

        @each('pages.fragment', $page->fragments, 'fragment')

    </div>
@stop
