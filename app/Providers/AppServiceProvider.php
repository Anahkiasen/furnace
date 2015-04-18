<?php
namespace Furnace\Providers;

use Arrounded\Macros\FormerBuilder;
use Furnace\Services\ScoreComputer;
use Illuminate\Support\ServiceProvider;
use Laracasts\Generators\GeneratorsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $this->app->register(GeneratorsServiceProvider::class);
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
        }

        $this->app->singleton(ScoreComputer::class, function ($app) {
           return new ScoreComputer($app['config']['furnace.weights']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->make(FormerBuilder::class)->registerMacros();
    }
}
