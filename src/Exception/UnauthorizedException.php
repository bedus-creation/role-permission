<?php

namespace Aammui\RolePermission\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public static function forRoles(): self
    {
        $message = 'User does not have the right roles.';
        return new static(403, $message, null, []);
    }
}
