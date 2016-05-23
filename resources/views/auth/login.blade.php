@extends('layouts.external')

@section('content')
<div class="o-dialog o-dialog--transparent">
    <div class="o-dialog__box">
        <div class="login-logo">
            <svg viewBox="0 0 120 50" class="o-icon login-logo">
              <use xlink:href="#svg-icon--formandsystem-font"></use>
            </svg>
        </div>

        <form role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            @include('forms.input',['name' => 'email', 'label' => 'E-Mail Address'])

            @include('forms.input',['type' => 'password','name' => 'password', 'label' => 'Password'])

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i>Login
                    </button>

                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                </div>
            </div>
        </form>

    </div>
</div>

</div>
@endsection
