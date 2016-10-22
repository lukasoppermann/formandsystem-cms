@include('notifications.email-unverified')
{{-- general status notification --}}
@if(session('status'))
    <status-bar type="{{session('type')}}" {{session('icon') || ''}} {{session('timeout') ? "timeout=".session('timeout') : 'closeable'}}>
        {{session('status')}}
    </status-bar>
@endif
