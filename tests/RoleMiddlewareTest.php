<?php

namespace Aammui\RolePermission\Tests;

use Aammui\RolePermission\Exception\RoleDoesNotExistException;
use Aammui\RolePermission\Exception\UserNotLoginException;
use Aammui\RolePermission\Middleware\Role as RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddlewareTest extends TestCase
{
    protected $roleMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->roleMiddleware = new RoleMiddleware();
    }

    /** @test */
    public function a_user_can_access_a_route_protected_by_role_middleware_if_have_this_role()
    {
        $user = User::create(['email' => 'tyest@gmail.com']);
        Auth::login($user);

        $user->addRole('testRole');

        $this->assertEquals(
            $this->runMiddleware(
                $this->roleMiddleware,
                'testRole'
            ),
            200
        );
    }


    protected function runMiddleware($middleware, $parameter)
    {
        return $middleware->handle(new Request(), function () {
            return (new Response())->setContent('<html></html>');
        }, $parameter)->status();
    }

    /**
     * A guest cannot access a route protected by rolemiddleware
     *
     * @test
     */
    public function UserNotLogin_exception_is_thrown_when_user_not_login()
    {
        $this->expectException(UserNotLoginException::class);

        $this->roleMiddleware->handle(new Request(), function () {
            return (new Response())->setContent('<html></html>');
        }, 'testRole')->status();
    }

    /**
     * A User cannot access a route protected by rolemiddleware
     *
     * @test
     */
    public function RoleDoesNotExist_exception_is_thrown_when_user_not_login()
    {
        $this->expectException(RoleDoesNotExistException::class);

        $user = User::create(['email' => 'tyest@gmail.com']);
        Auth::login($user);

        $this->roleMiddleware->handle(new Request(), function () {
            return (new Response())->setContent('<html></html>');
        }, 'testRole')->status();
    }
}
