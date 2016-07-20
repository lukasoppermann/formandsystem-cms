@extends('layouts.external')
@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="o-dialog__box c-login-dialog">
        <div class="o-dialog__body">
            <div class="login-logo">
                <svg viewBox="0 0 120 50" class="o-icon login-logo">
                  <use xlink:href="#svg-icon--formandsystem-font"></use>
                </svg>
            </div>

            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address'])
                @include('forms.input',['type' => 'password','name' => 'password', 'label' => 'Password'])
                @include('forms.toggle',['name' => 'remember', 'label' => 'Remember Me', 'checked' => true])

                <div class="o-flex">
                    @include('forms.submit',['label' => 'Login', 'classes' => 'o-button o-button--blue o-button--space-top o-flex__item--fill'])
                </div>
            </form>
        </div>
        <div class="o-dialog__footer">
            <a class="o-link o-link--quiet" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
        </div>

    </div>
</div>

</div>
@endsection
