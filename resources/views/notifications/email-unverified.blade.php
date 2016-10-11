@if(!Auth::user()->isVerified())
    @if(session('email-verification.resend') === true)
        <status-bar type="success">
            @lang('notifications.email_verification_resend')
        </status-bar>
    @else
        <status-bar type="warning" closeable="true">
            @lang('notifications.email_verification_needed') <a href="#" onclick="event.preventDefault();
                     document.getElementById('resend-verification').submit();">@lang('general.resend_link')</a>.
            <form id="resend-verification" action="{{ route('email-verification.resend') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            </form>
        </status-bar>
    @endif
@endif
