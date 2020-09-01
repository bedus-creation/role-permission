<?php

namespace Aammui\RolePermission\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleDoesNotExistException extends HttpException
{
    public function __construct()
    {
        parent::__construct(403, 'User does not have the right roles.', null, []);
    }
}
