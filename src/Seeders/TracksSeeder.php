<?php
namespace Notetracker\Seeders;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use League\Container\ContainerAwareTrait;
use League\Csv\Reader;
use Notetracker\Models\Track;
use Notetracker\Models\Tracker;

class TracksSeeder
{
    use ContainerAwareTrait;

    /**
     * Run the seeder.
     */
    public function run()
    {
        $tracks = $this->getFixtures();

        foreach ($tracks as $track) {
            if ($track['file']) {
                $track = $this->getTrackInformations($track);
                Track::firstOrCreate($track);
            }
        }
    }

    /**
     * @return array|Collection|static
     */
    protected function getFixtures()
    {
        $reader = $this->container->get('paths.fixtures').'/tracks.csv';
        $reader = Reader::createFromPath($reader);
        $reader->setDelimiter("\t");

        $fixtures = $reader->fetchAssoc(0);
        $fixtures = new Collection($fixtures);
        $fixtures = $fixtures->keyBy('file');

        return $fixtures;
    }

    /**
     * @param $track
     *
     * @return array|mixed
     */
    protected function getTrackInformations($track)
    {
        $meta = Arr::get($track, 'meta', '{}');
        $meta = (array) json_decode($meta, true);

        // Create Tracker
        $tracker = Arr::get($meta, 'member');
        if ($tracker) {
            $tracker = Tracker::firstOrCreate(['name' => $tracker]);
        } else {
            dump($track);
            exit;
        }

        return [
            'file'              => array_get($track, 'file'),
            'artist'            => array_get($meta, 'artist'),
            'album'             => array_get($meta, 'album'),
            'name'              => array_get($meta, 'title'),
            'presilence'        => array_get($track, 'presilence', false),
            'normalized_volume' => array_get($track, 'normalized_volume', false),
            'live'              => array_get($track, 'live', false),
            'playable'          => array_get($track, 'playable', false),
            'dd'                => array_get($meta, 'dd', 'no') == 'yes',
            'tone'              => array_get($track, 'tone'),
            'track'             => array_get($track, 'track'),
            'parts'             => array_get($meta, 'parts'),
            'tuning'            => array_get($meta, 'tuning'),
            'version'           => array_get($meta, 'version'),
            'tab'               => array_get($track, 'tab'),
            'tracker_id'        => $tracker->id,
            'created_at'        => array_get($meta, 'added'),
            'updated_at'        => array_get($meta, 'updated'),
        ];
    }
}
