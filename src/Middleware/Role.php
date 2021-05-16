<?php

namespace Aammui\RolePermission\Middleware;

use Aammui\RolePermission\Exception\RoleDoesNotExistException;
use Aammui\RolePermission\Exception\UserNotLoginException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Role
 *
 * @package Aammui\RolePermission\Middleware
 */
class Role
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  $role
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if (Auth::guest()) {
            throw new UserNotLoginException();
        }

        $role = $role ?? 'guest';
        $roles = explode('|', $role);

        if (! auth()->user()->hasGotRole($roles)) {
            throw new RoleDoesNotExistException();
        }

        return $next($request);
    }
}
