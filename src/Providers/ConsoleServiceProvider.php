<?php
namespace Notetracker\Providers;

use Illuminate\Database\Schema\Builder;
use League\Container\ServiceProvider;
use Notetracker\Console\Console;
use Notetracker\Models\Track;
use Notetracker\Models\Tracker;
use Notetracker\Seeders\TracksSeeder;
use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        'console',
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
        $this->container->singleton('console', function () {
            return new Application('Notetracker');
        });

        $this->registerCommands();
    }

    /**
     * Register the commands
     */
    private function registerCommands()
    {
        /** @type Application $console */
        $console   = $this->container->get('console');
        $container = $this->container;

        $console->command('remigrate', function () use ($container) {
            /** @type Builder $schema */
            $schema = $container->get('db')->schema();
            $schema->drop('tracks');
            $schema->drop('trackers');

            $migrations = $container->get('paths.migrations');
            $migrations = glob($migrations.'/*.php');

            foreach ($migrations as $migration) {
                $table = basename($migration, '.php');

                if (!$schema->hasTable($table)) {
                    include $migration;
                }
            }
        });

        $console->command('seed', function (OutputInterface $output) use ($container) {
            Track::query()->delete();
            Tracker::query()->delete();

            $seeders = [TracksSeeder::class];
            foreach ($seeders as $seeder) {
                $seeder = new $seeder;
                $seeder->setContainer($container);
                $seeder->setOutput($output);
                $seeder->run();
            }
        });
    }
}
