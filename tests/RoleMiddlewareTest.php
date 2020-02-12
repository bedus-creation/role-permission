<?php

namespace Aammui\RolePermission\Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Aammui\RolePermission\Exception\UnauthorizedException;
use Aammui\RolePermission\Middleware\Role as RoleMiddleware;
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
    public function a_guest_cannot_access_a_route_protected_by_rolemiddleware()
    {
        $this->assertEquals(
            $this->runMiddleware(
                $this->roleMiddleware,
                'testRole'
            ),
            403
        );
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
        try {
            return $middleware->handle(new Request(), function () {
                return (new Response())->setContent('<html></html>');
            }, $parameter)->status();
        } catch (UnauthorizedException $e) {
            return $e->getStatusCode();
        }
    }
}
