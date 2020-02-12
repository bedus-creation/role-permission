<?php

namespace Aammui\RolePermission\Tests;

class RoleTest extends TestCase
{
    /** @test */
    public function role_can_assign_to_a_user()
    {
        $user = User::create(['email' => 'test@example.com']);
        $user->addRole('admin');
    }
}
