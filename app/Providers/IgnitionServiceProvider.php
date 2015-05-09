<?php
namespace Furnace\Providers;

use Furnace\Services\Ignition;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\ServiceProvider;

class IgnitionServiceProvider extends ServiceProvider
{
    /**
     * @type bool
     */
    protected $defer = true;

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->app->singleton('clients.ignition', function () {
            return new Client([
                'defaults' => [
                    'cookies' => new CookieJar(),
                ],
            ]);
        });

        $this->app
            ->when(Ignition::class)
            ->needs(Client::class)
            ->give('clients.ignition');

        $this->app->singleton(Ignition::class, Ignition::class);
        $this->app->alias(Ignition::class, 'ignition');
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            'clients.ignition',
            'ignition',
            Ignition::class,
        ];
    }
}
