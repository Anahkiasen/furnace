<?php
namespace Furnace\Providers;

use ElasticSearcher\ElasticSearcher;
use ElasticSearcher\Environment;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
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
            $search = new ElasticSearcher($this->container->get(Environment::class));
            $search->indicesManager()->registerIndices([
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
