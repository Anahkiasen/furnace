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
     * @type Collection
     */
    protected $fixtures;

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->getFixtures();

        $cdlc = $this->container->get('paths.cdlc');
        $cdlc = glob($cdlc.'/*');
        foreach ($cdlc as $track) {
            $track = $this->getTrackInformations($track);
            Track::firstOrCreate($track);
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

        $this->fixtures = $fixtures;
    }

    /**
     * @param $track
     *
     * @return array|mixed
     */
    protected function getTrackInformations($track)
    {
        $file  = basename($track);
        $track = $this->fixtures->get($file, ['file' => $file]);

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
            'file'              => $file,
            'artist'            => array_get($meta, 'artist'),
            'album'             => array_get($meta, 'album'),
            'name'              => array_get($meta, 'title'),
            'presilence'        => array_get($track, 'presilence', false),
            'normalized_volume' => array_get($track, 'normalized_volume', false),
            'live'              => array_get($track, 'live', false),
            'dd'                => array_get($meta, 'dd', 'no') == 'yes',
            'tone'              => array_get($track, 'tone'),
            'track'             => array_get($track, 'track'),
            'parts'             => array_get($meta, 'parts'),
            'tuning'             => array_get($meta, 'tuning'),
            'tab'               => array_get($track, 'tab'),
            'tracker_id'        => $tracker->id,
        ];
    }
}
