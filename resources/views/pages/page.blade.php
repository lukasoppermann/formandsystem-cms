@extends('layouts.app')

@section('content')
    @if( session('status') !== null)
        @include('notice.status', ['status' => session('status'), 'type' => session('type')])
    @endif
    @include('pages.settings')
    <div class="o-content o-grid o-grid--gutter-sm o-grid-columns--{{config('user.grid')}}">

        @each('pages.fragment', $page->fragments, 'fragment')

    </div>
@stop
