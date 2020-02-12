<?php

namespace Aammui\RolePermission\Tests;

use Illuminate\Auth\Authenticatable;
use Aammui\RolePermission\Traits\HasRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use HasRole, Authorizable, Authenticatable;

    protected $fillable = ['email'];

    public $timestamps = false;
}
