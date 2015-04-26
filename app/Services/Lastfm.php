<?php
namespace Furnace\Services;

use Furnace\Entities\Models\Track;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class Lastfm
{
    /**
     * @type Client
     */
    protected $client;

    /**
     * Lastfm constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the tags for a track
     *
     * @param Track $track
     *
     * @return string[]
     */
    public function getTrackTags(Track $track)
    {
        return $this->getArtistTags($track->artist);
    }

    /**
     * Get the tags for an artist
     *
     * @param string $artist
     *
     * @return string[]
     */
    public function getArtistTags($artist)
    {
        $response = $this->client->get('/2.0/', [
            'query' => [
                'method' => 'artist.gettoptags',
                'artist' => $artist,
            ],
        ]);

        // Extract tags from response
        $response = $response->json();
        $tags     = Arr::get($response, 'toptags.tag');
        $tags     = array_column($tags, 'name');
        $tags     = array_slice($tags, 0, 3);

        return $tags;
    }
}
