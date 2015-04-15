<?php
namespace Notetracker\Services;

use GuzzleHttp\Client;

class Ignition
{
    /**
     * @type Client
     */
    protected $client;

    /**
     * Ignition constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->authenticate();
    }

    /**
     * Get a track's informations
     *
     * @param $track
     *
     * @return array
     */
    public function track($track)
    {
        return $this->client->get('http://ignition.customsforge.com/search/get_cdlc?id='.$track)->json();
    }

    /**
     * Authenticate with the API
     */
    protected function authenticate()
    {
        $this->client->post('http://customsforge.com/index.php?app=core&module=global&section=login&do=process', [
            'body' => [
                'ips_username' => 'Anahkiasen',
                'ips_password' => 'cXQMU9PF6mXMxYdeplLEkfqwFScgDl',
                'auth_key'     => '880ea6a14ea49e853634fbdc5015a024',
                'rememberMe'   => 1,
            ]
        ]);
    }
}
