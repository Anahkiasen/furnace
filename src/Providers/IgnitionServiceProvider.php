<?php
namespace Notetracker\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Cache\Repository;
use League\Container\ServiceProvider;
use Notetracker\Services\Ignition;

class IgnitionServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Ignition::class,
        'ignition',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->singleton('ignition', function () {
            $client = new Client([
                'defaults' => [
                    'cookies' => new CookieJar(),
                ],
            ]);

            return new Ignition($client, $this->container->get(Repository::class));
        });

        $this->container->singleton(Ignition::class, function () {
            return $this->container->get('ignition');
        });
    }
}
