<?php
namespace Furnace\Providers;

use Furnace\Services\Lastfm;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LastfmServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Lastfm::class, function ($app) {
            $client = new Client([
                'base_url' => 'http://ws.audioscrobbler.com',
                'defaults' => [
                    'query' => [
                        'api_key' => $app['config']['services.lastfm.client_id'],
                        'format'  => 'json',
                    ],
                ],
            ]);

            return new Lastfm($client);
        });
    }
}
