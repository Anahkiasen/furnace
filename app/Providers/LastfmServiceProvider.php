<?php
namespace Furnace\Providers;

use Furnace\Services\Lastfm;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LastfmServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('clients.lastfm', function ($app) {
            return new Client([
                'base_url' => 'http://ws.audioscrobbler.com',
                'defaults' => [
                    'query' => [
                        'api_key' => $app['config']['services.lastfm.client_id'],
                        'format'  => 'json',
                    ],
                ],
            ]);
        });

        $this->app
            ->when(Lastfm::class)
            ->needs(Client::class)
            ->give('clients.lastfm');

        $this->app->singleton(Lastfm::class, Lastfm::class);
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [
            'clients.lastfm',
            Lastfm::class,
        ];
    }
}
