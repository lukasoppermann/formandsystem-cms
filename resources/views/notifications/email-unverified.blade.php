@if(!Auth::user()->isVerified())
    @if(session('email-verification.resend') === true)
        <status-bar type="success">
            @lang('notifications.email_verification_resend')
        </status-bar>
    @else
        <status-bar type="warning">
            @lang('notifications.email_verification_needed') <a href="{{route('email-verification.resend')}}">@lang('general.resend_link')</a>. ROUTE NOT WORKING
        </status-bar>
    @endif
@endif
