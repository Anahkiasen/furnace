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
        $meta  = Arr::get($file, 'meta', '');
        $meta  = (array) json_decode($meta, true);
        $track = array_merge($meta, $track);

        // Create Tracker
        $tracker = Arr::get($track, 'tracker');
        if ($tracker) {
            $tracker             = Tracker::firstOrCreate(['name' => $tracker]);
            $track['tracker_id'] = $tracker->id;
        }

        $track = array_except($track, ['meta', 'tracker']);

        return $track;
    }
}
