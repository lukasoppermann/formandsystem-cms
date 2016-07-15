@extends('layouts.app')

@section('content')
    <div class="o-content o-content--max-width">
        <h1 class="o-headline o-headline--first">Developer Settings</h1>
        @include('settings.api-access')
        @include('settings.cache-busting')
        @if(isset($client_id))
            @include('settings.database')
            @include('settings.ftp-images')
            @include('settings.ftp-backup')
        @endif
    </div>
@stop
