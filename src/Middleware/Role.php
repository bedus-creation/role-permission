<?php

namespace Aammui\RolePermission\Middleware;

use Aammui\RolePermission\Exception\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Closure;

class Role
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {

        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $role = $role ?? 'guest';
        $roles = explode('|', $role);
        // dd($roles);
        // dd(auth()->user()->hasGotRole($roles));
        if (!auth()->user()->hasGotRole($roles)) {
            throw UnauthorizedException::forRoles();
        }

        return $next($request);
    }
}
