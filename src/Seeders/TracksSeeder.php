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

        return $reader->fetchAssoc(0);
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

        return array_merge(
            array_only($track, [
                'file',
                'presilence',
                'normalized_volume',
                'live',
                'playable',
                'tone',
                'track',
                'tab'
            ]),
            array_only($meta, [
                'artist',
                'album',
                'parts',
                'tuning',
                'version',
            ]),
            [
                'dd'                => array_get($meta, 'dd', 'no') == 'yes',
                'name'              => array_get($meta, 'title'),
                'tracker_id'        => $tracker->id,
                'created_at'        => array_get($meta, 'added'),
                'updated_at'        => array_get($meta, 'updated'),

            ]
        );
    }
}
