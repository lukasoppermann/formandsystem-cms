@extends('master')

@section('content')
    @if( session('status') !== null)
        @include('notice.status', ['status' => session('status'), 'type' => session('type')])
    @endif
    <div class="o-content o-content--max-width">
        <section class="o-section">
            <h2 class="o-headline o-headline--first">Developer Settings</h2>
            @include('settings.api-access')
            @if(isset($client_id))
                @include('settings.database')
                @include('settings.ftp-images')
                @include('settings.ftp-backup')
            @endif
    </div>
@stop
