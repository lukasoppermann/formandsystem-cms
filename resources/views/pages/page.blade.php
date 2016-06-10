@extends('layouts.app')

@section('content')
    @include('pages.settings')
    <div class="o-content o-content--wide o-user-grid o-user-grid--gutter-sm">

        @if( $page->fragments !== null)
            @foreach($page->fragments as $fragment)
                @include('fragments.fragment', ['fragment' => $fragment, 'page' => $page])
            @endforeach
        @endif

        @include('fragments.new-fragment', [
            'classes' => 'o-grid__column o-grid__column--md-12of12',
            'label' => 'Create new Section',
            'related' => 'page',
            'related_id' => $page->id,
            'type' => 'section',
        ])

    </div>
@stop
