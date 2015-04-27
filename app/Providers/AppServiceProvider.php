<?php
namespace Furnace\Providers;

use Arrounded\Macros\FormerBuilder;
use Furnace\Collection;
use Furnace\FurnaceValidator;
use Furnace\Services\ScoreComputer;
use Illuminate\Support\ServiceProvider;
use Laracasts\Generators\GeneratorsServiceProvider;
use League\Csv\Reader;
use Validator;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->make(FormerBuilder::class)->registerMacros();

        Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new FurnaceValidator($translator, $data, $rules, $messages);
        });
    }
}
