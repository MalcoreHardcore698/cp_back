<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessToken = $request->get('access_token');
        if ((string) $accessToken === '') {
            return \App\Helpers\Response::error('Access token is not valid');
        }

        return $next($request);
    }
}
