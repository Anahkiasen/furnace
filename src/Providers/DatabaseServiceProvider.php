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

        $this->runMigrations();
        $this->seedDatabase();
    }

    /**
     * Run outstanding migrations
     */
    protected function runMigrations()
    {
        /** @type Builder $schema */
        $schema     = $this->container->get('db')->schema();
        $migrations = $this->container->get('paths.migrations');
        $migrations = glob($migrations.'/*.php');

        foreach ($migrations as $migration) {
            $table = basename($migration, '.php');

            if (!$schema->hasTable($table)) {
                include $migration;
            }
        }
    }

    /**
     * Seed the database
     */
    protected function seedDatabase()
    {
        $seeders = [TracksSeeder::class];
        foreach ($seeders as $seeder) {
            $seeder = new $seeder;
            $seeder->setContainer($this->container);
            $seeder->run();
        }
    }
}
