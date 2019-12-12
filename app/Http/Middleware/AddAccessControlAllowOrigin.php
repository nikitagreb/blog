<?php

namespace App\Http\Middleware;

use Closure;

class AddAccessControlAllowOrigin
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', env('APP_URL_FRONT'));

        return $response;
    }
}
