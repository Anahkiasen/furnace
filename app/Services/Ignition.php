<?php
namespace Furnace\Services;

use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Tracker;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;

class Ignition
{
    /**
     * @type Client
     */
    protected $client;

    /**
     * @type Repository
     */
    protected $cache;

    /**
     * @type bool
     */
    protected $authenticated = false;

    /**
     * Ignition constructor.
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
     * Perform a search against Ignition.
     *
     * @param string $query
     *
     * @return array
     */
    public function search($query)
    {
        return $this->cache->remember($query, 60, function () use ($query) {
            $this->authenticate();

            $response = $this->client->post('http://ignition.customsforge.com/cfss?u=32331', [
                'body' => [
                    'draw'                       => '2',
                    'columns[0][data][_]'        => '19',
                    'columns[0][data][display]'  => 'undefined',
                    'columns[0][name]'           => '',
                    'columns[0][searchable]'     => 'true',
                    'columns[0][orderable]'      => 'false',
                    'columns[0][search][value]'  => '',
                    'columns[0][search][regex]'  => 'false',
                    'columns[1][data][_]'        => '1',
                    'columns[1][data][display]'  => 'undefined',
                    'columns[1][name]'           => '',
                    'columns[1][searchable]'     => 'true',
                    'columns[1][orderable]'      => 'true',
                    'columns[1][search][value]'  => '',
                    'columns[1][search][regex]'  => 'false',
                    'columns[2][data][_]'        => '2',
                    'columns[2][data][display]'  => 'undefined',
                    'columns[2][name]'           => '',
                    'columns[2][searchable]'     => 'true',
                    'columns[2][orderable]'      => 'true',
                    'columns[2][search][value]'  => '',
                    'columns[2][search][regex]'  => 'false',
                    'columns[3][data]'           => '3',
                    'columns[3][name]'           => '',
                    'columns[3][searchable]'     => 'true',
                    'columns[3][orderable]'      => 'true',
                    'columns[3][search][value]'  => '',
                    'columns[3][search][regex]'  => 'false',
                    'columns[4][data][_]'        => '4',
                    'columns[4][data][display]'  => 'undefined',
                    'columns[4][name]'           => '',
                    'columns[4][searchable]'     => 'true',
                    'columns[4][orderable]'      => 'true',
                    'columns[4][search][value]'  => '',
                    'columns[4][search][regex]'  => 'false',
                    'columns[5][data]'           => '5',
                    'columns[5][name]'           => '',
                    'columns[5][searchable]'     => 'true',
                    'columns[5][orderable]'      => 'true',
                    'columns[5][search][value]'  => '',
                    'columns[5][search][regex]'  => 'false',
                    'columns[6][data]'           => '6',
                    'columns[6][name]'           => '',
                    'columns[6][searchable]'     => 'true',
                    'columns[6][orderable]'      => 'true',
                    'columns[6][search][value]'  => '',
                    'columns[6][search][regex]'  => 'false',
                    'columns[7][data][_]'        => '7',
                    'columns[7][data][display]'  => 'undefined',
                    'columns[7][name]'           => '',
                    'columns[7][searchable]'     => 'true',
                    'columns[7][orderable]'      => 'true',
                    'columns[7][search][value]'  => '',
                    'columns[7][search][regex]'  => 'false',
                    'columns[8][data][_]'        => '8',
                    'columns[8][data][display]'  => 'undefined',
                    'columns[8][name]'           => '',
                    'columns[8][searchable]'     => 'true',
                    'columns[8][orderable]'      => 'true',
                    'columns[8][search][value]'  => '',
                    'columns[8][search][regex]'  => 'false',
                    'columns[9][data]'           => '9',
                    'columns[9][name]'           => '',
                    'columns[9][searchable]'     => 'true',
                    'columns[9][orderable]'      => 'true',
                    'columns[9][search][value]'  => '',
                    'columns[9][search][regex]'  => 'false',
                    'columns[10][data][_]'       => '10',
                    'columns[10][data][display]' => 'undefined',
                    'columns[10][name]'          => '',
                    'columns[10][searchable]'    => 'true',
                    'columns[10][orderable]'     => 'true',
                    'columns[10][search][value]' => '',
                    'columns[10][search][regex]' => 'false',
                    'columns[11][data][_]'       => '11',
                    'columns[11][data][filter]'  => '11',
                    'columns[11][data][display]' => 'undefined',
                    'columns[11][name]'          => '',
                    'columns[11][searchable]'    => 'true',
                    'columns[11][orderable]'     => 'true',
                    'columns[11][search][value]' => '',
                    'columns[11][search][regex]' => 'false',
                    'columns[12][data][_]'       => '12',
                    'columns[12][data][display]' => 'undefined',
                    'columns[12][name]'          => '',
                    'columns[12][searchable]'    => 'true',
                    'columns[12][orderable]'     => 'true',
                    'columns[12][search][value]' => '',
                    'columns[12][search][regex]' => 'false',
                    'columns[13][data]'          => '13',
                    'columns[13][name]'          => '',
                    'columns[13][searchable]'    => 'true',
                    'columns[13][orderable]'     => 'true',
                    'columns[13][search][value]' => '',
                    'columns[13][search][regex]' => 'false',
                    'columns[14][data]'          => '14',
                    'columns[14][name]'          => '',
                    'columns[14][searchable]'    => 'true',
                    'columns[14][orderable]'     => 'true',
                    'columns[14][search][value]' => '',
                    'columns[14][search][regex]' => 'false',
                    'columns[15][data]'          => '15',
                    'columns[15][name]'          => '',
                    'columns[15][searchable]'    => 'true',
                    'columns[15][orderable]'     => 'true',
                    'columns[15][search][value]' => '',
                    'columns[15][search][regex]' => 'false',
                    'columns[16][data]'          => '16',
                    'columns[16][name]'          => '',
                    'columns[16][searchable]'    => 'true',
                    'columns[16][orderable]'     => 'true',
                    'columns[16][search][value]' => '',
                    'columns[16][search][regex]' => 'false',
                    'columns[17][data]'          => '17',
                    'columns[17][name]'          => '',
                    'columns[17][searchable]'    => 'true',
                    'columns[17][orderable]'     => 'true',
                    'columns[17][search][value]' => '',
                    'columns[17][search][regex]' => 'false',
                    'columns[18][data]'          => '18',
                    'columns[18][name]'          => '',
                    'columns[18][searchable]'    => 'true',
                    'columns[18][orderable]'     => 'true',
                    'columns[18][search][value]' => '',
                    'columns[18][search][regex]' => 'false',
                    'columns[19][data]'          => '19',
                    'columns[19][name]'          => '',
                    'columns[19][searchable]'    => 'true',
                    'columns[19][orderable]'     => 'true',
                    'columns[19][search][value]' => '',
                    'columns[19][search][regex]' => 'false',
                    'columns[20][data]'          => '20',
                    'columns[20][name]'          => '',
                    'columns[20][searchable]'    => 'true',
                    'columns[20][orderable]'     => 'true',
                    'columns[20][search][value]' => '',
                    'columns[20][search][regex]' => 'false',
                    'order[0][column]'           => '9',
                    'order[0][dir]'              => 'desc',
                    'start'                      => '0',
                    'length'                     => '100',
                    'search[value]'              => $query,
                    'search[regex]'              => 'false',
                ],
            ]);

            return array_get($response->json(), 'data');
        });
    }

    /**
     * Get a track's informations.
     *
     * @param int $track
     *
     * @return array
     */
    public function track($track)
    {
        $api  = $this->getApiInformations($track);
        $page = $this->getForumPageInformations($track);

        return array_merge($api, $page);
    }

    /**
     * Complete a track's informations.
     *
     * @param array $track
     *
     * @return array|void
     */
    public function complete(array $track)
    {
        $meta = $this->track($track['ignition_id']);

        // Create Tracker
        if (!$tracker = Arr::get($meta, 'member')) {
            return;
        }

        $tracker = Tracker::firstOrCreate(['name' => $tracker]);

        // Create Artist
        $artist = Arr::get($meta, 'artist');
        $artist = $this->decode($artist);
        $artist = Artist::firstOrCreate(['name' => $artist]);

        $track = array_merge(
            array_only($track, [
                'ignition_id',
            ]),
            array_only($meta, [
                'album',
                'parts',
                'platforms',
                'tuning',
                'difficulty_levels',
                'riff_repeater',
                'version',
            ]),
            [
                'dd'         => array_get($meta, 'dd', 'no') === 'yes',
                'name'       => array_get($meta, 'title'),
                'tracker_id' => $tracker->id,
                'artist_id'  => $artist->id,
                'created_at' => array_get($meta, 'added'),
                'updated_at' => array_get($meta, 'updated'),
            ]
        );

        // Decode unicode sequences
        $track = array_map([$this, 'decode'], $track);

        return $track;
    }

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// INFORMATIONS ////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Get the track's forum page informations.
     *
     * @param int $track
     *
     * @return array
     */
    public function getForumPageInformations($track)
    {
        // Fetch page contents
        $page = 'http://customsforge.com/page/customsforge_rs_2014_cdlc.html/_/pc-enabled-rs-2014-cdlc/pieces-r'.$track;
        $page = $this->cache->sear($page, function () use ($page) {
            $this->authenticate();

            return $this->client->get($page)->getBody()->getContents();
        });

        // Extract informations
        $infos   = [];
        $crawler = new Crawler($page);
        $crawler->filter('.ipb_table tr')->each(function (Crawler $node) use (&$infos) {
            $cells            = $node->filter('td')->extract('_text');
            $infos[$cells[0]] = $cells[1];
        });

        return [
            'riff_repeater'     => $infos['Riff Repeater:'] === 'Yes',
            'difficulty_levels' => (int) $infos['Difficulty Levels:'],
        ];
    }

    /**
     * @param int $track
     *
     * @return array
     */
    protected function getApiInformations($track)
    {
        return $this->cache->sear($track, function () use ($track) {
            $this->authenticate();

            return $this->client->get('http://ignition.customsforge.com/search/get_cdlc?id='.$track)->json();
        });
    }

    //////////////////////////////////////////////////////////////////////
    //////////////////////////////// AUTH ////////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Authenticate with the API.
     */
    protected function authenticate()
    {
        if ($this->authenticated) {
            return;
        }

        $this->authenticated = true;
        $this->client->post('http://customsforge.com/index.php?app=core&module=global&section=login&do=process', [
            'body' => [
                'ips_username' => env('IGNITION_USERNAME'),
                'ips_password' => env('IGNITION_PASSWORD'),
                'auth_key'     => env('IGNITION_KEY'),
                'rememberMe'   => 1,
            ],
        ]);
    }

/**
 * @param $artist
 *
 * @return string
 */protected function decode($artist)
{
    $artist = mb_convert_encoding($artist, 'UTF-8', 'HTML-ENTITIES');

    return $artist;
}
}
