<?php
namespace Furnace\Providers;

use Arrounded\Macros\FormerBuilder;
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
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->make(FormerBuilder::class)->registerMacros();
    }
}
