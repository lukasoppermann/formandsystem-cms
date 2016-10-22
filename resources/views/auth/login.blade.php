@extends('layouts.external')
@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="c-login-container">
        <div class="o-dialog__box c-login-dialog">
            <div class="o-dialog__body">
                <div class="login-logo">
                    {{ svg_icon('formandsystem-font', 'o-icon--formandsystem-font o-media__figure') }}
                </div>

                <form role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <material-input name="email" label="E-Mail Address" autofocus autocomplete type="email" value="{{ old('email') }}" required></material-input>
                    <material-input name="password" type="password" label="Password" required message="{{ $errors->count() > 0 ? htmlspecialchars(implode($errors->all(),' ')) : '' }}"></material-input>
                    {{-- @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address', 'attr' => "autofocus"]) --}}
                    {{-- @include('forms.input',['type' => 'password','name' => 'password', 'label' => 'Password']) --}}
                    {{-- @include('forms.toggle',['name' => 'remember', 'label' => 'Remember Me', 'checked' => true]) --}}
                    <label class="o-form__toggle"><material-toggle name='remember' {{ old('remember') === 'on' ? 'checked' : '' }}></material-toggle>Remember Me</label>

                    <div class="o-flexbar o-flexbar--centered">
                        @include('forms.submit',['name'=>'signin', 'label' => 'Login', 'classes' => 'o-button o-button--blue o-button--space-top o-flexbar__item'])
                    </div>
                </form>
            </div>
            <div class="o-dialog__footer">
                <a class="o-link o-link--quiet" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>
        </div>
        <aside class="c-login-side-panel">
            <div class="c-side-panel__body" layout="column top-left">
                <h1 class="shame-login-h1">Sign in</h1>
                <div layout="column bottom-center" self="bottom">
                    <h2 class="shame-login-h2">No account yet?</h2>
                    <a href="{{ url('/register') }}" class="o-button o-button--white o-button--space-top o-button--space-bottom">Sign up</a>
                </div>
            </div>
        </aside>
    </div>
</div>

</div>
@endsection
