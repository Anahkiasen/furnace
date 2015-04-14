<?php
namespace Notetracker\Providers;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Builder;
use League\Container\ServiceProvider;
use Notetracker\Seeders\TracksSeeder;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        'db',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton('db', function () {
            $capsule = new Manager();
            $capsule->addConnection([
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'notetracker',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]);

            // Boot Eloquent
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });
    }
}
