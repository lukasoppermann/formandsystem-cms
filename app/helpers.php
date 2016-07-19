<?php

/**
 * Generate a url for the application using the APP_PREFIX
 *
 * @param  string  $path
 * @param  mixed   $parameters
 * @param  bool    $secure
 * @return Illuminate\Contracts\Routing\UrlGenerator|string
 */
function url($path = null, $parameters = [], $secure = null)
{
    $path = env('APP_PREFIX').$path;

    return app(UrlGenerator::class)->to($path, $parameters, $secure);
}
