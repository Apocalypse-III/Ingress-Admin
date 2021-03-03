<?php


namespace App\Http\Middleware;


use Auth;
use Closure;

class RequestAuthUser
{
    public function handle($request, Closure $next)
    {
        $request->setUserResolver(function () {
            return Auth::user();
        });

        return $next($request);
    }
}
