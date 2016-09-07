@extends('layouts.external')
@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="c-register-container">
        <div class="o-dialog__box c-login-dialog">
            <div class="o-dialog__body">
                <div class="login-logo">
                    <svg viewBox="0 0 120 50" class="o-icon login-logo">
                      <use xlink:href="#svg-icon--formandsystem-font"></use>
                    </svg>
                </div>

                <form role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}

                    @include('forms.input',['name' => 'name', 'label' => 'Your Name', 'attr' => "autofocus"])
                    @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address'])
                    @include('forms.input',['type' => 'password', 'name' => 'password', 'label' => 'Password'])
                    @include('forms.input',['type' => 'password' ,'name' => 'password_confirmation', 'label' => 'Confirm Password'])

                    <div class="o-flex-bar">
                        @include('forms.submit',['label' => 'Sign up', 'classes' => 'o-button o-button--blue o-button--space-top o-flex-bar__item o-flex-bar__item--fill'])
                    </div>
                </form>
            </div>
            <div class="o-dialog__footer">
                <a class="o-link o-link--quiet" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>
        </div>
        <aside class="c-register-side-panel">
            <div class="c-side-panel__body" layout="column">
                <h1 class="shame-login-h1">Sign up</h1>
                <div layout="column bottom-center" self="bottom">
                    <h2 class="o-flex-bar__item shame-login-h2">Already got an account?</h2>
                    <a href="{{ url('/login') }}" class="o-button o-button--white o-button--space-top o-button--space-bottom o-flex-bar__item">Sign up</a>
                </div>
            </div>
        </aside>
    </div>
</div>

</div>
@endsection
