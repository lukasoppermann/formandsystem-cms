@if(!Auth::user()->isVerified())
    @include('notifications.statusbar', [
        'type'      => 'warning',
        'text'      => 'You have not verified your email yet. [USE files for text]'
    ])
@endif
