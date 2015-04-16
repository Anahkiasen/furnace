<?php
namespace Notetracker\Services;

use GuzzleHttp\Client;
use Illuminate\Cache\Repository;
use Illuminate\Support\Arr;
use Notetracker\Entities\Models\Tracker;
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
     * Ignition constructor.
     *
     * @param Client     $client
     * @param Repository $cache
     */
    public function __construct(Client $client, Repository $cache)
    {
        $this->client = $client;
        $this->cache  = $cache;

        $this->authenticate();
    }

    /**
     * Get a track's informations.
     *
     * @param integer $track
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
     * Complete a track's informations
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

        return array_merge(
            array_only($track, [
                'file',
                'presilence',
                'normalized_volume',
                'live',
                'playable',
                'tone',
                'track',
                'tab',
                'ignition_id',
            ]),
            array_only($meta, [
                'artist',
                'album',
                'parts',
                'tuning',
                'difficulty_levels',
                'riff_repeater',
                'version',
            ]),
            [
                'dd'         => array_get($meta, 'dd', 'no') == 'yes',
                'name'       => array_get($meta, 'title'),
                'tracker_id' => $tracker->id,
                'created_at' => array_get($meta, 'added'),
                'updated_at' => array_get($meta, 'updated'),
            ]
        );

    }

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// INFORMATIONS ////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Get the track's forum page informations
     *
     * @param integer $track
     *
     * @return array
     */
    public function getForumPageInformations($track)
    {
        // Fetch page contents
        $page = 'http://customsforge.com/page/customsforge_rs_2014_cdlc.html/_/pc-enabled-rs-2014-cdlc/pieces-r'.$track;
        $page = $this->cache->sear($page, function () use ($page) {
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
            'riff_repeater'     => $infos['Riff Repeater:'] == 'Yes',
            'difficulty_levels' => (int) $infos['Difficulty Levels:'],
        ];
    }

    /**
     * @param integer $track
     *
     * @return array
     */
    protected function getApiInformations($track)
    {
        return $this->cache->sear($track, function () use ($track) {
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
        $this->client->post('http://customsforge.com/index.php?app=core&module=global&section=login&do=process', [
            'body' => [
                'ips_username' => 'Anahkiasen',
                'ips_password' => 'cXQMU9PF6mXMxYdeplLEkfqwFScgDl',
                'auth_key'     => '880ea6a14ea49e853634fbdc5015a024',
                'rememberMe'   => 1,
            ],
        ]);
    }
}
