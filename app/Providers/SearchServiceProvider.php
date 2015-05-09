<?php
namespace Furnace\Providers;

use ElasticSearcher\ElasticSearcher;
use ElasticSearcher\Environment;
use Furnace\Services\Search\Indexes\TracksIndex;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @type bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Environment::class, function () {
            return new Environment([
                'hosts' => [
                    'localhost:9200',
                ],
            ]);
        });

        // Register ElasticSearcher
        $this->app->singleton(ElasticSearcher::class, function () {
            $env = $this->app->make(Environment::class);
            $search = new ElasticSearcher($env);
            $search->indicesManager()->registerIndices([
                new TracksIndex(),
            ]);

            return $search;
        });

        $this->app->alias(ElasticSearcher::class, 'search');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Environment::class,
            ElasticSearcher::class,
            'search',
        ];
    }
}
