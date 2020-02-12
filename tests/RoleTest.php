<?php

namespace Aammui\RolePermission\Tests;

use Aammui\RolePermission\Models\Role;

class RoleTest extends TestCase
{
    /** @test */
    public function role_can_assign_to_a_user()
    {
        $user = User::create(['email' => 'test@example.com']);
        $user->addRole('admin');
        $this->assertEquals(1, Role::count());
    }

    /** @test */
    public function user_has_got_a_role()
    {
        $user = User::create(['email' => 'test@example.com']);
        $user->addRole('admin');
        $this->assertTrue($user->hasGotRole(['admin']));
    }
}
