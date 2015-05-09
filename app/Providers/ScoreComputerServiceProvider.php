<?php
namespace Furnace\Providers;

use Furnace\Collection;
use Furnace\Services\ScoreComputer;
use Illuminate\Support\ServiceProvider;
use League\Csv\Reader;

class ScoreComputerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @type string
     */
    protected $fixture = 'fixtures/weights.csv';

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(ScoreComputer::class, function ($app) {
            $weights = $this->getWeightsFromFixture();
            $app['config']->set('furnace.weights', $weights);

            return new ScoreComputer($weights);
        });
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [ScoreComputer::class];
    }


    /**
     * Get the weights from the fixture file.
     *
     * @return array
     */
    protected function getWeightsFromFixture()
    {
        // Parse CSV
        $weights = Reader::createFromPath(database_path($this->fixture));
        $weights = new Collection($weights->fetchAssoc(0));

        // Return as key => value
        $weights = $weights->lists('average', 'criteria');
        $weights = array_filter($weights, function ($weight) {
            return !is_null($weight);
        });

        return $weights;
    }
}
