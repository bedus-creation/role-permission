<?php

namespace Aammui\RolePermission\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // setup databases
        $this->setUpDatabase($this->app);
    }
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'foreign_key_constraints' => true,
            'prefix' => '',
        ], 'constraints_set');
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('email');
            $table->softDeletes();
        });

        require_once __DIR__ . "/../database/migrations/2018_07_17_060329_create_roles_table.php";
        require_once __DIR__ . "/../database/migrations/2018_07_17_060344_create_permissions_table.php";
        (new  \CreateRolesTable())->up();
        (new \CreatePermissionsTable())->up();
    }
}
