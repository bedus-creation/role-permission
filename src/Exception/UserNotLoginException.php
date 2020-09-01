<?php

namespace Aammui\RolePermission\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserNotLoginException extends HttpException
{
    public function __construct()
    {
        parent::__construct(403, 'User is not logged in.', null, []);
    }
}
