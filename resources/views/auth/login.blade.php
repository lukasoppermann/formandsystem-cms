@extends('layouts.external')
@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="c-login-container">
        <div class="o-dialog__box c-login-dialog">
            <div class="o-dialog__body">
                <div class="login-logo">
                    <svg viewBox="0 0 120 50" class="o-icon login-logo">
                      <use xlink:href="#svg-icon--formandsystem-font"></use>
                    </svg>
                </div>

                <form role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address', 'attr' => "autofocus"])
                    @include('forms.input',['type' => 'password','name' => 'password', 'label' => 'Password'])
                    @include('forms.toggle',['name' => 'remember', 'label' => 'Remember Me', 'checked' => true])

                    <div class="o-flex-bar o-flex-bar--centered">
                        @include('forms.submit',['label' => 'Login', 'classes' => 'o-button o-button--blue o-button--space-top o-flex-bar__item'])
                    </div>
                </form>
            </div>
            <div class="o-dialog__footer">
                <a class="o-link o-link--quiet" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>
        </div>
        <aside class="o-dialog__body c-login-side-panel o-flex-bar">
            <h1 class="shame-login-h1">Sign in</h1>
            <div class="o-flex-bar o-flex-bar--centered o-flex-bar__item o-flex-bar__item--bottom">
                <h2 class="o-flex-bar__item shame-login-h2">No account yet?</h2>
                <a href="{{ url('/register') }}" class="o-button o-button--white o-button--space-top o-button--space-bottom o-flex-bar__item">Sign up</a>
            </div>
        </aside>
    </div>
</div>

</div>
@endsection
