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

    /** @test */
    public function roles_and_permission_are_case_insensetive()
    {
        $user = User::create(['email' => 'test@example.com']);
        $user->addRole('admin');
        $this->assertTrue($user->hasGotRole('Admin'));

        $user->addRole(['admin', 'System admin']);
        $this->assertEquals(['admin', 'system admin'], $user->refresh()->getRoles());

        $this->assertEquals(2, Role::count());
        // admin and system admin, No multiple same role will be assigned.
    }

    /** @test */
    public function role_can_be_accessed_from_logined_user()
    {
        $user = User::create(['email' => 'test@example.com']);
        $user->addRole('admin');
        $this->be($user);

        auth()->user()->addRole('admin');
        $this->assertTrue($user->hasGotRole('admin'));
    }
}
