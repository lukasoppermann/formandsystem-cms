@extends('layouts.external')

<!-- Main Content -->
@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="o-dialog__box c-login-dialog">
        <div class="o-dialog__body">

            <div class="o-dialog__headline">Reset Password</div>

            @if (session('status'))
                <div class="o-inline-notice">
                    {{ session('status') }}
                </div>
            @endif

            <form role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address'])

                <div class="o-flex-bar o-flex-bar--centered">
                    @include('forms.submit',['name' => 'get_reset_email','label' => 'Send password link', 'classes' => 'o-button o-button--blue o-button--space-top o-flex-bar__item--fill'])
                </div>
            </form>

        </div>
        <div class="o-dialog__footer">
            <a class="o-link o-link--quiet" href="{{ url('/login') }}">Back to the login screen</a>
        </div>
    </div>
</div>
@endsection
