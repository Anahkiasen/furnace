<?php
namespace Notetracker\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use League\Container\ServiceProvider;
use Notetracker\Services\Ignition;

class IgnitionServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        'ignition',
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
        $this->container->singleton('ignition', function () {
            $client = new Client([
                'defaults' => [
                    'cookies' => new CookieJar(),
                ]
            ]);

            return new Ignition($client);
        });
    }
}
