<?php

namespace Aammui\RolePermission\Tests;

class RoleTest extends TestCase
{
    /** @test */
    public function role_can_be_created()
    {
        $user = User::create(['email' => 'test@example.com']);
        $this->assertEquals(count(auth()->user()->role), 1);
    }
}
