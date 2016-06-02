@extends('layouts.app')

@section('content')
    @if( session('status') !== null)
        @include('notice.status', ['status' => session('status'), 'type' => session('type')])
    @endif
    @include('pages.settings')
    <div class="o-content o-content--wide o-user-grid o-user-grid--gutter-sm">

        @if( $page->fragments !== null)
            @foreach($page->fragments as $fragment)
                @include('fragments.fragment', ['fragment' => $fragment, 'page' => $page])
            @endforeach
        @endif

        @include('fragments.new-section', ['page_id' => $page->id])

    </div>
@stop
