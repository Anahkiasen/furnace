<?php
namespace Furnace\Services;

use Furnace\Entities\Models\Track;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;

class Lastfm
{
    /**
     * @type Client
     */
    protected $client;

    /**
     * @type Repository
     */
    private $cache;

    /**
     * Lastfm constructor.
     *
     * @param Client     $client
     * @param Repository $cache
     */
    public function __construct(Client $client, Repository $cache)
    {
        $this->client = $client;
        $this->cache  = $cache;
    }

    /**
     * Get the tags for a track.
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
     * Get the tags for an artist.
     *
     * @param string $artist
     *
     * @return string[]
     */
    public function getArtistTags($artist)
    {
        // Get tags from API
        $response = $this->cache->rememberForever($artist, function () use ($artist) {
            $response = $this->client->get('/2.0/', [
                'query' => [
                    'method' => 'artist.gettoptags',
                    'artist' => $artist,
                ],
            ]);

            return $response->json();
        });

        // Extract tags from response
        $tags = (array) Arr::get($response, 'toptags.tag');
        $tags = array_column($tags, 'name');
        $tags = array_slice($tags, 0, 3);

        return $tags;
    }
}
