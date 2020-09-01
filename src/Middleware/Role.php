<?php

namespace Aammui\RolePermission\Middleware;

use Aammui\RolePermission\Exception\RoleDoesNotExistException;
use Aammui\RolePermission\Exception\UnauthorizedException;
use Aammui\RolePermission\Exception\UserNotLoginException;
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
            throw new UserNotLoginException();
        }

        $role = $role ?? 'guest';
        $roles = explode('|', $role);

        if (!auth()->user()->hasGotRole($roles)) {
            throw new RoleDoesNotExistException();
        }

        return $next($request);
    }
}
