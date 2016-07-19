Click here to reset your password: <a href="{{ $link = url(env('APP_PREFIX').'password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
