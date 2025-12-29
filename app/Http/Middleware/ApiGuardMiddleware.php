<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\Factory as AuthFactory;


class ApiGuardMiddleware
{
    public function handle($request, Closure $next, ...$guards)
    {

        if (Auth::guard('api')->check()) {
            // return $next($request);
            dd('testtttt');
        }
    }
}
