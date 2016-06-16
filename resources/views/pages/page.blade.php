<?php
    $item = isset($page) ? $page : $item;
?>
@extends('layouts.app')

@section('content')
    @include('pages.settings')
    <div class="o-content o-content--wide o-user-grid o-user-gritemid--gutter-sm">

        @if( $item->fragments !== null)
            @foreach($item->fragments as $fragment)
                @include('fragments.fragment', ['item' => $fragment, 'page' => $item])
            @endforeach
        @endif

        @include('fragments.new-fragment', [
            'classes' => 'o-grid__column o-grid__column--md-12of12',
            'label' => 'Create new Section',
            'related' => 'page',
            'related_id' => $item->id,
            'type' => 'section',
        ])

    </div>
@stop
