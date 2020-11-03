<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @param string $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        if (!$request->user()) {
            throw new HttpException(401);
        }
        if (!$request->user()->hasRole($role)) {
            throw new HttpException(401);
        }
        return $next($request);
    }
}
