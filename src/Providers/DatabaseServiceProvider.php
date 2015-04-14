<?php
namespace Notetracker\Providers;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Container\ServiceProvider;
use League\Csv\Reader;
use Notetracker\Models\Tracker;
use Notetracker\Models\Track;

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
        $migrations = $this->container->get('paths.migrations');
        $migrations = glob($migrations.'/*.php');
        foreach ($migrations as $migration) {
            $schema = $this->container->get('db')->schema();
            $table  = basename($migration, '.php');

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
        $reader = $this->container->get('paths.fixtures').'/tracks.csv';
        $reader = Reader::createFromPath($reader);

        $fixtures = $reader->fetchAssoc(0);
        $fixtures = new Collection($fixtures);
        $fixtures = $fixtures->keyBy('file');

        $cdlc = $this->container->get('paths.cdlc');
        $cdlc = glob($cdlc.'/*');
        foreach ($cdlc as $track) {
            $file = basename($track);
            $track = Arr::get($fixtures, $file, ['file' => $file]);

            // Create Tracker
            $tracker = Arr::get($track, 'tracker');
            $tracker = Tracker::firstOrCreate(['name' => $tracker]);
            $track['tracker_id'] = $tracker->id;
            unset($track['tracker']);

            Track::firstOrCreate($track);
        }
    }
}
